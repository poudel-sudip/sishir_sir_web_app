<?php

namespace App\Exports\Forms;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Forms\DynamicFormCategory;
use App\Models\Forms\FormApplicant;

class FormApplicantExport implements FromCollection, WithHeadings
{

    public $category;
    public function __construct($category)
    {
        $this->category = $category;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $category = $this->category;
        $applicants = $category->applicants->map(function($applicant,$i=0) use($category) {
            $i++;
            return (object)[
                'sn'=>$i,
                'category'=>ucwords($category->name),
                'sub_category'=>ucwords($applicant->sub_category),
                'name'=>ucwords($applicant->name),
                'email'=>$applicant->email,
                'contact'=>$applicant->contact,
                'provience'=>$applicant->provience,
                'district'=>$applicant->district,
                'message'=>$applicant->message,
                'remarks'=>$applicant->remarks,
                'uploaded_by'=>$applicant->uploaded_by,
                'created_at'=>date('Y-m-d H:i a',strtotime($applicant->created_at)),
                'updated_at'=>date('Y-m-d H:i a',strtotime($applicant->updated_at)),
            ];
        });
        $i = 0;
        return $applicants; 
    }

    public function headings(): array
    {
        return ["SN","Category Course","Sub Course","Name","Email","Contact","Provience","District","Message","Remarks","Uploaded By","Created Date","Updated Date"];
    }
}
