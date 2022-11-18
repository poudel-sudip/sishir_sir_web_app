<?php

namespace App\Imports;

use App\Models\Exams\Question;
use App\Models\Exams\Exam;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ExamQuestionsImport implements ToModel, WithHeadingRow
{
    public $exam;
    public function __construct($exam)
    {
        $this->exam=$exam;
    }
    
    public function model(array $row)
    {
        $exam=$this->exam;
        if(isset($row['question'])  && isset($row['a']) && isset($row['b']) && isset($row['c']) && isset($row['d']) && isset($row['correct']))
        {
            return new Question([
                'exam_id'=>$exam->id,
                'name'=>$row['question'],
                'opt_a'=>$row['a'],
                'opt_b'=>$row['b'],
                'opt_c'=>$row['c'],
                'opt_d'=>$row['d'],
                'opt_correct'=>$row['correct'],
            ]);
        }
        else
        {
            dd('INVALID FORMAT. PLEASE CHECK YOUR UPLOAD FORMAT.');
        }
    }
}
