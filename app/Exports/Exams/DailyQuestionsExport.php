<?php

namespace App\Exports\Exams;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Exams\DailyMCQQuestion;

class DailyQuestionsExport implements FromQuery, WithHeadings, WithMapping
{    
    public function query()
    {
        return DailyMCQQuestion::orderByDesc('show_date')
            ->limit(5000);
    }

    public function headings(): array
    {
        return ["Date", "question", "a", "b", "c", "d", "correct", 'rationale'];
    }

    public function map($que): array
    {
        return [
            $que->show_date,
            strip_tags(str_replace('<', '  <', html_entity_decode($que->question))),
            strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_a))),
            strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_b))),
            strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_c))),
            strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_d))),
            $que->opt_correct,
            strip_tags(str_replace('<', '  <', html_entity_decode($que->rationale))),
        ];
    }

}



// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use App\Models\Exams\DailyMCQQuestion;

// class DailyQuestionsExport implements FromCollection, WithHeadings
// {
    
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         $questions = DailyMCQQuestion::orderByDesc('show_date')->get()->map(function($que,$i=0)
//         {
//             $i++;
//             return (object)[
//                 'sn'=>$i,
//                 'date' => $que->show_date,
//                 'question' => strip_tags(str_replace('<', '  <', html_entity_decode($que->name))),
//                 'opt_a' => strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_a))),
//                 'opt_b' => strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_b))),
//                 'opt_c' => strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_c))),
//                 'opt_d' => strip_tags(str_replace('<', '  <', html_entity_decode($que->opt_d))),
//                 'opt_correct' =>$que->opt_correct,  
//                 'rationale' => strip_tags(str_replace('<', '  <', html_entity_decode($que->rationale))),              
//             ];
//         })
//         ->sortByDesc('date')
//         ->values();
//         // dd($questions);
//         $i=0;
//         return $questions->chunk(10);
//     }

//     public function headings(): array
//     {
//         return ["SN","date", "question", "a","b","c","d","correct",'rationale'];
//         // return ["SN", "Question", "Option A","Option B","Option C","Option D","Correct Option",'Rationale'];
//     }
// }
