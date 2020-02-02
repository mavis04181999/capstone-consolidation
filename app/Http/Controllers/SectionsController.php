<?php

namespace App\Http\Controllers;

use App\Section;
use Illuminate\Http\Request;

class SectionsController extends Controller
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
            'section' => ['required', 'unique:sections,section'],
            'course' => ['required','exists:courses,id']
        ]);

        $create = Section::create([
            'course_id' => $validate['course'],
            'section' => $validate['section'],
        ]);

        if ($create) {
            return back()->with('success', 'Section added successfully');
        }else {
            return back()->with('error', 'Fail to create Section');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
       $item = Section::find($section->id);

       $delete = Section::destroy($section->id);

       if($delete) {
           return back()->with('success', $item->section.': Section deleted Successfully');
       } else {
           return back()->with('error', $item->section.'Fail to delete section');
       }
    }
}
