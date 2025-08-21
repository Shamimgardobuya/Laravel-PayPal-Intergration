<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MpesaService;

use Illuminate\Support\Facades\DB;
use App\Http\Requests\v1\PaymentRequest;

class MpesaPaymentController extends Controller
{
    public function index(PaymentRequest $request)
    { 

        $phone_number = $request->phone_number;
        $amount = $request->amount;
        $item = $request->item;

        try {
            $dt = new MpesaService();
            $dt->get_authorization_token();
            $dt->register_url();
            $process_request = $dt->process_request($phone_number, $amount);

            if ($process_request) {
                DB::table('payment_tracking')->insert([
                'transaction_id' => $process_request['CheckoutRequestID'],
                'amount' => $amount,
                'status' => $process_request['ResponseDescription'],
                'created_at' => now(),
                'item'=>$item

            ]);
            return response()->json(
                ["message"=> "Payment processed successfully", "data" => "success"], 200
            );

            }
        } catch (\Throwable $th) {
            return response()->json(
                ['error'=> $th->getMessage()]
            );
        }
        
    
    }
}
