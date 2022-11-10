<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OpenExams\OpenExam;
use App\Models\Exams\Question;
use App\Models\OpenExams\OpenExamResult;
use App\Models\ExamHall\ExamHallCategories;
use Illuminate\Support\Facades\Validator;

class PublicExamController extends Controller
{
    public function getPremiumExamsLists()
    {
        $premiumExams=ExamHallCategories::where('status','Active')->get()->map(function($exam){
            return [
                "id" => $exam->id,
                "title" => $exam->title,
                "slug" => $exam->slug,
                "description" => $exam->description,
                "price" => $exam->price,
                "discount" => $exam->discount,
                "image" => $exam->image,
                "status" => $exam->status,
                "no_of_sets" => $exam->category_exams->count(),
            ];
        });
        return response()->json($premiumExams, 200);
    }

    public function showPremiumExam($slug)
    {
        $exam=ExamHallCategories::where('slug','=',$slug)->first();
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        return response()->json([
            "id" => $exam->id,
            "title" => $exam->title,
            "slug" => $exam->slug,
            "description" => $exam->description,
            "price" => $exam->price,
            "discount" => $exam->discount,
            "image" => $exam->image,
            "status" => $exam->status,
            "no_of_sets" => $exam->category_exams->count(),
        ], 200);
    }

    public function getFreeExamsLists()
    {
        $exams=OpenExam::where('result_status','!=','Published')->get()->map(function($exam){
            return [
                "exam_id" => $exam->exam_id,
                "name" => $exam->name,
                "slug" => $exam->slug,
                "result_status" => $exam->result_status,
                "attempt_link" => url('api/v1/free-exams/'.$exam->slug.'/attempt'),
            ];
        });
        return response()->json($exams, 200);
    }

    public function getFreeExamResultLists()
    {
        $exams=OpenExam::where('result_status','=','Published')->get()->map(function($exam){
            return [
                "exam_id" => $exam->exam_id,
                "name" => $exam->name,
                "slug" => $exam->slug,
                "result_status" => $exam->result_status,
                "result_link" => url('api/v1/free-exams-results/'.$exam->slug),
            ];
        });
        return response()->json($exams, 200);
    }

    public function showFreeExamResult($slug)
    {
        $exam=OpenExam::where('slug','=',$slug)->first();
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $results=$exam->results->map(function($result) use($exam) {
            $per_que = $exam->exam->marks_per_question ?? '0';
            $neg_per_que = $exam->exam->negative_marks ?? '0';
            
            return [
                'id' => $result->id,
                "name" => $result->name,
                // "email" => $result->email,
                // "contact" => $result->contact,
                // "courses" => $result->courses,
                "total_questions" => $result->total_questions,
                "leaved_questions" => $result->leaved_questions,
                "correct_questions" => $result->correct_questions,
                "wrong_questions" => $result->wrong_questions,
                "marks_obtained" => ($result->correct_questions * $per_que) - ($result->wrong_questions * $neg_per_que),
            ];
        });

        return response()->json([
            'exam' => [
                'exam_id' => $exam->exam->id ?? '',
                'exam_name' => $exam->exam->name ?? '',
                'exam_slug' => $exam->slug ?? '',
                'exam_description' => $exam->exam->description,
                'exam_time' => ($exam->exam->exam_time ?? '').':00',
                'marks_per_question' => $exam->exam->marks_per_question ?? '',
                'negative_marks_per_question' => $exam->exam->negative_marks ?? '',
                'total_questions' => $exam->exam->questions->count() ?? '',
            ],
            'results' => $results,
        ], 200);
    }

    public function attemptFreeExam($slug)
    {
        $openexam=OpenExam::where('slug','=',$slug)->first();
        if(!$openexam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }
        $exam = $openexam->exam;
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        return response()->json([
            'exam_id' => $openexam->id,
            'exam_name' => $exam->name,
            'exam_slug' => $openexam->slug,
            'exam_description' => $exam->description,
            'exam_time' => $exam->exam_time.':00',
            'marks_per_question' => $exam->marks_per_question,
            'negative_marks_per_question' => $exam->negative_marks,
            'form_post_link' => url('api/v1/free-exams/'.$openexam->slug.'/save'),
            'total_questions' => $exam->questions->count(),
            'questions' => $exam->questions->map(function($question){
                return [
                    'id'=> $question->id,
                    'question' => $question->name,
                    'option_a' => $question->opt_a,
                    'option_b' => $question->opt_b,
                    'option_c' => $question->opt_c,
                    'option_d' => $question->opt_d,
                ];
            }),
        ], 200);
    }

    public function saveFreeExam($slug, Request $request)
    {
        $exam=OpenExam::where('slug','=',$slug)->first();
        if(!$exam)
        {
            return response()->json(['error'=>'Exam Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'user_name'=>'string | required',
            'user_email'=>'string | required',
            'user_contact'=>'string | required',
            'user_courses'=>'string | required',
            'exam_id'=>'numeric | required',
            'total_questions'=>'numeric | required',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $total_questions=$request->total_questions;
        $leaved_questions=0;
        $correct_questions=0;
        $wrong_questions=0;
        $data=$request->all();

        for ($i=1; $i <= $total_questions; $i++) { 
            if(isset($data['question-'.$i]))
            {                  
                $question=Question::where('id',$data['question-'.$i])->first();
                
                if(isset($data['answer-'.$i])){
                    if($question->opt_correct == ucwords($data['answer-'.$i]))
                    {
                        $correct_questions++;
                    }else{
                        $wrong_questions++;
                    }
                }else{
                    $leaved_questions++;
                }
            }

        }

        $result=OpenExamResult::create([
            'exam_id'=>$exam->id,
            'name'=>$request->user_name,
            'email'=>$request->user_email,
            'contact'=>$request->user_contact,
            'courses'=>$request->user_courses,
            'total_questions'=>$total_questions,
            'leaved_questions'=>$leaved_questions,
            'correct_questions'=>$correct_questions,
            'wrong_questions'=>$wrong_questions,
        ]);

        return response()->json([
            'success' => true,
            'user_exam_id' => $result->id,
            'user_name' => $result->name,
            'message' => "Your Exam Has Been Successfully Submitted. Your ID is ".$result->id,
        ], 200);
    }

}
