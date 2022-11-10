<?php

namespace App\Exports\Forms;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Forms\VendorForm;

class VendorFormApplicantExport implements FromCollection, WithHeadings
{

    public $vform;
    public function __construct($vform)
    {
        $this->vform = $vform;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $vform = $this->vform;
        $applicants = $vform->applicants->map(function($applicant,$i=0) use($vform) {
            $i++;
            return (object)[
                'sn'=>$i,
                'category'=>ucwords($vform->title),
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
