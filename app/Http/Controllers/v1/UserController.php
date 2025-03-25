<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UpdateUsersRequest;
use App\Http\Requests\v1\UsersRequest;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email','password');
       
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid password'], 401);
        }

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        else{
            $user = Auth::user();
            return response()->json(
                [
                    'status'=>'success',
                     'user' => $user,
                     'authorisation' =>
                     [
                        'token'=>$token,
                        'type'=> 'bearer'
                    ],
                    'role' => User::find($user->id)->roles()->pluck('name'),
                    'expires_in' => '1hr'

                ]
                ,200);
        }
    }
    

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
    public function index(Request $request)
    {
        $users = DB::table('users')
                    ->select('name', 'email', 'created_at', 'updated_at')
                    ->get();
        return response()->json([
            'success' => true,
            'message' => 'Users fetched successfully',
            'data' => $users
        ],200);
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsersRequest $request)
    {
        try {
            // $request = $request->validated();
            $user = User::create(
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password)
                ]
                );
            $user_role = Roles::where('name', $request->user_role)->first();
            $user->roles()->attach($user_role->id);
                return response()->json([
                    'success' => true,
                    'message' => 'User created successfully',
                    'data' => $user
                ],201);

        } catch (\Throwable $th) {
            info($th);
            return response()->json([
                'success' => false,
                'message' => 'Failed to create user', $th->getMessage(),
                'data' => []
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, string $id)
    {
        $find_user = User::find($id);
        if ($find_user) {
            try {
              
                $find_user->update(
                        [
                            $request->validated()
                        ]
                        );

                
               
                return response()->json([
                        'success' => true,
                        'message' => 'User updated successfully',
                        'data' => $find_user
                    ],200);

                
            } catch (\Throwable $th) {
                info($th);
                return response()->json([
                    'success' => false,
                    'message' => 'Update failed',
                    'data' => $find_user
                ]);
                
            }
    
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $find_user = User::find($id);
        if ($find_user) {
            try {
                $find_user->delete();
                return response()->json([
                        'success' => true,
                        'message' => 'User deleted successfully',
                        'data' => $find_user
                    ]);

                
            } catch (\Throwable $th) {
                info($th);
                return response()->json([
                    'success' => false,
                    'message' => 'Delete failed'. $th->getMessage(),
                    'data' => $find_user
                ]);
                
            }
           
            
        }
    }
}
