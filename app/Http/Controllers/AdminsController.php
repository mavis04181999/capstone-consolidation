<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Imports\ImportUsers;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::user()->latest()->get();
        $organizers = User::organizer()->latest()->get();
        $departments = Department::get();

        return view('admin.index', compact('users', 'organizers', 'departments'));
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
    public function store(StoreUserRequest $request)
    {
        $password = Str::upper(Str::random(6));

        $user = User::create([
            'username' => $request->validated()['username'],
            'firstname' => ucwords($request->validated()['firstname']),
            'middlename' => ucwords($request->validated()['middlename']),
            'lastname' => ucwords($request->validated()['lastname']),
            'email' => $request->validated()['email'],
            'contactno' => $request->validated()['contactno'],
            'address' => ucwords($request->validated()['address']),
            'department_id' => $request->validated()['department'],
            'course_id' => $this->getCourseID($request->validated()['course']),
            'section_id' => $this->getSectionID($request->validated()['section']),
            'year' => $request->validated()['year'],
            'temppassword' => $password,
            'password' => Hash::make($password),
            'role' => $request->validated()['role'],
        ]);

 
        if($user){
            $name = $user->firstname." ".$user->lastname;

            // return back()->with('success', $name.': Created Successfully');

            session()->flash('success', $name.':Created Successfully');

            return response()->json([
                'success' => true,
                'message' => $name.': Created Successfully'
            ]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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
    public function update(UpdateUserRequest $request, User $user)
    {
        $user = User::find($request->validated()['user_id']);
        
        $oldpassword = $user->password;

        if ($request->validated()['password'] == null) {
            // commit changes and save old password
            if($user->update([
                'firstname' => ucwords($request->validated()['firstname']),
                'middlename' => ucwords($request->validated()['middlename']),
                'lastname' => ucwords($request->validated()['lastname']),
                'email' => $request->validated()['email'],
                'contactno' => $request->validated()['contactno'],
                'address' => ucwords($request->validated()['address']),
                'department_id' => $request->validated()['department'],
                'course_id' => $this->getCourseID($request->validated()['course']),
                'section_id' => $this->getSectionID($request->validated()['section']),
                'year' => $request->validated()['year'],
                'password' => $oldpassword,
            ])){
                $name = $user->firstname." ".$user->lastname;

                session()->flash('success', $name.": Update Successfully");

                return response()->json([
                    'success' => true,
                    'messages' => $name.": Update Successfully"
                ]);
            }
        } else {
            // commit changes and save new password and hash it
            if($user->update([
                'firstname' => ucwords($request->validated()['firstname']),
                'middlename' => ucwords($request->validated()['middlename']),
                'lastname' => ucwords($request->validated()['lastname']),
                'email' => $request->validated()['email'],
                'contactno' => $request->validated()['contactno'],
                'address' => ucwords($request->validated()['address']),
                'department_id' => $request->validated()['department'],
                'course_id' => $this->getCourseID($request->validated()['course']),
                'section_id' => $this->getSectionID($request->validated()['section']),
                'year' => $request->validated()['year'],
                'password' => Hash::make($request->validated()['password']),
            ])){
                $name = $user->firstname." ".$user->lastname;

                session()->flash('success', $name.": Update Successfully");

                return response()->json([
                    'success' => true,
                    'messages' => $name.": Update Successfully"
                ]);
            }
        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $user = User::find($request->user_id);
        $name = $user->firstname." ".$user->lastname;

        if(User::destroy($user->id)){
            return back()->with('success', $name.": Deleted Successfully");
        }else {
            return back()->with('error', $name.": Fail to Delete");
        }
    }

    public function destroys(Request $request, User $user){

        if(boolval($request->user == null)) {
            return back()->with('error', 'There is no selected user');
        }

        $count = 0;

        foreach ($request->user as $user => $value) {
            $user = User::find($user);
            
            User::destroy($user->id);

            $count++;
        }

        if ($count > 1) {
            return back()->with('success', $count.' : Users Deleted Successfully');
        }else {
            return back()->with('success', $count.' : User Deleted Successfully');
        }
    }

    public function import(Request $request){
        // dd($request->all);
        $validator = Validator::make($request->all(), [
            'import' => ['required', 'file']
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        try {
            Excel::import(new ImportUsers(),  request()->file('import'));            

            return redirect('/admin')->with('success', 'Import Successfully');

        }   catch(\Maatwebsite\Excel\Validators\Failure $e) {
            $failures = $e->failures;

            foreach ($failures as $learn) {
                $learn->row();
                $learn->attribute();
                $learn->errors();
                $learn->values();
            }

        }
        
    }

    public function getCourseID($course){
        if ($course == null) {
            return null;
        }

        $course = Course::where('abbr', $course)->first();
        return $course->id;
    }

    public function getSectionID($section){
        if ($section == null) {
            return null;
        }

        $section = Section::where('section', $section)->first();
        return $section->id;
    }
}
