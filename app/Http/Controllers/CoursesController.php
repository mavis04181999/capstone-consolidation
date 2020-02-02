<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
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
            'course' => ['required', 'unique:courses,name'],
            'course-abbr' => ['required', 'unique:courses,abbr'],
            'course-department' => ['required','exists:departments,id']
        ]);

        $create = Course::create([
            'department_id' => $validate['course-department'] ,
            'name' => ucwords($validate['course']),
            'abbr' => ($validate['course-abbr']),
        ]);

        if ($create) {
            return back()->with('success', 'Course added successfully');
        }else {
            return back()->with('error', 'Fail to create Course');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $item = Course::find($course->id);

        $delete = Course::destroy($course->id);

        if ($delete) {
            return back()->with('success', $item->name.' : Course delete successfully');
        } else {
            return back()->with('error', $item->name." : Fail to delete Course");
        }
    }
}
