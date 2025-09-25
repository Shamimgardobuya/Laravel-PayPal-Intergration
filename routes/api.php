<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\PayPalPaymentController;
use App\Http\Controllers\v1\StaffController;
use App\Http\Controllers\v1\UserController;
use App\Mail\NotifyOnEmailFailure;
use App\Jobs\NotifyStaffJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Response;
use Carbon\Carbon;
use App\Http\Controllers\v1\MpesaPaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('cors')->group(function () {
    Route::post('/mpesa_payment', [MpesaPaymentController::class, 'index'])->name('callback');
    Route::post('/handle-payment', [PayPalPaymentController::class, 'createOrder'])->name('make.payment');

    Route::get('/cancel-payment', [PayPalPaymentController::class,'paymentCancel'])->name('cancel.payment');

    Route::post('/payment-success', [PayPalPaymentController::class, 'capturePayment'])->name('success.payment');
    Route::get('/paypal', function () {
        return view('paypal_screen');
    });


    Route::get('/staff', function(Request $request) {
            try {
                $staff = DB::table('staff')->select('first_name','last_name', 'email', 'phone', 'image_path', 'role')->get();
                // $last_modified = now()->subSeconds(5);
                // $ifModifiedSince = Carbon::parse($request->header('If-Modified-Since'));
                // if ($last_modified->lte($ifModifiedSince)) {
                //     return response('',304);

                // }

                return response()->json([
                'success' => true,
                'message'=> 'Staff fetched successfully',
                'data' => $staff,
                ], 200);
            } catch (\Throwable $th) {
                info('dat'.$th);
                return response()->json([
                    'success' => false,
                    'message'=> 'Error', $th->getMessage(),
                    'data' => []
                    ]);
            }

        } );


    Route::middleware(['auth:api', 'role:Super Admin', 'throttle:api'])->group(function () {
        // dd("authoried");
            
        Route::post('/staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');

        Route::post('/staff/create', [StaffController::class, 'store'])->name('store.staff');

        Route::patch( '/users/update/{id}',[ UserController::class, 'update'])->name('update_user');
        
        Route::delete('/users/delete/{id}',[ UserController::class, 'destroy'])->name('delete_user');

        
    });


    //Users Route

    Route::get('/users',[ UserController::class, 'index'])->name('get_users');

    Route::post('/users/create',[ UserController::class, 'store'])->name('create_user');

    Route::post('/users/login',[ UserController::class, 'loginUser'])->name('login');




});

Route::middleware('throttle:api')->post('/send-email', function (Request $request) {
    try {
        dispatch(new NotifyStaffJob($request->name, $request->email, $request->subject, $request->message));
        return response()->json([
            'message' => "Success, Email has been queued for processing"
            
        ]);

    } catch (\Throwable $th) {
        info($th);

        Mail::to(config('mail.from'))->send(new NotifyOnEmailFailure(json_encode($th)));
        return response($th->getMessage(), 422);
    }
})->name('send-email');




