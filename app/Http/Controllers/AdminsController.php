<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use App\Event;
use App\Feature;
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
        $departments = Department::latest()->get();
        $events = Event::latest()->get();
        $features = Feature::all();

        return view('admin.index', compact('users', 'organizers', 'departments', 'events', 'features'));
    }

    public function dashboardUser() {
        $users = User::user()->latest()->get();
        $departments = Department::latest()->get();
        $courses = Course::all();
        $sections = Section::all();


        return view('admin.dashboard-user', compact('users', 'departments', 'courses', 'sections'));
    }

    public function dashboardOrganizer() {
        $organizers = User::organizer()->latest()->get();
        $departments = Department::latest()->get();
        $courses = Course::all();
        $sections = Section::all();

        return view('admin.dashboard-organizer', compact('organizers', 'departments', 'courses', 'sections'));
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
            'email' => ($request->validated()['email']),
            'title' => ($request->validated()['title']),
            'firstname' => ucwords($request->validated()['firstname']),
            
            'middlename' => ucwords($request->validated()['middlename']),
            'lastname' => ucwords($request->validated()['lastname']),
            'nickname' => ucwords($request->validated()['nickname']),

            'certificate_name' => ucwords($request->validated()['certificate_name']),
            'contactno' => ($request->validated()['contactno']),
            'address' => ucwords($request->validated()['address']),

            'occupation' => ucwords($request->validated()['occupation']),
            'sex' => $request->validated()['sex'],
            'birthday' => ($request->validated()['birthday']),

            'department_id' => ($request->validated()['department']),
            'course_id' => ($request->validated()['course']),
            'section_id' => ($request->validated()['section']),
            'year' => ($request->validated()['year']),

            'institution' => ucwords($request->validated()['institution']),
            'username' => $request->validated()['username'],
            'temppassword' => $password,
            'password' => Hash::make($password),
            'role' => $request->validated()['role'],
        ]);
 
        if($user){
            $name = $user->firstname." ".$user->lastname;

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
        // get the user
        $user = User::find($request->validated()['user_id']);
        // get the name
        $name = $user->firstname." ".$user->lastname;
        // get the user current password
        $oldpassword = $user->password;
        // all validated data
        // new
        $validated = [
            'email' => ($request->validated()['email']),
            'title' => ($request->validated()['title']),
            'firstname' => ucwords($request->validated()['firstname']),
            
            'middlename' => ucwords($request->validated()['middlename']),
            'lastname' => ucwords($request->validated()['lastname']),
            'nickname' => ucwords($request->validated()['nickname']),

            'certificate_name' => ucwords($request->validated()['certificate_name']),
            'contactno' => ($request->validated()['contactno']),
            'address' => ucwords($request->validated()['address']),

            'occupation' => ucwords($request->validated()['occupation']),
            'sex' => $request->validated()['sex'],
            'birthday' => ($request->validated()['birthday']),

            'department_id' => ($request->validated()['department']),
            'course_id' => ($request->validated()['course']),
            'section_id' => ($request->validated()['section']),
            'year' => ($request->validated()['year']),

            'institution' => ucwords($request->validated()['institution']),

        ];

        if ($request->validated()['password'] == null) {
            // merge the validated request together with old password
            // commit the changes and save the old password when password is equal to null
            $password = [
                'password' => $user->password
            ];

            $merge = array_merge($validated, $password);

            
            if ($user->update($merge)) {

                session()->flash('success', $name.": Update Successfully");

                return response()->json([
                    'success' => true,
                    'message' => $name.": Update Successfully"
                ]);
            }

            
        } else {
            // merge the validated request together with the new password
            // commit the changes and save the new password
            $password = [
                'password' => Hash::make($request->validated()['password'])
            ];

            $merge = array_merge($validated, $password);

            if ($user->update($merge)) {
                
                session()->flash('success', $name.": Update Successfully");

                return response()->json([
                    'success' => true,
                    'message' => $name.": Update Successfully"
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
            return back()->with('success',  'Users Deleted Successfully');
        }else {
            return back()->with('success',  'User Deleted Successfully');
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

            return redirect()->route('admin.user')->with('success', 'Import Successfully');

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
}
