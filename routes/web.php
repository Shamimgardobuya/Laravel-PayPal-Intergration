<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\PayPalPaymentController;
use App\Http\Controllers\v1\StaffController;
use App\Mail\NotifyOnEmailFailure;
use Illuminate\Http\Request;
use App\Jobs\NotifyStaffJob;
use Illuminate\Support\Facades\Artisan;
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
// Route::get('/create-staff-template', [StaffController::class, 'index']);
// Route::get('/all-staff', [StaffController::class, 'show']);
// Route::get('/email-template', function () {
//     return view('emails.contact_email');
// });
// Route::get('/edit/{id}', [StaffController::class,'edit']);
// Route::post('/update/{id}', [StaffController::class, 'update'])->name('staff.update');
// Route::post('/send-email', function (Request $request) {
//     try {
//         var_dump($request->all());
//         dispatch(new NotifyStaffJob($request->name, $request->email, $request->subject, $request->message));
//         return response()->json([
//             'message' => "Success, Email has been queued for processing"
            
//         ]);

//     } catch (\Throwable $th) {
//         info($th);

//         Mail::to('obuyashamim21@gmail.com')->send(new NotifyOnEmailFailure(json_encode($th)));
//         return response($th->getMessage(), 422);
//     }
// })->name('send-email');




// Route::post('/store-staff', [StaffController::class, 'store'])->name('store.staff');


Route::post('/handle-payment', [PayPalPaymentController::class, 'createOrder'])->name('make.payment');

Route::get('/cancel-payment', [PayPalPaymentController::class,'paymentCancel'])->name('cancel.payment');

Route::post('/payment-success', [PayPalPaymentController::class, 'capturePayment'])->name('success.payment');

Route::get('/success', function () {
    return view('success');
})->name('success');

Route::get('/cancel', function () {
    return view('cancel');
})->name('cancel');




Route::get('/token',function (Request $request) {
    $token = $request->session()->token();
    $token = csrf_token();
    return response()->json([
        'token' => $token 
    ]);

});

Route::get('/run-migrations', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migrations ran successfully!';
});