<?php

namespace App\Http\Controllers;

use App\Evaluation;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationsController extends Controller
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
        // get the login user:
        $user_id = strval(Auth::user()->id);
        //validate the event_code
        $event_code = $request->validate([
            'event_code' => 'required'
            ]);
            // search the event code and get the event offset problem
            $event = Event::where('event_code', $event_code)->first();
            if(empty($event)){
                return redirect()->back()->with('error', 'Invalid Event Code');
            }
            $event = Event::find($event->id);
            
            // dd($event_code['event_code'] == $event->event_code);
            
            // get the validate code and check if the same of the event search
            if($event_code['event_code'] == $event->event_code){
                
                $evaluation = Evaluation::where('user_id', $user_id)->where('event_id', $event->id)->first();
                
                if (empty($evaluation)) {
                    // dd("true", $evaluation);
                    // if has no evaluation create new evaluation data
                    $data = [
                        'user_id' => $user_id,
                        'event_id' => $event->id,
                        'is_evaluate' => false,
                    ];
                    // commit create
                    $evaluation = Evaluation::create($data);
                    if($evaluation) {
                        return redirect()->route('evaluates.create', ['evaluation' => $evaluation->id]);
                    }
                    
                    
                } else {
                    // if there is an evaluation
                    // and the is evaluate is true redirect to the ticket code
                    if ($evaluation->is_evaluate == true) {
                        // dd("true", $evaluation, $evaluation->ticket->ticket_code);
                        return redirect()->route('ticket.show', ['ticket' => $evaluation->ticket->id]);
                    } else {
                        //    dd("false", $evaluation);
                        return redirect()->route('evaluates.create', ['evaluation' => $evaluation->id]);
                    }
                    
                }
                
            }else {
                return redirect()->back()->with('error', 'Invalid Event Code');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluation $evaluation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluation $evaluation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluation $evaluation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evaluation  $evaluation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluation $evaluation)
    {
        //
    }
}
