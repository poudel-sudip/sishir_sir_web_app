<?php

namespace App\Imports;

use App\Models\OpenExams\OpenExam;
use App\Models\OpenExams\OpenExamQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OpenExamQuestionsImport implements ToModel, WithHeadingRow
{
    public $exam;
    public function __construct($exam)
    {
        $this->exam=$exam;
    }

    public function model(array $row)
    {
        $exam=$this->exam;
        return new OpenExamQuestion([
            
            'exam_id'=>$exam->id,
            'name'=>$row['question'],
            'opt_a'=>$row['a'],
            'opt_b'=>$row['b'],
            'opt_c'=>$row['c'],
            'opt_d'=>$row['d'],
            'opt_correct'=>$row['correct'],
        ]);
    }

}
