<?php

namespace App\Models;

use App\Models\Reports\ReportBooking;
use App\Models\Reports\ReportCourseBatches;
use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Vendors\VendorBooking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    protected $guarded=[];

   protected static function boot()
   {
       parent::boot();

       static::created(function($booking) {
           $total=Booking::where('batch_id','=',$booking->batch_id)->count();
           $verified=Booking::where('batch_id','=',$booking->batch_id)->where('status','=','Verified')->count();
           ReportCourseBatches::where('batch_id','=',$booking->batch_id)
               ->update([
                   'totalstds'=>$total,
                   'verifiedstds'=>$verified,
               ]);

           ReportBooking::create([
               'batch_id'=>$booking->batch_id,
               'booking_id'=>$booking->id,
               'name'=>$booking->user->name,
               'email'=>$booking->user->email ?? '',
               'contact'=>$booking->user->contact ?? '',
               'amount'=>$booking->paymentAmount ?? '0',
               'mode'=>$booking->verificationMode ?? '',
               'account'=>$booking->accountNo ?? '',
               'status'=>$booking->status ?? 'Unverified',
           ]);
       });

       static::updated(function($booking) {
           $total=Booking::where('batch_id','=',$booking->batch_id)->count();
           $verified=Booking::where('batch_id','=',$booking->batch_id)->where('status','=','Verified')->count();
           ReportCourseBatches::where('batch_id','=',$booking->batch_id)
               ->update([
                   'totalstds'=>$total,
                   'verifiedstds'=>$verified,
               ]);

           ReportBooking::where('booking_id','=',$booking->id)
               ->update([
                   'contact'=>$booking->user->contact ?? '',
                   'amount'=>$booking->paymentAmount ?? '0',
                   'mode'=>$booking->verificationMode ?? '',
                   'account'=>$booking->accountNo ?? '',
                   'status'=>$booking->status ?? '',
               ]);
       });

       static::deleted(function($booking) {
           $total=Booking::where('batch_id','=',$booking->batch->id)->count();
           $verified=Booking::where('batch_id','=',$booking->batch->id)->where('status','=','Verified')->count();
           ReportCourseBatches::where('batch_id','=',$booking->batch->id)
               ->update([
                   'totalstds'=>$total,
                   'verifiedstds'=>$verified,
               ]);

           ReportBooking::where('booking_id','=',$booking->id)
               ->update(['status'=>'Deleted']);
       });

   }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function course(): BelongsTo
    {
        return$this->belongsTo(Course::class,'course_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class,'batch_id');
    }

    public function vendorBooking(): HasOne
    {
        return $this->hasOne(VendorBooking::class, 'booking_id');
    }
}
