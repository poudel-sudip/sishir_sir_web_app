<?php

namespace App\Imports;

use App\Models\Exams\DailyMCQQuestion;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DailyQuestionsImport implements ToModel, WithHeadingRow
{
        
    public function model(array $row)
    {
        if(isset($row['question'])  && isset($row['a']) && isset($row['b']) && isset($row['c']) && isset($row['d']) && isset($row['correct']))
        {
            $max = DailyMCQQuestion::max('show_date') ?? date('Y-m-d');
            $next = date('Y-m-d', strtotime('+1 day', strtotime($max)));

            return new DailyMCQQuestion([
                'question'=>$row['question'],
                'opt_a'=>$row['a'],
                'opt_b'=>$row['b'],
                'opt_c'=>$row['c'],
                'opt_d'=>$row['d'],
                'opt_correct'=>strtoupper($row['correct']),
                'rationale'=>$row['correct'] ?? '',
                'show_date'=>$next,
            ]);
        }
        else
        {
            dd('INVALID FORMAT. PLEASE CHECK YOUR UPLOAD FORMAT.');
        }
    }
}
