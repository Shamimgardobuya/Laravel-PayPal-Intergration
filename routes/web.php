<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\PayPalPaymentController;
use App\Http\Controllers\v1\StaffController;
use App\Mail\NotifyOnEmailFailure;
use Illuminate\Http\Request;
use App\Jobs\NotifyStaffJob;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

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

Route::get('/paypal', function () {
    return Inertia::render('PaypalScreen');
});
Route::get('/programs', function () {
    return Inertia::render('Programs');
});
Route::get('/gallery', function () {
    return Inertia::render('Gallery');
});

Route::get('/', function() {
        return Inertia::render('HomeScreen');

});

Route::get('/home', function () {
    return Inertia::render('HomeScreen');
});
Route::get('/values', function () {
    return Inertia::render('Values');
});
Route::get('/token', function (Request $request) {
    return $request->session()->token();
});

// Route::get('/create-staff-template', [StaffController::class, 'index']);
Route::get('/staff', function() {
        try {
            
            $staff = DB::table('staff')->select('first_name','last_name', 'email', 'phone', 'image_path')->get();
            return response()->json([
            'success' => true,
            'message'=> 'Staff fetched successfully',
            'data' => $staff
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message'=> 'Error', $th->getMessage(),
                'data' => []
                ]);
        }

    } );
    
Route::get('/email-template', function () {
    return view('emails.contact_email');
});
Route::get('/contact', function() {
    return Inertia::render('ContactScreen');
});
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
    return Inertia::render('PaymentSuccess');

})->name('success');

Route::get('/cancel', function () {
    return Inertia::render('PaymentCancelled');
})->name('cancel');




Route::get('/csrf-token',function (Request $request) {
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


Route::get('/run-queue', function () {
    Artisan::call('queue:work --stop-when-empty');
    return 'Queue processed';
});
