<?php

namespace App\Exports\Followup;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use App\Models\Batch;
use App\Models\Followup;

class FollowedFollowupExport implements FromCollection, WithHeadings
{
    public $batch;
    public function __construct($batch)
    {
        $this->batch=$batch;
    }

    public function collection()
    {
        $batch=$this->batch;
        $users=$batch->followup->map(function ($followup,$i=0){

            $courses=$followup->user->bookings->map(function ($book) {
                return $book->batch->course->name ?? '';
            })->toArray();

            $courses=implode(", ",array_unique($courses));
            $i++;
            return (object)[
                // 'user_id'=>$followup->user->id ?? '',
                'sn'=>$i,
                'name'=>$followup->user->name ?? '',
                'email'=>$followup->user->email ?? '',
                'contact'=>$followup->user->contact ?? '',
                'district'=>$followup->user->district ?? '',
                'interests'=>$followup->user->interests ?? '',
                'courses'=>$courses,
                'remarks'=>$followup->remarks,
            ];
        });

        return $users;
    }

    public function headings(): array
    {
        return ["SN", "Name", "Email","Contact","District","Interested Courses","Prev. Booked Courses","Remarks"];
    }
}
