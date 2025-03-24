<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayPalService;
use Exception;
use DB;

class PayPalPaymentController extends Controller
{
    public $paypal_service;
    public function __construct(PayPalService $paypal_service){
        $this->paypal_service = $paypal_service;

    }
    public function createOrder(Request $request) {
        try {
            $amount = $request->input('amount');
            $order = $this->paypal_service->createOrder($amount);
            if (!$order || !isset($order['id'])) {
                return response()->json(['error' => 'Failed to create PayPal order'. $request->all()], 500);
            }
            
            return response()->json($order);
            

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Failed to create Paypal order',
                'reason' => $th
            ]);
            
        }

        }
       

        

    

    public function paymentCancel() {

    }

    public function capturePayment(Request $request) {

        try {
            $orderId = $request->order_id;
            info(['Order ID' => $orderId, 'Request Data' => $request->all()]);
            $payment = $this->paypal_service->capturePayment($orderId);
    
            if (!$payment || !isset($payment['status'])) {
                info(['Payment' => $payment]);
                return response()->json(['error' => 'Payment capture failed'], 500);
            }

            DB::table('payment_tracking')->insert([
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
