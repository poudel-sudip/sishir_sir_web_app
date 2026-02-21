<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Carbon\Carbon;
use Anuzpandey\LaravelNepaliDate\LaravelNepaliDate;

class HealthDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'date',
        'title',
        'pdf_file',
        'description',
        'author_name',
        'author_image',
        'thumbnail_image',
        'sorting_date',
    ];

    protected $appends = ['event_date'];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
   
    public function slogans(): HasMany
    {
        return $this->hasMany(Categories::class, 'parent_id')->where('type','=','health-day-slogan');
    }

    public function getEventDateAttribute()
    {
        if (!$this->sorting_date) {
            return null;
        }
        $parts = explode(':', $this->sorting_date);
        if (count($parts) != 2) {
            return null;
        }

        $month = (int) $parts[0];
        $day   = (int) $parts[1];
        $year = now()->year;

        //If AD (month 01-12)
        if ($month >= 1 && $month <= 12) {

            try {
                return Carbon::createFromDate($year, $month, $day)
                    ->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        //If BS (month 13-24)
        if ($month >= 13 && $month <= 24) {

            $bsYear = LaravelNepaliDate::from(now()->format('Y-m-d'))->toNepaliDate(format: 'Y');
            $bsMonth = $month - 12;

            try {
                $bsDate = $bsYear . '-' . str_pad($bsMonth, 2, '0', STR_PAD_LEFT) . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);

                return LaravelNepaliDate::from($bsDate)->toEnglishDate();
            } catch (\Exception $e) {
                return null;
            }
        }

        return null;

    }

}
