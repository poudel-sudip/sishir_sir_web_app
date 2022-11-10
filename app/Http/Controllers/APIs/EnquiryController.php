<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\StudentEnquiry;

class EnquiryController extends Controller
{
    public function saveEnquiry(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'contact'=>['required','numeric','digits:10'],
            'district'=>['required','string'],
            'provience'=>['required','string'],
            'course'=> 'required|min:1|numeric',
            'message' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()], 400);
        }

        $enquiry = StudentEnquiry::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'course_id'=>$request->course,
            'message'=>$request->message,
            'provience'=>$request->provience ?? '',
            'district'=>$request->district ?? '',
        ]);

        return response()->json([
            'message'=>'Your Query Has Been Submitted.',
            'enquiry'=>$enquiry,
        ]);
    }
}
