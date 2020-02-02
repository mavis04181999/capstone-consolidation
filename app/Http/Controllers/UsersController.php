<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use App\Evaluation;
use App\Event;
use App\Http\Requests\UpdateProfileRequest;
use App\Participant;
use App\Section;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('user');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // check first if the login user set his nickname and his or her certificate name
        if (Auth::user()->nickname == null && Auth::user()->certificate_name == null) {
            return redirect()->route('show.profile', ['user' => Auth::user()->id]);
        }

         // get the login user
         $loginUser = Auth::user()->id;

         $user = User::find($loginUser);
         
         $events = Event::all();
         
         $evaluations = Evaluation::where('user_id', $loginUser)->where('is_evaluate', true)->get();
 
        return view('user.index', compact('user', 'events', 'evaluations'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $departments = Department::latest()->get();
        $courses = Course::all();
        $sections = Section::all();
        
        return view('profile.show', compact('user', 'departments', 'courses', 'sections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProfileRequest $request, User $user)
    {
        // UpdateProfileRequest
        $user = User::find($request->user_id);
        
        $data = [
            'email' => $request->email,
            'title' => $request->title,
            'firstname' => ucwords($request->firstname),

            'middlename' => ucwords($request->middlename),
            'lastname' => ucwords($request->lastname),
            'nickname' => ucwords($request->nickname),

            'certificate_name' => ucwords($request->certificate_name),
            'contactno' => $request->contactno,
            'address' => $request->address,

            'occupation' => $request->occupation,
            'sex' => $request->sex,
            'birthday' => $request->birthday,

            'department_id' => $request->department,
            'course_id' => $request->course,
            'section_id' => $request->section,

            'year' => $request->year,
            'institution' => $request->institution
        ];

        if ($request->password == null) {
            
            $user->update($data);

            session()->flash('success', 'Update successfully');

            return response()->json([
                'success' => true,
                'message' => 'Update successfully'
            ]);
            
        } else {
            $passsword = [
                'password' => Hash::make($request->password)
            ];

            $merge = array_merge($data, $password);

            $user->update($merge);

            session()->flash('success', 'Update successfully');

            return response()->json([
                'success' => true,
                'message' => 'Update successfully'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    


}
