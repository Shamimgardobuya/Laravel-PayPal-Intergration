<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\PayPalPaymentController;
use App\Http\Controllers\v1\StaffController;
use App\Mail\NotifyOnEmailFailure;
use Illuminate\Http\Client\Request;
use App\Jobs\NotifyStaffJob;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('paypal_screen');
});
Route::get('/create-staff-template', [StaffController::class, 'index']);
Route::get('/all', [StaffController::class, 'show']);
Route::get('/email-template', function () {
    return view('emails.contact_email');
});
Route::get('/edit/{id}', [StaffController::class,'edit']);
Route::post('/update/{id}', [StaffController::class, 'update'])->name('staff.update');
Route::post('/send-email', function (Request $request) {
    try {
        dispatch(new NotifyStaffJob($request->input('name'), $request->input('email'), $request->input('subject'), $request->input('message')));
        return response()->json([
            'message' => "Success, Email has been queued for processing"
            
        ]);

    } catch (\Throwable $th) {
        Mail::to('shamimobuya@gmail.com')->send(new NotifyOnEmailFailure($th));
        return response($th->getMessage(), 422);
    }
})->name('send-email');




Route::post('/store-staff', [StaffController::class, 'store'])->name('store.staff');


Route::post('/handle-payment', [PayPalPaymentController::class, 'createOrder'])->name('make.payment');

Route::get('/cancel-payment', [PayPalPaymentController::class,'paymentCancel'])->name('cancel.payment');

Route::post('/payment-success', [PayPalPaymentController::class, 'capturePayment'])->name('success.payment');

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/cancel', function () {
    return view('cancel');
})->name('cancel');


