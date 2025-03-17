<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StaffFormRequest;
use App\Models\StaffModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;


class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()

    {
       try {
        //code...
       $schema = $this->getSchema();

        return view('rest_api')->with(['schema' => $schema]);
       } catch (\Throwable $th) {
        info($th);
        return response()->json(
            [
                'message' => $th
            ]
        );

       } 

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
    public function store(StaffFormRequest $request)
    {
        try {
            DB::beginTransaction();
            $new_staff = StaffModel::create(
                [
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'role' => $request->role,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]
            );
            if ($request->file) {
                $imageName = time().'.'.$request->file->extension();
                $request->file->move(public_path('assets'), $imageName);
                $new_staff->image_path = 'assets/'.$imageName;
                $new_staff->save();

            }
        
            DB::commit();
            return response()->json([
                'data' => $new_staff,
                'message' => 'Staff successfully created'
            ], 201);

    
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => $th
                ]
            );
        }
        

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        try {
            $staff = StaffModel::select(
                'first_name', 'role','image_path',


            )->get();
            $search = $request->search;
            if ($search) {

                $staff = StaffModel::search($search)
                ->select(
                'first_name', 'role','image_path',
                

            )->get();
                
            }
            return response()->json(
            [
                'message' => 'Staff fetched successfully',
                'data' => $staff
            ], 200
        );
        } catch (\Throwable $th) {

        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // var_dump($id);
        $schema = $this->getSchema();
        return view('edit_staff', compact(
        'schema',
        'id' 
        ));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StaffFormRequest $request, int $id)
    {
        try {
            $staff_to_be_edited = StaffModel::search($id)->first();

            if ($staff_to_be_edited) {
                if ($request->file) {
                    $imageName = time().'.'.$request->file->extension();
                    $request->file->move(public_path('assets'), $imageName);
                    $staff_to_be_edited->image_path = 'assets/'.$imageName;
                    $staff_to_be_edited->save();
    
                }
                $data = StaffModel::where('staff_id', $staff_to_be_edited->staff_id)->update(
                    [
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'role' => $request->role,
                        'email' => $request->email,
                        'phone' => $request->phone
        
                    ]
                    );
                    return response()->json(
                        [
                            'message' => 'Staff updated successfully',
                            'data' => $data
                        ]
                        );
                
            }else {
                return response()->json(
                    [
                        'message' => 'No staff found',
                        'success' => false,
                        'data' => []
                    ]
                    );
            }
            
    
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'message' => $th->getMessage(),
                    'success' => false,
                    'data' => []
                ]
                );
        }
        

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }


    public function getSchema()
    {
        $dataType = DB::table('information_schema.columns')
        ->where('table_name', 'staff')
        ->whereIn('column_name',['first_name', 'last_name','role' ,'email', 'phone', 'image_path'] )
        ->pluck('column_name');
        
        $schema = [];
        foreach ($dataType as $column) {
        $value = DB::getSchemaBuilder()->getColumnType('staff', $column);
        if ($column == 'image_path') {
        $value = 'file';
        $column = 'file';
        }
        $schema[$column] = $value;

        }
        if (count($schema) > 1) {
            return $schema;
        }else{
            return [];
        }
    }

}
