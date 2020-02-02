<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
use App\Event;
use App\Feature;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Imports\ImportUsers;
use App\Participant;
use App\Section;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $countDepartment = count(Department::all());

        if($countDepartment > 0) {
            $this->syncEvent();

            $users = User::user()->latest()->get();
            $organizers = User::organizer()->latest()->get();
            $departments = Department::latest()->get();
            $events = Event::where('archive', 0)->latest()->get();
            $features = Feature::all();
    
            return view('admin.index', compact('users', 'organizers', 'departments', 'events', 'features'));
            
        }else {
            // sync departments, courses, sections
            return redirect()->route('admin.settings');
        }

    
    }

    public function dashboardUser() {

        $this->syncUser();

        $users = User::user()->latest()->get();
        $departments = Department::latest()->get();
        $courses = Course::all();
        $sections = Section::all();

        return view('admin.dashboard-user', compact('users', 'departments', 'courses', 'sections'));
    }

    public function dashboardOrganizer() {

        $this->syncOrganizer();

        $organizers = User::organizer()->latest()->get();
        $departments = Department::latest()->get();
        $courses = Course::all();
        $sections = Section::all();

        return view('admin.dashboard-organizer', compact('organizers', 'departments', 'courses', 'sections'));
    }

    public function dashboardSettings() {
        $this->syncDepartment();

        // departments, courses, sections
        $departments = Department::latest()->get();
        $courses = Course::latest()->with('department')->get();
        $sections = Section::latest()->with('course')->get();

        return view('admin.settings', compact('departments', 'courses', 'sections'));
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

    public function syncEvent() {
        // counter
        $old = 0;
        $new = 0;

        // get all the events on the cems system
        try {

        $chaaEvents = DB::connection('mysql2')->table('event_detail')->get();

        // get the current events from own db pluck only the event id's
        $currentEvents = Event::pluck('id')->toArray();

        foreach ($chaaEvents as $chaaevent => $value) {

            // check if exists
            if (in_array($value->event_id, $currentEvents) == true) {
                
                $event = Event::find($value->event_id);
                // get the organizer from the event
                $organizer = DB::connection('mysql2')->table('admin')->where('event_id', $value->event_id)->first();
                // get the department through name from the Department table
                $department = Department::where('abbr', $value->department)->first();
                // dd($event->event_name   , $value->event_name);

                $data = [
                    'organizer_id' => $organizer->admin_id,
                    'event_name' => ucwords($value->event_name),
                    'location' => ucwords($value->venue),
                    'max_participants' => ($value->max),
                    'allow_prereg' => $value->allow_prereg,
                    'prereg_slot' => $value->prereg_slot,
                    'prereg_validity' => $value->allow_day,
                    'event_overview' => "", //there is no event overview
                    'status' => $value->status,
                ];

                $event->update($data);

                $event->save();

                $old++;
            }else{
                                
                $event_code = substr(Str::upper(Str::uuid()), 9, 9);
                // get the organizer from the event
                $organizer = DB::connection('mysql2')->table('admin')->where('event_id', $value->event_id)->first();
                // get the department through name from the Department table
                $department = Department::where('abbr', $value->department)->first();

                
                Event::create([
                    'id' => $value->event_id,
                    'organizer_id' => $organizer->admin_id,
                    'event_code' => $event_code,
                    'event_name' => ucwords($value->event_name),
                    'location' => ucwords($value->venue),
                    
                    'start_date' =>  Carbon::parse($value->start_date)->format('Y-m-d H:i:s'),
                    'end_date' => Carbon::parse($value->end_date)->format('Y-m-d H:i:s'),
                    
                    'max_participants' => ($value->max),
                    'allow_prereg' => $value->allow_prereg,
                    'prereg_validity' => $value->allow_day,
                    
                    'archive' => 0,
                    'prereg_slot' => $value->prereg_slot,
                    'event_overview' => "", //there is no event overview
                    'status' => $value->status,
                    ]);
                    
                    $new++;
                }
            }

            if ($old > 0) {
                // return back()->with('success', 'Events sync Successfully');
                return back();
            } else if($new > 0) {
                return back()->with('success', 'New Events Added');
            }

        } catch (\Throwable $th) {

            die('Could not find the database cems_db. Please check your configuration');
        }

        
            
    }

    public function syncUser() {

        try {
            
        // get all the events
        $events = Event::all()->pluck('id');
        
        // traverse through the events and get the individual participants
        foreach ($events as $event => $value) {
            // get the current participants
            // $current = Participant::all()->pluck('event_id')->toArray();
            $current = User::user()->pluck('username')->toArray();

            // get the participants from cems system
            $others = DB::connection('mysql2')->table('participant')->where('event_id', $value)->pluck('student_id');
            
            foreach ($others as $other => $value) {
                // check if exist if not create account
                if (in_array($value, $current) == false) {
                    // get the user account from cems
                    $user = DB::connection('mysql2')->table('students')->where('student_id', $value)->first();

                    $password = Str::upper(Str::random(6));
                    $course = Course::where('abbr', $user->course)->first();
                    $section = Section::where('section', $user->section)->first();

                    User::create([
                        'email' => ($user->email),
                        'firstname' => ($user->firstname),
                        'middlename' => ($user->middlename),                        
                        'lastname' => ($user->lastname),

                        'department_id' => ($user->department),
                        'course_id' => ($course->id),
                        'section_id' => ($section->id),
                        'year' => ($user->year),

                        'contactno' => ($user->contactno),
                        'address' => ($user->email),

                        'institution' => ucwords($user->institution),
                        'username' => $user->student_id,
                        'temppassword' => $password,
                        'password' => Hash::make($password),
                        'role' => "user",
                    ]);

                }
            }
            
        }

        // return back()->with('success', 'Users sync successfully');
        return back();

        } catch (\Throwable $th) {

            die('Could not find the database cems_db. Please check your configuration');
        }

        
    }

    public function syncOrganizer() {
        try {
            
        // get all the events
        $events = Event::all()->pluck('id');
        
        // traverse through the events and get the individual participants
        foreach ($events as $event => $value) {
            // get the current participants
            $current = User::organizer()->pluck('id')->toArray();

            // get the admin from cems system
            $others = DB::connection('mysql2')->table('admin')->where('event_id', $value)->pluck('admin_id');

            foreach ($others as $other => $value) {
                // check if exist if not create account
                if (in_array($value, $current) == false) {
                    // get the user account from cems
                    $user = DB::connection('mysql2')->table('admin')->where('admin_id', $value)->first();

                    $password = Str::upper(Str::random(6));
                    // if none let value is equal to null
                    // $course = Course::where('abbr', $user->course)->first();
                    // $section = Section::where('section', $user->section)->first();

                    User::create([
                        'id' => $user->admin_id,
                        'username' => $user->username,
                        'temppassword' => $password,
                        'password' => Hash::make($password),
                        'role' => "organizer",
                    ]);

                }
            }
            
        }

        // return back()->with('success', 'Organizer sync successfully');
        return back();

        } catch (\Throwable $th) {
            die('Could not find the database cems_db. Please check your configuration');
        }

    }

    public function syncDepartment() {

        try {
            
        // get the current Departments
        $current = Department::all()->pluck('id')->toArray();
        
        // get the other Departments
        $others = DB::connection('mysql2')->table('department')->get()->toArray();

        foreach ($others as $other => $value) {
            // check if exists
            
            if(in_array($value->dept_id, $current) == false) {
                
                Department::create([
                    'id' => $value->dept_id,
                    'name' => ucwords($value->name),
                    'abbr' => strtoupper($value->dept_abbr)
                ]);
             
            }
          
        }

        $this->syncCourse();

        // return back()->with('success', 'Sync successfully');
        return back();

        } catch (\Throwable $th) {
            die('Could not find the database cems_db. Please check your configuration');
        }

    }

    public function syncCourse() {
        
        try {
        
        $current = Course::all()->pluck('id')->toArray();
        
        $others = DB::connection('mysql2')->table('course')->get()->toArray();
        
        foreach ($others as $other => $value) {
            
            // check if exists
            if (in_array($value->id, $current) == false) {
                
                $department = Department::where('id', $value->dept_id)->pluck('id')->first();
                // check if department is equal to null
                $department = $department != null ? $department : null;
                
                Course::create([
                    'id' => $value->id,
                    'department_id' => $department,
                    'name' => $value->name,
                    'abbr' => $value->abbr,
                    ]);
                }
                
            }
            
            $this->syncSection();

        } catch (\Throwable $th) {
            die('Could not find the database cems_db. Please check your configuration');
        }

    }

    public function syncSection() {

        try {
        
            $current = Section::all()->pluck('id')->toArray();

            $others = DB::connection('mysql2')->table('section')->get()->toArray();
    
            foreach ($others as $other => $value) {
                // check if exists
                if(in_array($value->sec_id, $current) == false) {
                    
                    // get the course
                    $course = Course::where('id', $value->id)->pluck('id')->first();
    
                    $course = $course != null ? $course : null;
                    
                    Section::create([
                        'id' => $value->sec_id,
                        'course_id' => $course,
                        'section' => $value->name,                    
                    ]);
    
                }
            }
        
        } catch (\Throwable $th) {
            die('Could not find the database cems_db. Please check your configuration');
        }

    }
}


      