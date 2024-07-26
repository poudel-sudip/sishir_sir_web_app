<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook\EbookBooking as PdfBankBooking;
use App\Models\ExamHall\ExamHallBookings as ExamBooking;

class NepalPayProxyController extends Controller
{
    
    public function getPaymentInstrumentDetails(Request $request)
    {
        $nepalpay_pay_data = null;
        
        try 
        {
            $nepalpay_pay_data = (object)config('payment.nepal_pay');
        } 
        catch (\Throwable $th) {
            //throw $th;
        }

        if(!$nepalpay_pay_data)
        {
            return [];
            // return response()->json([
            //     'code' => 1,
            //     'success' => false,
            //     'message' => 'Nepal Pay Payment Configuration Error.',
            // ], 200);
        }

        $auth_sign = ($nepalpay_pay_data->apiUser.':'.$nepalpay_pay_data->apiPass);
        $auth_sign = base64_encode($auth_sign);

        try 
        {
            $data = [
                'MerchantId'=> $nepalpay_pay_data->merchantId,
                'MerchantName'=> $nepalpay_pay_data->mercahntName,
            ];

            $data['Signature'] = hash_hmac('sha512',($data['MerchantId'].$data['MerchantName']),$nepalpay_pay_data->secret);

            $apiurl = $nepalpay_pay_data->inst_url;
            $ch = curl_init($apiurl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 6); // Set a timeout
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4); // Set a connection timeout

            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic ' . $auth_sign, // Replace with your authorization header
            );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            curl_close($ch);
            
            try {
                $responseArray = json_decode($response,true);

                // $filtered_data = array_filter($responseArray['data'], function ($item) {
                //     return $item['BankType'] == 'CheckoutGateway';
                // });

                // return array_values($filtered_data);
                // $responseArray['data'] = array_values($filtered_data);

                return array_values($responseArray['data']);
                
            } 
            catch (\Throwable $th) {
                // throw $th;

                return [];
                // return response()->json([
                //     'code' => 1,
                //     'success' => false,
                //     'message' => 'Nepal Pay Payment Instruments Fetch Error.',
                // ], 200);
            }
        
        } 
        catch (\Throwable $th) {
            // throw $th;

            return [];

            // return response()->json([
            //     'code' => 1,
            //     'success' => false,
            //     'message' => 'Nepal Pay Payment Configuration Error.',
            // ], 200);
        }

        return [];
    }

    public function getServiceCharge(Request $request)
    {

    }

    public function getProcessId($amount = null ,$trans_code = null)
    {
        $nepalpay_pay_data = null;

        if($amount && $trans_code)
        {
            try 
            {
                $nepalpay_pay_data = (object)config('payment.nepal_pay');
            } 
            catch (\Throwable $th) {
                //throw $th;
            }

            if(!$nepalpay_pay_data)
            {
                return null;
            }

            $auth_sign = ($nepalpay_pay_data->apiUser.':'.$nepalpay_pay_data->apiPass);
            $auth_sign = base64_encode($auth_sign);

            try 
            {
                $data = [
                    'Amount' => trim($amount),
                    'MerchantId'=> $nepalpay_pay_data->merchantId,
                    'MerchantName'=> $nepalpay_pay_data->mercahntName,
                    'MerchantTxnId' => trim($trans_code),
                ];

                $hashsigndata = implode('',$data);
                $data['Signature'] = hash_hmac('sha512',$hashsigndata,$nepalpay_pay_data->secret);

                $apiurl = $nepalpay_pay_data->process_url;
                $ch = curl_init($apiurl);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 6); // Set a timeout
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4); // Set a connection timeout

                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . $auth_sign, // Replace with your authorization header
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $response = curl_exec($ch);
                curl_close($ch);

                try {
                    $responseArray = json_decode($response,true);

                    if($responseArray['code'] == 0)
                    {
                        $processCode = $responseArray['data']['ProcessId'];

                        return $processCode;

                        // return response()->json([
                        //     'success' => true,
                        //     'message' => $responseArray['message'],
                        //     'data' => $responseArray['data'],
                        // ], 200);
                    }
                    
                    return null;

                    // $err_msg = $responseArray['errors'];
                    // $firstErrorMessage = isset($err_msg[0]['error_message']) ? $err_msg[0]['error_message'] : 'An unknown error occurred';

                    // return response()->json([
                    //     'success' => false,
                    //     'message' => $firstErrorMessage,
                    // ], 200);

                } 
                catch (\Throwable $th) {
                    //throw $th;
                    return null;        
                }               
                
            } 
            catch (\Throwable $th) {
                //throw $th;
                return null;
            }

        }

        return null;

    }

    public function returnPaymentResponse(Request $request)
    {
        // dd($request->all());
        if(isset($request->MerchantTxnId) && trim($request->MerchantTxnId) && isset($request->GatewayTxnId) && trim($request->GatewayTxnId))
        {
            $trans_id = $request->MerchantTxnId;
            $gateway_id = $request->GatewayTxnId;
            $nepalpay_pay_data = null;
        
            try 
            {
                $nepalpay_pay_data = (object)config('payment.nepal_pay');
            } 
            catch (\Throwable $th) {
                //throw $th;
            }
    
            if(!$nepalpay_pay_data)
            {
                abort(403, 'Nepal Pay Configuration Error.');
            }
    
            $auth_sign = ($nepalpay_pay_data->apiUser.':'.$nepalpay_pay_data->apiPass);
            $auth_sign = base64_encode($auth_sign);

            try 
            {
                $data = [
                    'MerchantId'=> $nepalpay_pay_data->merchantId,
                    'MerchantName'=> $nepalpay_pay_data->mercahntName,
                    'MerchantTxnId'=> $trans_id,
                ];
    
                $data['Signature'] = hash_hmac('sha512',($data['MerchantId'].$data['MerchantName'].$data['MerchantTxnId']),$nepalpay_pay_data->secret);
    
                $apiurl = $nepalpay_pay_data->status_url;
                $ch = curl_init($apiurl);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($data));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 6); // Set a timeout
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 4); // Set a connection timeout
    
                $headers = array(
                    'Content-Type: application/json',
                    'Authorization: Basic ' . $auth_sign, // Replace with your authorization header
                );
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
                $response = curl_exec($ch);
                curl_close($ch);                

                try {
                    $responseArray = json_decode($response,true);

                    $transaction = explode('-',$trans_id);
                    $booking = null;
                    $return_url = '/login';

                    if($transaction[0] == 'pdfbank')
                    {
                        $booking = PdfBankBooking::find($transaction[1]);
                        $return_url = '/student/pdf-bank-bookings';
                    }
                    elseif($transaction[0] == 'exam')
                    {
                        $booking = ExamBooking::find($transaction[1]);
                        $return_url = '/student/exam-bookings';
                    }
                    else
                    {

                    }
                    
                    if($responseArray['code'] == 0)
                    {
                        $resData = $responseArray['data'];
                        if($resData['Status'] == 'Success')
                        {
                            if($booking)
                            {
                                $booking->update([
                                    'status' => 'Verified',
                                    'verificationMode' => 'NepalPayment',
                                    'paymentAmount' => $resData['Amount'],
                                    'remarks' => 'Booked by Student with Nepal Payment From '.$resData['Institution'].' with Gateway Reference Number: '.$resData['GatewayReferenceNo'],
                                ]);
                            }

                            return redirect($return_url)->with('success_message','Transction Completed Succesfully.');
                        }
                    } 

                    return redirect($return_url.'/'.$transaction[1].'/edit')->with('error_message','Transaction Failed. Try Again Later.');

                } 
                catch (\Throwable $th) {
                    // throw $th;
                    abort(403, 'Nepal Pay Payment Could Not Be Verified.');
                    
                }
            
            } 
            catch (\Throwable $th) {
                // throw $th;
                abort(403, 'Nepal Pay Payment Could Not Be Verified.');
                
            }

        }

       abort(403, 'Nepal Pay Payment Response Data Error.');
    }

    public function returnPaymentNotification(Request $request)
    {
        return 'Received';
    }

}
