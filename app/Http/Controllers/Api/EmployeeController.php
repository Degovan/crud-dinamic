<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\EmployeeRequest;

use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message'   =>  'success, data has been retrieved',
            'data'      =>  Employee::get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        $employee = Employee::create([
            'name'      => $request->name,
            'gender'    => $request->gender,
            'address'   => $request->address
        ]);

        return response()->json([
            'message'      => 'success, employee has been created',
            'data'         => $employee
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'message'   => 'success, data has been retrieved',
            'data'      => Employee::find($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, $id)
    {
        $employee = Employee::find($id);

        $employee->update([
            'name'      => $request->name,
            'gender'    => $request->gender,
            'address'   => $request->address
        ]);

        return response()->json([
            'message'      => 'success, employee has been updated',
            'data'         => $employee
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Employee::destroy($id);

        return response()->json([
            'message'      => 'success, employee has been deleted'
        ]);
    }
}
