<?php

namespace App\Exports\Exams;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Exams\Exam;

class ExamQuestionExport implements FromCollection, WithHeadings
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
        $questions = $exam->questions->map(function($que,$i=0)
        {
            $i++;
            return (object)[
                'sn'=>$i,
                'question' => strip_tags(str_replace('<', '  <', html_entity_decode($que->name))),
                'opt_a' => strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_a))),
                'opt_b' => strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_b))),
                'opt_c' => strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_c))),
                'opt_d' => strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_d))),
                'opt_correct' =>$que->opt_correct,                
            ];
        });
        // dd($questions);
        $i=0;
        return $questions;
    }

    public function headings(): array
    {
        return ["SN", "Question", "Option A","Option B","Option C","Option D","Correct Option"];
    }
}
