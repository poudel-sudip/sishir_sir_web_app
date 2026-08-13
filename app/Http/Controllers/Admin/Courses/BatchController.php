<?php

namespace App\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Batch;
use App\Models\Course;
use App\Models\ClassFiles as ClassFile;
use App\Models\ClassVideos as ClassVideo;
use App\Models\BatchCurriculum;
use App\Models\Exams\BatchExam;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;

class BatchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('display');
    }

    public function display(Course $course)
    {
        $batches = $course->batches()
        ->whereIn('status',['Active','Running'])
        ->get(['id','name','slug','fee','discount','status']);
    
        return response()->json([
            'batches' => $batches,
            'success' => true,
        ]);
    }

    public function index(Course $course)
    {
        $data = [];
        $data['course'] = $course;
        $data['batches'] = $course->batches()
        ->withCount('bookings','classFiles','classVideos')
        ->orderByDesc('id')
        ->get();

        return view('admin.courses.batch.index',$data);
    }

    public function create(Course $course)
    {
        $data['course'] = $course;
        return view ('admin.courses.batch.create',$data);
    }

    public function store(Course $course)
    {
        $data = request()->validate([
            'name'=>'string | required',
            'description'=>'string',
            'fee'=>'integer | required',
            'discount'=>'integer | required',
            'duration'=>'integer | nullable',
            'durationType'=>'string | nullable',
            'startDate'=>'date | nullable',
            'endDate'=>'date | nullable',
            'timeSlot'=>'string|nullable',
            'classroomLink'=>'string|nullable',
            'status'=>'string|nullable',
            'image'=>'image|nullable',
        ]);

        $img = null;
        if(request()->hasFile('image'))
        {
            $img = request()->file('image')->store('uploads/courses/thumbnails','public');
        }

        $course->batches()->create([
            'name'=>$data['name'],
            'description'=>$data['description'],
            'fee'=>$data['fee'],
            'discount'=>$data['discount'],
            'duration'=>$data['duration'],
            'durationType'=>$data['durationType'],
            'startDate'=>$data['startDate'],
            'endDate'=>$data['endDate'],
            'timeSlot'=>$data['timeSlot'] ?? '',
            'classroomLink'=>$data['classroomLink'],
            'status'=>$data['status'],
            'image'=>$img,
        ]);

        return redirect('/admin/courses/'.$course->id.'/batches');
    }

    public function show(Course $course, Batch $batch)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;

        return view('admin.courses.batch.show',$data);
    }

    public function edit(Course $course, Batch $batch)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        return view ('admin.courses.batch.edit', $data);
    }

    public function update(Course $course, Batch $batch)
    {
        // dd(request()->all());
        $data = request()->validate([
            'name'=>'string | required',
            'description'=>'string',
            'fee'=>'integer | required',
            'discount'=>'integer | required',
            'duration'=>'integer | required',
            'durationType'=>'string',
            'startDate'=>'date',
            'endDate'=>'date',
            'timeSlot'=>'string|nullable',
            'classroomLink'=>'nullable',
            'status'=>'required',
            'image'=>'image|nullable',
            'old_image'=>'string|nullable',
        ]);

        $img = $data['old_image'];
        if(request()->hasFile('image'))
        {
            $img = request()->file('image')->store('uploads/courses/thumbnails','public');
        }

        $batch->update([
            'name'=>$data['name'],
            'description'=>$data['description'],
            'fee'=>$data['fee'],
            'discount'=>$data['discount'],
            'duration'=>$data['duration'],
            'durationType'=>$data['durationType'],
            'startDate'=>$data['startDate'],
            'endDate'=>$data['endDate'],
            'timeSlot'=>$data['timeSlot'] ?? '',
            'classroomLink'=>$data['classroomLink'],
            'status'=>$data['status'],
            'image'=>$img,
        ]);


        return redirect('/admin/courses/'.$course->id.'/batches');
    }

    public function destroy(Course $course, Batch $batch)
    {
        if($batch->bookings()->count() > 0){
            abort(403,'Batch has bookings. cannot be deleted');
        }

        $batch->bookings()->delete();
        $batch->classFiles()->delete();
        $batch->classVideos()->delete();
        $batch->delete();

        return redirect('/admin/courses/'.$course->id.'/batches');
    }

    public function fileIndex(Course $course, Batch $batch)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        $data['files'] = $batch->classFiles()->orderBy('created_at')->get();

        return view('admin.courses.batch.files',$data);
    }

    public function fileStore(Course $course, Batch $batch, Request $request)
    {
        $request->validate([
            'filetitle'=>'string | nullable',
            'userfile'=>'required | mimes:pdf',
        ]);

        $file = $request->file('userfile');
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $path = '/uploads/courses/files/batch_'.$batch->id;
        $url = $file->store($path,'public');
        $url = url('/storage/'.$url);

        $batch->classFiles()->create([
            'user_id'=>auth()->user()->id,
            'user_name'=>auth()->user()->name,
            'fileTitle'=>$request->filetitle ?? $filename,
            'filePath'=>$url,
        ]);

        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/files');
    }

    public function fileUpdate(Course $course, Batch $batch, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'file_id' => 'numeric|required',
            'file_title' => 'nullable|string',
            'old_file' => 'string|nullable',
            'new_file' => 'nullable|file|mimes:pdf,docx,doc',
        ]);

        $cfile = ClassFile::where('id','=',$request->file_id)->first();

        if($cfile)
        {
            $url = $request->old_file;
            $filename = $request->file_title;
            
            if(!$filename && !isset($request->new_file))
            {
                return back()->withInput()->withErrors(['file_title'=>'File Title is Required.']);
            }
            
            if(isset($request['new_file']))
            {
                $file = $request->file('new_file');
                if(!$filename)
                {
                    $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                }

                $path = '/uploads/courses/files/batch_'.$batch->id;
                $url = $file->store($path,'public');
                $url = url('/storage/'.$url);
            }
            
            $cfile->update([
                'user_id'=>auth()->user()->id,
                'user_name'=>auth()->user()->name,
                'fileTitle'=>$filename,
                'filePath'=>$url,
            ]);
        }

        
        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/files')->with('success','Data Updated Successfully');
    }

    public function fileDestroy(Course $course, Batch $batch, ClassFile $cfile, Request $request)
    {
       
        if($cfile)
        {
            $cfile->delete();
        }
        
        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/files')->with('success','Data Deleted Successfully');
    }

    public function videoIndex(Course $course, Batch $batch)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        $data['videos'] = $batch->classVideos()->orderBy('created_at')->get();

        return view('admin.courses.batch.videos',$data);
    }


    public function videoStore(Course $course, Batch $batch, Request $request)
    {
        $request->validate([
            'videotitle'=>'string | required',
            'uservideo'=>'string | required',
        ]);

        $videoKey = $this->retriveVideoKey($request->uservideo);

        $batch->classVideos()->create([
            'user_id'=>auth()->user()->id,
            'user_name'=>auth()->user()->name,
            'videoTitle'=>$request['videotitle'],
            'videoPath'=>$request['uservideo'],
            'videoKey'=>$videoKey,
        ]);
        
        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/videos');
    }


    public function videoUpdate(Course $course, Batch $batch, Request $request)
    {
        $request->validate([
            'video_id' => 'numeric|required',
            'video_title' => 'string|required',
            'video_url' => 'string|required',
        ]);

        $video = ClassVideo::where('id','=',$request->video_id)->first();

        if($video)
        {
            $videoKey = $this->retriveVideoKey($request->video_url);     
            $video->update([
                'user_id'=>auth()->user()->id,
                'user_name'=>auth()->user()->name,
                'videoTitle'=>$request['video_title'],
                'videoPath'=>$request['video_url'],
                'videoKey'=>$videoKey,
            ]);
        }
                
        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/videos');
    }

    public function videoDestroy(Course $course, Batch $batch, ClassVideo $cvideo, Request $request)
    {
       
        if($cvideo)
        {
            $cvideo->delete();
        }
        
        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/videos')->with('success','Data Deleted Successfully');
    }

    private function retriveVideoKey($url)
    {
        $id = '';

        if (strpos($url, 'youtube.com') !== false) {

            if (strpos($url, 'live') !== false) {
                $id = explode('live/', $url)[1];
                $id = explode('?', $id)[0]; 
            }
            else {
                parse_str(parse_url($url, PHP_URL_QUERY), $queryParams);
                $id = $queryParams['v'] ?? '';
            }          
            
        } else if (strpos($url, 'youtu.be') !== false) {
            $id = explode('youtu.be/', $url)[1];
            $id = explode('?', $id)[0]; 
        } else if (strpos($url, 'vimeo.com') !== false) {
            $id = explode('vimeo.com/', $url)[1];
        }

        return $id;
    }
    

    public function curriculumIndex(Course $course, Batch $batch)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        $data['curriculums'] = $batch->curriculums()->orderBy('title')->get()->values();

        return view('admin.courses.curriculum.index',$data);
    }

    public function curriculumCreate(Course $course, Batch $batch)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;

        return view('admin.courses.curriculum.create',$data);
    }

    public function curriculumStore(Course $course, Batch $batch, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'course'=>'string | required',
            'batch'=>'string | required',
            'curriculum_title'=>'string | required',
            'is_heading'=>'required|boolean|in:0,1',
            'description'=>'string | nullable',
            'curriculum_file'=>'required | mimes:pdf',
            'status'=>'required|boolean|in:0,1',
        ]);

        $file = $request->file('curriculum_file');

        $path = '/uploads/courses/files/batch_'.$batch->id;
        $url = $file->store($path,'public');
        $url = url('/storage/'.$url);

        $batch->curriculums()->create([
            'user_id'=>auth()->user()->id,
            'title'=>$request->curriculum_title,
            'description'=>$request->description,
            'pdf_file'=>$url,
            'is_heading'=>$request->is_heading,
            'status'=>$request->status,
        ]);

        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/curriculum');
    }

    public function curriculumShow(Course $course, Batch $batch, BatchCurriculum $curriculum, Request $request)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        $data['curriculum'] = $curriculum;       
        // dd($data);
        return view('admin.courses.curriculum.show',$data);
    }

    public function curriculumEdit(Course $course, Batch $batch, BatchCurriculum $curriculum, Request $request)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        $data['curriculum'] = $curriculum;       
        
        return view('admin.courses.curriculum.edit',$data);
    }

    public function curriculumUpdate(Course $course, Batch $batch, BatchCurriculum $curriculum, Request $request)
    {
        // dd($request->all(), $curriculum);
        $request->validate([
            'course'=>'string | required',
            'batch'=>'string | required',
            'curriculum_title'=>'string | required',
            'is_heading'=>'required|boolean|in:0,1',
            'description'=>'string | nullable',
            'curriculum_file'=>'nullable | mimes:pdf',
            'old_curriculum_file'=>'string | nullable',
            'status'=>'required|boolean|in:0,1',
        ]);

        $url = $request->old_curriculum_file;
        if(isset($request['curriculum_file']))
        {
            $file = $request->file('curriculum_file');              

            $path = '/uploads/courses/files/batch_'.$batch->id;
            $url = $file->store($path,'public');
            $url = url('/storage/'.$url);
        }

        $curriculum->update([
            'user_id'=>auth()->user()->id,
            'title'=>$request->curriculum_title,
            'description'=>$request->description,
            'pdf_file'=>$url,
            'is_heading'=>$request->is_heading,
            'status'=>$request->status,
        ]);

        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/curriculum')->with('success','Data Updated Successfully');
    }

    public function curriculumDestroy(Course $course, Batch $batch, BatchCurriculum $curriculum, Request $request)
    {
       
        if($curriculum)
        {
            $curriculum->delete();
        }
        
        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/curriculum')->with('success','Data Deleted Successfully');
    }

    public function McqExamIndex(Course $course, Batch $batch)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        $data['mcq_exams'] = $batch->batchExams()->get()->values();

        return view('admin.courses.mcq-exams.index',$data);
    }

    public function McqExamCreate(Course $course, Batch $batch)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        $data['categories'] = ExamCategory::all();
        return view('admin.courses.mcq-exams.create',$data);
    }

    public function McqExamStore(Course $course, Batch $batch, Request $request)
    {
        // dd($request->all());
        $request->validate([
            'exam_name'=>'required|numeric|min:1',
            'exam_type'=>'required|numeric',
        ]);
        $find = $batch->batchExams()->where('exam_id', $request->exam_name)->first();
        if($find)
        {
            return back()->withInput()->withErrors(['exam_name'=>'Exam already associated for this batch.']);
        }
        $batch->batchExams()->create([
            'exam_id'=>$request->exam_name,
            'is_final_exam'=>$request->exam_type,
        ]);

        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/mcq-exams');
    }

    public function McqExamDestroy(Course $course, Batch $batch, BatchExam $exam, Request $request)
    {
        $results = $exam->exam->results()->where('batch_id','=',$batch->id);
        $evaluations = $exam->exam->evaluations()->where('batch_id','=',$batch->id);
        
        $results->delete();
        $evaluations->delete();
        $exam->delete();

        return redirect('/admin/courses/'.$course->id.'/batches/'.$batch->id.'/mcq-exams');
    }

    public function McqExamResult(Course $course, Batch $batch, Exam $exam)
    {
        $data['course'] = $course;
        $data['batch'] = $batch;
        $data['exam'] = $exam;
        $data['results'] = $batch->results;

        return view('admin.courses.mcq-exams.result', $data);
    }

}
