<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'department' => ['required', 'unique:departments,name'],
            'department-abbr' => ['required', 'unique:departments,abbr'],
        ]);

        $create = Department::create([
            'name' => ucwords($validate['department']),
            'abbr' => ($validate['department-abbr']),
        ]);

        if ($create) {
            return back()->with('success', 'Department added successfully');
        }else {
            return back()->with('error', 'Fail to create Department');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $item = Department::find($department->id);
        
        $delete = Department::destroy($department->id);

        if ($delete) {
            return back()->with('success', $item->name.': Department deleted successfully');
        }else {
            return back()->with('error', $item->name.': Fail to delete Department');
        }
    }
}
