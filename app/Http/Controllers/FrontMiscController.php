<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\Helper;
use App\Models\Categories as Category;
use App\Models\HealthDay;
use App\Models\DailyVisitCounter;
use Storage;
use Number;

class FrontMiscController extends Controller
{
    public function childNutritionCalculator(Request $request)
    {
        // dd($request->all(),'Hello');

        $zScoreHeightData = null;
        $zScoreMuacData = null;
        $zScoreEdemaData = null;
        $height = null;
        $median = null;
        $gender = null;
        $agegroup = null;
        $muac = null;
        $edema = null;

        if(isset($request->edema) && trim($request->edema) && in_array($request->edema, ['p0', 'p1','p2','p3']))
        {
            $edema = trim($request->edema);
        }

        if(isset($request->muac) && trim($request->muac) && is_numeric($request->muac) && (float)$request->muac > 0)
        {
            $muac = (float)$request->muac;
        }

        if(isset($request->height) && trim($request->height) && is_numeric($request->height) && (float)$request->height > 0)
        {
            $height = (float)$request->height;
        }

        if(isset($request->weight) && trim($request->weight) && is_numeric($request->weight) && (float)$request->weight > 0)
        {
            $median = (float)$request->weight;
        }

        if(isset($request->gender) && trim($request->gender) && in_array($request->gender, ['male', 'female']))
        {
            $gender = strtolower(trim($request->gender));
        }

        if(isset($request->agegroup) && trim($request->agegroup) && in_array($request->agegroup, ['0_23_months', '24_59_months']))
        {
            $agegroup = strtolower(trim($request->agegroup));
        }

        if($height && $median && $gender && $agegroup)
        {
            $zScoreHeightData = (object) $this->zScoreFinder($height, $median, $gender, $agegroup);
            if(!$zScoreHeightData->success)
            {
                abort(403, $zScoreHeightData->message);
            }
            $zScoreHeightData = (object) $zScoreHeightData->data;
        }

        if($muac && $gender && $agegroup)
        {
            $mcase = '';
            $mrem = '';
            if($muac < 115)
            {
                // Severe Malnutrition
                $mcase = 'severe_abnormal';
                $mrem = '
                <div>Severe acute malnutrition</div>
                <div>Immediate medical attention is required.</div>
                ';
            }
            else if(($muac >= 115) && ($muac < 125))
            {
                // Moderate Malnutrition
                $mcase = 'moderate_abnormal';
                $mrem = '
                <div>Moderate acute malnutrition</div>
                <div>Medical attention is required.</div>
                ';
            }
            else if($muac >= 125)
            {
                // Normal
                $mcase = 'normal';
                $mrem = '
                <div>Normal</div>
                <div>Child is healthy.</div>';
            }
            else
            {
                abort(403, 'Invalid MUAC value provided.');
            }

            $zScoreMuacData = (object) [
                'input_muac' => $muac,
                'input_gender' => $gender,
                'input_agegroup' => $agegroup,
                'output_case' => $mcase,
                'output_remarks' => $mrem,
            ];
        }

        if($edema)
        {
            $edemaCases = [
                'p0' => 'No nutritional edema: 0',
                'p1' => 'Nutritional edema on feet: +',
                'p2' => 'Nutritional edema on feet, legs and hands: ++',
                'p3' => 'Nutritional edema involving face and whole body: +++',
            ];

            if(!array_key_exists($edema, $edemaCases))
            {
                abort(403, 'Invalid Edema value provided.');
            }

            $mrem = '
                <div>' . ($edema == 'p0' ? 'Child is healthy.' : 'Child is unhealthy.') . '</div>
                <div>' . $edemaCases[$edema] . '</div>
            ';
            $zScoreEdemaData = (object) [
                'output_case' => $edema == 'p0' ? 'normal' : 'abnormal',
                'output_remarks' => $mrem,
            ];
        }

        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtitle = 'Child Nutrition Calculator';
        $counterData = Helper::pageCounterCounts($pgtitle,$pgurl);

        // dd($zScoreHeightData);
        return view('front.child_nutrition_calculator',compact('zScoreHeightData','zScoreMuacData','zScoreEdemaData','counterData'));
    }

    public function zScoreFinder($height,$median,$gender,$agegroup)
    {
        if($gender == 'male' && $agegroup == '0_23_months')
        {
            $filepath = public_path('admin/files/z-scores/wfh_boys_0-to-2-years_zscores.xlsx');
        }
        else if($gender == 'male' && $agegroup == '24_59_months')
        {
            $filepath = public_path('admin/files/z-scores/wfh_boys_2-to-5-years_zscores.xlsx');
        }
        else if($gender == 'female' && $agegroup == '0_23_months')
        {
            $filepath = public_path('admin/files/z-scores/wfh_girls_0-to-2-years_zscores.xlsx');
        }
        else if($gender == 'female' && $agegroup == '24_59_months')
        {
            $filepath = public_path('admin/files/z-scores/wfh_girls_2-to-5-years_zscores.xlsx');
        }
        else
        {
            return [
                'success' => false,
                'message' => 'Invalid parameters provided for Z Score calculation.',
            ];
        }

        if (!file_exists($filepath)) {
            return [
                'success' => false,
                'message' => 'Z Score Excel File Not Found.',
            ];
        }

        try {
            $excelfiles = Excel::toArray([], $filepath);
            $excelRows = $excelfiles[0];
            if (count($excelRows) < 2) {
                return [
                    'success' => false,
                    'message' => 'Z Score Excel file Records is Empty.',
                ];
            }
            $headers = $excelRows[0];
            $headers = array_map('trim', $headers);

            if(!in_array('Height',$headers) || !in_array('M', $headers) || !in_array('SD3neg', $headers) || !in_array('SD2neg', $headers) || !in_array('SD1neg', $headers) )
            {
                return [
                    'success' => false,
                    'message' => 'Invalid Z Score Excel file format. Parameters Height, M, SD3neg, SD2neg, SD1neg are missing.',
                ];
            }

            $records = [];
            foreach (array_slice($excelRows, 1) as $row) {
                $records[] = array_combine($headers, $row);
            }
            
            $records = collect($records);

            $selectedRecord = $records->firstWhere('Height', $height);
            if(!$selectedRecord) 
            {
                $records = $records->filter(function ($record) {
                    return is_numeric($record['Height']);
                });

                $records = $records->sortBy(function ($record) {
                    return abs($record['Height']);
                });

                $selectedRecord = $records->sortBy(function ($record) use ($height) {
                    return abs($record['Height'] - $height);
                })->first();
            }

            $selectedRecord['input_height'] = (double)$height;
            $selectedRecord['input_median'] = (double)$median;
            $selectedRecord['input_gender'] = $gender;
            $selectedRecord['input_agegroup'] = $agegroup;

            if($selectedRecord['input_median'] <= $selectedRecord['SD3neg'])
            {
                // Below SD3neg
                $selectedRecord['output_case'] = 'severe_abnormal';
                $selectedRecord['output_remarks'] = '
                <div>Severe acute malnutrition</div>
                <div>Immediate medical attention is required.</div>
                ';
            }
            else if(($selectedRecord['input_median'] > $selectedRecord['SD3neg']) && ($selectedRecord['input_median'] <= $selectedRecord['SD2neg']))
            {
                // Between SD3neg and SD2neg
                $selectedRecord['output_case'] = 'moderate_abnormal';
                $selectedRecord['output_remarks'] = '
                <div>Moderate acute malnutrition</div>
                <div>Medical attention is required.</div>
                ';
            }
            else if(($selectedRecord['input_median'] > $selectedRecord['SD2neg']))
            {
                // Above SD2neg 
                $selectedRecord['output_case'] = 'normal';
                $selectedRecord['output_remarks'] = '
                <div>Normal</div>
                <div>Child is healthy.</div>';
            }
            else
            {
                return [
                    'success' => false,
                    'message' => 'Invalid Z Score Excel file format.',
                ];
            }
            
            return [
                'success' => true,
                'message' => 'Z Score calculated successfully.',
                'data' => $selectedRecord,
            ];

        } 
        catch (\Throwable $th) {
            //throw $th;
            return [
                'success' => false,
                'message' => 'Invalid Z Score Excel file format.',
            ];
        }
        
    }

    public function listFaqs(Request $request)
    {
        $faqs = Category::where('type','=','faq')
            ->where('status', 'active')
            // ->orderByDesc('id')
            ->get();

        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtitle = 'FAQ - Frequently Asked Questions';
        $counterData = Helper::pageCounterCounts($pgtitle,$pgurl);

        return view('front.faq.index', compact('faqs', 'counterData'));
    }

    public function showFaq(Request $request, $id)
    {
        $faq = Category::where('type','=','faq')
            ->where('status','=','active')
            ->where('id','=',$id)
            ->first();

        if(!$faq)
        {
            abort(404, 'FAQ not found.');
        }

        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = 'article';
        $counterData = Helper::pageCounterCounts($faq->name,$pgurl,$pgtype);

        return view('front.faq.show', compact('faq', 'counterData'));
    }
        

    public function healthDaysList(Request $request)
    {        
        $selectedCategoryId = null;

        $healthDays = HealthDay::orderBy('sorting_date', 'asc')
            ->get(['id','title','date','category_id'])
            ->values();       

        if($request->has('selected') && trim($request->selected) && is_numeric($request->selected))
        {
            if(in_array((int)$request->selected,$healthDays->pluck('category_id')->unique()->toArray()))
            {
                $selectedCategoryId = (int)$request->selected;
            }   
        }

        $data['healthDays'] = json_encode($healthDays);
        $data['healthCategories'] = Category::where('type','=','health-day-category')->get();
        $data['selectedCategoryId'] = $selectedCategoryId;

        // dd($data);
        return view('front.health_days.index', $data);
    }

    public function showHealthDay(Request $request, $id)
    {
        $healthDay = HealthDay::where('id', '=', $id)
            ->first();

        if(!$healthDay)
        {
            abort(404, 'Health Day not found.');
        }

        $healthDay->slogan_list = $healthDay->slogans()
        ->where('type','=','health-day-slogan')
        ->orderBy('name','desc')
        ->get(['name as year','description as title'])
        ->values();

        $pdf_size = "0 KB";
        try {
            $pdf_size = Storage::disk('public')->size($healthDay->pdf_file);
            $pdf_size = Number::fileSize($pdf_size);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $healthDay->pdf_size = $pdf_size;

        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = 'article';
        $counterData = Helper::pageCounterCounts($healthDay->title, $pgurl, $pgtype);

        // dd($healthDay,$counterData,$pgurl);
        return view('front.health_days.show', compact('healthDay', 'counterData'));
    }

    public function webAnalytics(Request $request)
    {
        $data = [];
        $data['web_counter'] = Helper::websiteCounter();  
        $data['daily_visits'] = DailyVisitCounter::orderByDesc('id')
        ->take(30)
        ->get(['id','visit_date as date','view_count as view'])
        ->sortBy('id')
        ->values();

        // dd($data);
        return view('front.web-analytics',$data);
    }

    public function dictionaryIndex(Request $request)
    {
        $dictionary = Category::where('type','=','health_dictionary')
            ->where('status', 'active')
            ->orderBy('name')
            ->take(10)
            ->get(['id','name','description','created_at']);

        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtitle = 'Health Dictionary';
        $counterData = Helper::pageCounterCounts($pgtitle,$pgurl);

        return view('front.dictionary.index', compact('dictionary', 'counterData'));
    }

    public function dictionarySearch(Request $request)
    {
        $query = trim($request->query('query', ''));
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a search term.',
                'data' => [],
            ]);
        }

        $builder = Category::where('type', 'health_dictionary')
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "{$query}%");
                // ->orWhere('description', 'LIKE', "%{$query}%");
            });

        $total = (clone $builder)->count();

        $dictionary = $builder
        ->orderBy('name')
        ->limit(10)
        ->get([
            'id',
            'name',
            'description',
            'created_at',
        ]);

        $dictionary->transform(function ($item) {
            $item->description = Helper::prepareHtmlContent($item->description);

            return $item;
        });

        return response()->json([
            'success' => $dictionary->isNotEmpty(),
            'message' => $dictionary->isNotEmpty()
                ? "{$total} result(s) found."
                : "No matching records found.",
            'data' => $dictionary,
        ]);
       
        
    }
}
