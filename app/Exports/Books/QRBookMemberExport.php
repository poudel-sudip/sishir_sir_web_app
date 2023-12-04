<?php

namespace App\Exports\Books;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class QRBookMemberExport implements FromCollection, WithHeadings
{

    public $book;
    public function __construct($book)
    {
        $this->book = $book;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $book = $this->book;
        $members = $book->scanMembers->map(function($result,$i=0) use($book)
        {
            $i++;
            return (object)[
                'sn'=>$i,
                'book_link'=>$result->book_link,
                'name'=>$result->name,
                'email'=>$result->email,
                'contact'=>$result->contact,
                'provience'=>$result->provience,
                'district'=>$result->district,
                'date'=>$result->scan_date,
            ];
        });
        // dd($members);
        $i=0;
        return $members;
    }

    public function headings(): array
    {
        return ["SN","Book Link", "Name", "Email","Contact","Provience","District","Date"];
    }
}
