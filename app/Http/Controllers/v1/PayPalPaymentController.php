<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayPalService;
use Exception;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Log;

class PayPalPaymentController extends Controller
{
    public $paypal_service;
    public function __construct(PayPalService $paypal_service){
        $this->paypal_service = $paypal_service;

    }
    public function createOrder(Request $request) {
        try {
            $amount = $request->amount;
            Log::info(json_encode(array($this->paypal_service->getAccessToken())));

            $order = $this->paypal_service->createOrder($amount);
                

            // echo(json_encode($order));
            if (!$order || !isset($order['id'])) {
                print_r(json_encode($order));
                return response()->json(['error' => 'Failed to create PayPal order'], 500);
            }
            
            return response()->json($order);
            

        } catch (\Throwable $th) {
            print_r(json_encode($th));
            return response()->json([
                'error' => 'Failed to create Paypal order',
                'reason' => $th->getMessage()
            ]);
            
        }

        }
       

        

    

    public function paymentCancel() {

    }

    public function capturePayment(Request $request) {

        try {
            $orderId = $request->order_id;
            Log::info(json_encode($request->all()));
            $payment = $this->paypal_service->capturePayment($orderId);
    
            if (!$payment || !isset($payment['status'])) {
                // info(['Payment' => $payment]);
                return response()->json(['error' => 'Payment capture failed'], 500);
            }

            FacadesDB::table('payment_tracking')->insert([
                'transaction_id' => $payment['purchase_units'][0]['payments']['captures'][0]['id'],
                'amount' => $payment['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                'status' => $payment['status'],
                'created_at' => now(),
                'item'=> $request->item

            ]);
        
            
            return response()->json($payment);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Failed to capture payment',
                'reason' => $e
            ]);
        


    }

}

}
