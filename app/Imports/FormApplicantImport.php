<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Forms\DynamicFormCategory;
use App\Models\Forms\FormApplicant;

class FormApplicantImport implements ToModel, WithHeadingRow
{
    public $category;
    public function __construct($category)
    {
        $this->category = $category;
    }
    
    public function model(array $row)
    {
        $category = $this->category;
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
            return new FormApplicant([
                'category_id' => $category->id,
                'form_id' => $category->form->id,
                'sub_category' => $data['sub_category'],
                'name' => $data['name'],
                'email' => $data['email']. ' ',
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
