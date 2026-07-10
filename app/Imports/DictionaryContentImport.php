<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use App\Models\Categories as Dictionary;

class DictionaryContentImport implements ToModel, WithHeadingRow
{
        
    public function model(array $row)
    {
        if(isset($row['title'])  && isset($row['content']))
        {
            return new Dictionary([
                'name' => $row['title'],
                'description' => $row['content'],
                'type' => 'health_dictionary',
                'status' => 'Active',
            ]);

        }
        else
        {
            dd('INVALID FORMAT. PLEASE CHECK YOUR UPLOAD FORMAT.');
        }
    }
}
