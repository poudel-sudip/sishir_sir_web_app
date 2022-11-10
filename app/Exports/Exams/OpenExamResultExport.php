<?php

namespace App\Exports\Exams;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\OpenExams\OpenExam;

class OpenExamResultExport implements FromCollection, WithHeadings
{

    public $exam;
    public function __construct($exam)
    {
        $this->exam = $exam;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $exam = $this->exam;
        $results = $exam->results->map(function($result,$i=0) use($exam)
        {
            $i++;
            return (object)[
                'sn'=>$i,
                'name'=>$result->name,
                'email'=>$result->email,
                'contact'=>$result->contact,
                'courses'=>$result->courses,
                'total_questions'=>strval($result->total_questions),
                'leaved_questions'=>strval($result->leaved_questions),
                'correct_questions'=>strval($result->correct_questions),
                'wrong_questions'=>strval($result->wrong_questions),
                'marks_obtained'=> strval(($result->correct_questions * ($exam->exam->marks_per_question ?? 1))-($result->wrong_questions * ($exam->exam->negative_marks ?? 0))),
                'date'=>date('Y-m-d',strtotime($result->created_at)),
            ];
        });
        // dd($results);
        $i=0;
        return $results;
    }

    public function headings(): array
    {
        return ["SN", "Name", "Email","Contact","Interested Courses","TQ","LQ","CQ","WQ","MO","Date"];
    }
}
