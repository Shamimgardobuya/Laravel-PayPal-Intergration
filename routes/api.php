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






Route::post('/send-email', function (Request $request) {
    try {
        dispatch(new NotifyStaffJob($request->name, $request->email, $request->subject, $request->message));
        return response()->json([
            'message' => "Success, Email has been queued for processing"
            
        ]);

    } catch (\Throwable $th) {
        info($th);

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new NotifyOnEmailFailure(json_encode($th)));
        return response($th->getMessage(), 422);
    }
})->name('send-email');



Route::middleware(['auth:api', 'role:Super Admin'])->group(function () {
        
    Route::post('/staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');

    Route::post('/staff/create', [StaffController::class, 'store'])->name('store.staff');

    Route::patch( '/users/update/{id}',[ UserController::class, 'update'])->name('update_user');
    
    Route::delete('/users/delete/{id}',[ UserController::class, 'destroy'])->name('delete_user');

    Route::get('/staff', function() {
        try {
            $staff = DB::table('staff')->select('first_name','last_name', 'email', 'phone', 'image')->get();
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
});


//Users Route

Route::get('/users',[ UserController::class, 'index'])->name('get_users');

Route::post('/users/create',[ UserController::class, 'store'])->name('create_user');

Route::post('/users/login',[ UserController::class, 'loginUser'])->name('login');







