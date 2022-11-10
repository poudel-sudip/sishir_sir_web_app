<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Forms\VendorForm;
use App\Models\Forms\VendorFormApplicant;

class VendorFormApplicantImport implements ToModel, WithHeadingRow
{
    public $vform;
    public function __construct($vform)
    {
        $this->vform = $vform;
    }
    
    public function model(array $row)
    {
        $vform = $this->vform;

        $data = array_merge(([
            'sub_category' => '',
            'name' => '',
            'email' => '',
            'contact' => '',
            'provience' => '',
            'district' => '',
            'message' => '',
            'remarks' => '',
            'uploaded_by' => '',
        ]),$row); 

        // dd($row,$data,$category);
        if($data['name'])
        {
            return new VendorFormApplicant([
                'vendor_id' => $vform->vendor_id ?? '',
                'form_id' => $vform->id,
                'sub_category' => $data['sub_category'],
                'name' => $data['name'],
                'email' => $data['email'].' ',
                'contact' => $data['contact'].' ',
                'provience' => $data['provience'],
                'district' => $data['district'],
                'message' => $data['message'],
                'remarks' => $data['remarks'],
                'uploaded_by' => $data['uploaded_by'],
            ]);
        }
        else
        {
            return null;
        }
    }
}
