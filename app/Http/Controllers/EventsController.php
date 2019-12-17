<?php

namespace App\Http\Controllers;

use App\Charts\UserEvaluationChart;
use App\Evaluation;
use App\Event;
use App\Feature;
use App\Form;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EventsController extends Controller
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
    public function store(StoreEventRequest $request)
    {
        
        $event_code = substr(Str::upper(Str::uuid()), 9, 9);
        $status = 'active';

        if (array_key_exists('prereg_slot', $request->validated())) {
            // 1. true prereg slot
            $validate = [
                'event_code' => $event_code,
                'event_name' => ucwords($request->validated()['event_name']),
                'organizer_id' => ($request->validated()['organizer_id']),
                'location' => ucwords($request->validated()['location']),
                'event_type' => ($request->validated()['event_type']),
                'start_date' => ($request->validated()['start_date']),
                'end_date' => ($request->validated()['end_date']),
                'department_id' => ($request->validated()['department_id']),
                'max_participants' => ($request->validated()['max_participants']),
                'allow_prereg' => ($request->validated()['allow_prereg']),
                'prereg_slot' => ($request->validated()['prereg_slot']),
                'fee' => ($request->validated()['fee']),
                'event_overview' => ucfirst($request->validated()['event_overview']),
                'status' => $status,
            ];
        } else {
            // 2. false prereg slot

            $validate = [
                'event_code' => $event_code,
                'event_name' => ucwords($request->validated()['event_name']),
                'organizer_id' => ($request->validated()['organizer_id']),
                'location' => ucwords($request->validated()['location']),
                'event_type' => ($request->validated()['event_type']),
                'start_date' => ($request->validated()['start_date']),
                'end_date' => ($request->validated()['end_date']),
                'department_id' => ($request->validated()['department_id']),
                'max_participants' => ($request->validated()['max_participants']),
                'allow_prereg' => ($request->validated()['allow_prereg']),
                'fee' => ($request->validated()['fee']),
                'event_overview' => ucfirst($request->validated()['event_overview']),
                'status' => $status,
            ];
        }

        $event = Event::create($validate);

        if ($event) {

            session()->flash('success', $event->event_name.": Created Successfully");

            return response()->json([
                'response' => $event
            ]);
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        // Queries:
        // change the queries for total users it will depends on number of users participate on the event that registered only
        $totalusers = DB::table('evaluations')->where('event_id', $event->id)->count();

        $isevaluate = DB::table('evaluations')->where('event_id', $event->id)->where('is_evaluate', true)->count();

        $isntevaluate = DB::table('evaluations')->where('event_id', $event->id)->where('is_evaluate', false)->count();

        $evaluationchart = new UserEvaluationChart;

        $evaluationchart->title('User Evaluation', 20, 'rgba(0, 153, 255, 0.71)');
        $evaluationchart->loader(true);
        $evaluationchart->height('500');
        $evaluationchart->labels(['Complete', 'Pending']);
        $evaluationchart->dataset('User Evaluation', 'bar', [$isevaluate, $isntevaluate])->options([
            'backgroundColor' => ['rgba(0, 153, 255, 0.71)', 'rgba(232, 200, 44, 0.71)'],
            'maintainAspectRatio' => false,
            'scales'              => [
                'xAxes' => [
                    
                ],
                'yAxes' => [
                    [
                        'display' => false,
                        'ticks' => [
                            'suggestedMax' => '1000',
                            'beginAtZero' => true,
                        ],
                    ],
                ],
            ],
        ], true);
        
        $evaluationchart->script();

        // get the questions of the event->form:
        $questions = Form::where('event_id', $event->id)->where('input_type', 'radio')->get();
        // get the maximum value on event->form->input from the first question:

        $maxOption = (int) DB::table('options')->where('form_id', $questions[0]->id)->max('value');

        // conditional statement for max value 4 and 5
        // get the evaluations for the corresponding event evalution->event_id
        $evaluations = DB::table('evaluations')
            ->where('event_id', $event->id)
            ->where('is_evaluate', true)->get();

        // $evaluates = DB::table('evaluates')->where('evaluation_id')

        // traverse through the questions and get the evaluations
        $question = [];
        $percentage = [];

        foreach ($questions as $qkey => $qvalue) {
            
            for ($i=1; $i <= $maxOption; $i++) { 
                
                $count = 0;
                
                foreach ($evaluations as $ekey => $evalue) {
                    $current = DB::table('evaluates')
                        ->where('evaluation_id', $evalue->id)
                        ->where('form_id', $qvalue->id)->get();
                    //problem here
                    if($current[0]->answer == $i){
                        $count++;
                    }
                    
                }
                $percentage[$qvalue->id][$i] = $count * $i;
                $question[$qvalue->id][$i] = $count; 
            }
            
        }
        // printout evaluation to each question and percentage to the corresponding weight

        // initialize the overallrating
        $overallrating = 0;

        $remarks = [];
        // solution for division of zero occurs when there is no someone evaluate the event
        if($isevaluate > 0){

            // loop through and get the remarks of each question
            foreach ($percentage as $pkey => $pvalue) {
                
                $remarks[$pkey] = round((array_sum($pvalue) / $isevaluate), 2);
                
            }
            // printout the remarks of each question
            // dd($remarks);

            // get the average from remarks
            $overallrating = round((array_sum($remarks) / count($remarks)), 2);

            // dd($overallrating);

        }

        $reports = [];

        // get the questions key
        foreach ($questions as $qkey => $qvalue) {
            $reports[$qvalue->id]['question'] = $qvalue->question;
        }
        // get the remarks
        foreach ($remarks as $rkey => $rvalue) {
            $reports[$rkey]['remarks'] = $rvalue;
        }

        return view('event.show', compact('event', 'totalusers', 'isevaluate', 'isntevaluate', 'evaluationchart', 'reports', 'maxOption'));
    }

    public function manage(Event $event, Feature $feature)
    {
        $features = Feature::all();

        $event_features = DB::table('event_feature')->where('event_id' , $event->id)->orderBy('feature_id')->get();

        return view('event.manage', compact('event', 'features', 'event_features'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event = Event::find($request->validated()['event_id']);

        if ($request->validated()['allow_prereg'] == 0 && array_key_exists('prereg_slot', $request->validated())) {            
            $data = ([
                'event_name' => ucwords($request->validated()['event_name']),
                'organizer_id' => ($request->validated()['organizer_id']),
                'location' => ucwords($request->validated()['location']),
                'event_type' => ($request->validated()['event_type']),
                'start_date' => ($request->validated()['start_date']),
                'end_date' => ($request->validated()['end_date']),
                'department_id' => ($request->validated()['department_id']),
                'max_participants' => ($request->validated()['max_participants']),
                'allow_prereg' => ($request->validated()['allow_prereg']),
                'prereg_slot' => null,
                'fee' => ($request->validated()['fee']),
                'event_overview' => ucfirst($request->validated()['event_overview']),
                'status' => ($request->validated()['status'])
            ]);
        } else {
            $data = ([
                'event_name' => ucwords($request->validated()['event_name']),
                'organizer_id' => ($request->validated()['organizer_id']),
                'location' => ucwords($request->validated()['location']),
                'event_type' => ($request->validated()['event_type']),
                'start_date' => ($request->validated()['start_date']),
                'end_date' => ($request->validated()['end_date']),
                'department_id' => ($request->validated()['department_id']),
                'max_participants' => ($request->validated()['max_participants']),
                'allow_prereg' => ($request->validated()['allow_prereg']),
                'prereg_slot' => ($request->validated()['prereg_slot']),
                'fee' => ($request->validated()['fee']),
                'event_overview' => ucfirst($request->validated()['event_overview']),
                'status' => ($request->validated()['status'])
            ]);
        }

        if ($event->update($data)) {
            $name = $event->event_name;

            session()->flash('success', $name.": Update Successfully");

            return response()->json([
                'success' => true,
                'messages' => $name.": Update Successfully"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event, Request $request)
    {
        $event = Event::find($request->event_id);
        
        $event_name = $event->event_name;

        if(Event::destroy($request->event_id)) {

            return back()->with('success', $event_name.": Deleted Successfully");

        }else {

            return back()->with('error', $event_name.": Fail to Delete");

        }

    }

    public function feature(Event $event, Request $request) {
        
        $event = Event::find($request->event_id);

        if(empty($request->feature)) {

            $event->features()->sync(null);

            return back()->with('success', $event->event_name.": update features successfully");
        }

        $feature = [];

        foreach ($request->feature as $fkey => $fvalue) {
            $feature[] = $fkey;
        }

        $event->features()->sync($feature);

        return back()->with('success', $event->event_name.": update features successfully");
    }

    public function formtype(Event $event, Request $request) {

        // small validation
        $validate = $request->validate([
            'event_id' => ['required'],
            'form_type' => ['required']
        ]);

        $event = Event::find($request->event_id);
    
        $data = [
            'form_type' => $request->form_type,
        ];

        if($event->update($data)) {

            // redirect to the right form type builder either create or edit
            if ($event->form_type == '0') {
                # go to standard create
                return redirect()->route('form.create', ['event' => $event->id]);
            } else {
                # go to custom edit
                return redirect()->route('form.edit', ['event' => $event->id]);
            }
            
        }

    }

    public function eventsetting(Event $event) {

        return view('event.setting', compact('event'));
    }

    public function eventimage(Request $request) {

        $validate = $request->validate([
            'event_id' => ['required'],
            'event_image' => ['required', 'image', 'max: 1999']
        ]);

        $event = Event::find($validate['event_id']);

        // check if the event image is null if not go upliad image else delete the previous image and upload the new one

            if($event->event_image == null) {
                // handle the file upload
                
                if($request->hasFile('event_image')) {
                    
                    // GET THE FILENAME WITH THE EXTENSION
                    $filenameext = $validate['event_image']->getClientOriginalName();
                    // GET THE FILE NAME
                    $filename = pathinfo($filenameext, PATHINFO_FILENAME);
                    // GET THE EXTENSION
                    $fileext = $validate['event_image']->getClientOriginalExtension();
                    // filename to store to make it more unique
                    $filenametostore = $filename.'_'.time().'.'.$fileext;
                    // upload the image to storage/public/event-images
                    $path = $validate['event_image']->storeAs('public/event-image', $filenametostore);
                    
                }


            }else {

                Storage::delete('public/event-image/'. $event->event_image);

                if($request->hasFile('event_image')) {
                    
                    // GET THE FILENAME WITH THE EXTENSION
                    $filenameext = $validate['event_image']->getClientOriginalName();
                    // GET THE FILE NAME
                    $filename = pathinfo($filenameext, PATHINFO_FILENAME);
                    // GET THE EXTENSION
                    $fileext = $validate['event_image']->getClientOriginalExtension();
                    // filename to store to make it more unique
                    $filenametostore = $filename.'_'.time().'.'.$fileext;
                    // upload the image to storage/public/event-images
                    $path = $validate['event_image']->storeAs('public/event-image', $filenametostore);
                    
                }
            }
            // updatechanges to event
            $event->update([
            'event_image' => $filenametostore
            ]);
            
            if ($event->save()) {
                
                return back()->with('success', 'Event Image Uploaded Successfully');
            }
        
    }

    public function certificate(Request $request) {

        $validate = $request->validate([
            'event_id' => ['required'],
            'certificate' => ['required', 'image', 'max: 1999']
            ]);
            
            $event = Event::find($validate['event_id']);
            
            // check if the event image is null if not go upliad image else delete the previous image and upload the new one
            
            if($event->event_certificate == null) {
                // handle the file upload
                
                if($request->hasFile('certificate')) {
                    
                    // GET THE FILENAME WITH THE EXTENSION
                    $filenameext = $validate['certificate']->getClientOriginalName();
                    // GET THE FILE NAME
                    $filename = pathinfo($filenameext, PATHINFO_FILENAME);
                    // GET THE EXTENSION
                    $fileext = $validate['certificate']->getClientOriginalExtension();
                    // filename to store to make it more unique
                    $filenametostore = $filename.'_'.time().'.'.$fileext;
                    // upload the image to storage/public/event-images
                    $path = $validate['certificate']->storeAs('public/event-certificate', $filenametostore);
                    
                }
                
                
            }else {
                
                Storage::delete('public/event-certificate/'. $event->even_certificate);
                
                if($request->hasFile('certificate')) {
                    
                    // GET THE FILENAME WITH THE EXTENSION
                    $filenameext = $validate['certificate']->getClientOriginalName();
                    // GET THE FILE NAME
                    $filename = pathinfo($filenameext, PATHINFO_FILENAME);
                    // GET THE EXTENSION
                    $fileext = $validate['certificate']->getClientOriginalExtension();
                    // filename to store to make it more unique
                    $filenametostore = $filename.'_'.time().'.'.$fileext;
                    // upload the image to storage/public/event-images
                    $path = $validate['certificate']->storeAs('public/event-certificate', $filenametostore);
                    
                }
            }
            // updatechanges to event
            $event->update([
                'event_certificate' => $filenametostore
                ]);
                
                if ($event->save()) {
                    
                    return back()->with('success', 'Event Certificate Uploaded Successfully');
                }
    }

    public function eventid(Request $request) {
        $validate = $request->validate([
            'event_id' => ['required'],
            'id_card' => ['required', 'image', 'max: 1999']
            ]);
            
            $event = Event::find($validate['event_id']);
            
            // check if the event image is null if not go upliad image else delete the previous image and upload the new one
            
            if($event->event_certificate == null) {
                // handle the file upload
                
                if($request->hasFile('id_card')) {
                    
                    // GET THE FILENAME WITH THE EXTENSION
                    $filenameext = $validate['id_card']->getClientOriginalName();
                    // GET THE FILE NAME
                    $filename = pathinfo($filenameext, PATHINFO_FILENAME);
                    // GET THE EXTENSION
                    $fileext = $validate['id_card']->getClientOriginalExtension();
                    // filename to store to make it more unique
                    $filenametostore = $filename.'_'.time().'.'.$fileext;
                    // upload the image to storage/public/event-images
                    $path = $validate['id_card']->storeAs('public/event-id', $filenametostore);
                    
                }                
                
            }else {
                
                Storage::delete('public/event-id/'. $event->event_eventid);
                
                if($request->hasFile('id_card')) {
                    
                    // GET THE FILENAME WITH THE EXTENSION
                    $filenameext = $validate['id_card']->getClientOriginalName();
                    // GET THE FILE NAME
                    $filename = pathinfo($filenameext, PATHINFO_FILENAME);
                    // GET THE EXTENSION
                    $fileext = $validate['id_card']->getClientOriginalExtension();
                    // filename to store to make it more unique
                    $filenametostore = $filename.'_'.time().'.'.$fileext;
                    // upload the image to storage/public/event-images
                    $path = $validate['id_card']->storeAs('public/event-id', $filenametostore);
                    
                }
            }
            // updatechanges to event
            $event->update([
                'event_eventid' => $filenametostore
                ]);
                
                if ($event->save()) {
                    
                    return back()->with('success', 'Event ID Uploaded Successfully');
                }
    }

    public function pdfreport(Event $event, Request $request) {

        // count the participants
        $totalParticipants = count(Evaluation::where('event_id', $event->id)->get());

        // count is evaluate and isnt evaluate
        $isEvaluate = DB::table('evaluations')->where('event_id', $event->id)
                        ->where('is_evaluate', true)->count();

        $isntEvaluate = DB::table('evaluations')->where('event_id', $event->id)
                            ->where('is_evaluate', false)->count();

        // get the maximum option value and turn it into integer
        $questions = DB::table('forms')->where('event_id', $event->id)
                        ->where('input_type', 'radio')->get();

        $maxOption = (int) DB::table('options')->where('form_id', $questions[0]->id)->max('value');

        // get the evaluations for corresponding event and get only those who evaluates
        $evaluations = DB::table('evaluations')->where('event_id', $event->id)
                        ->where('is_evaluate', true)->get();
        
        // get random comments from the evaluations
        $cevaluations = DB::table('evaluations')->where('event_id', $event->id)
                            ->where('is_evaluate', true)->inRandomOrder()->limit(10)->get();

        $commentsEvaluation = DB::table('forms')->where('event_id', $event->id)
                                ->where('input_type', 'comment')->get();
        $comments = [];                            
        
        foreach ($commentsEvaluation as $ckey => $cvalue) {

            foreach ($cevaluations as $ekey => $evalue) {
                $current = DB::table('evaluates')->where('evaluation_id', $evalue->id)
                                ->where('form_id', $cvalue->id)->get();
                $comments[$evalue->id] = $current[0]->answer;

            }
        }

        // get the evaluation of each questions and percemtage
        $evaluationQuestions = [];
        $percentage = [];

        foreach ($questions as $qkey => $qvalue) {

            for ($i=1; $i <= $maxOption; $i++) { 
                $count = 0;
                foreach ($evaluations as $ekey => $evalue) {
                    $current = DB::table('evaluates')
                        ->where('evaluation_id', $evalue->id)
                        ->where('form_id', $qvalue->id)->get();

                    if($current[0]->answer == $i) {
                        $count++;
                    }
                }
                $evaluationQuestions[$qvalue->id][$i] = $count;
                $percentage[$qvalue->id][$i] = $count * $i;
            }
        }

        // intialize the overall rating
        $overAllRating = 0;
        $remarks = [];
        // get the remarks of each questions
        if ($isEvaluate > 0) {

            foreach ($percentage as $pkey => $pvalue) {
                $remarks[$pkey] = round((array_sum($pvalue) / $isEvaluate), 2);
            }

            $overAllRating = round((array_sum($remarks) / count($remarks)), 2);
        }

        // return overAllRating, maxOption, $questions, $evaluationQuestion, $percentage, $totalParticipants, $isEvaluate, $isntEvaluate, $comments limit 10
        $reports = [];
        
        foreach ($questions as $qkey => $qvalue) {
            $reports[$qvalue->id]['question'] = $qvalue->question;
        }

        // dd($report);

        foreach ($evaluationQuestions as $eqkey => $eqvalue) {
            $reports[$eqkey]['count'] = $evaluationQuestions[$eqkey];
        }

        // foreach ($percentage as $pkey => $pvalue) {
        //     $reports[$pkey]['cp']['percentage'] = $percentage[$pkey];
        // }

        foreach ($remarks as $rkey => $rvalue) {
            $reports[$rkey]['remarks'] = $rvalue;
        }

        // dd($reports);

        $pdf = PDF::loadView('event.pdfreport', compact('event' , 'overAllRating', 'maxOption', 'reports', 'totalParticipants', 'isEvaluate', 'isntEvaluate', 'comments'))->setPaper('a4', 'portrait')->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        
        $fileName = $event->event_name.'-report';

        return $pdf->stream($fileName.'.pdf');

    }
}
