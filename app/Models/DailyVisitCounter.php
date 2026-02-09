<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyVisitCounter extends Model
{
    use HasFactory;
    protected $fillable = ['visit_date', 'view_count','download_count','share_count'];

}
