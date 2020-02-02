<?php

namespace App\Http\Controllers;

use App\Evaluation;
use App\Event;
use App\Participant;
use App\User;
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
        // validate the event code
        $validate = $request->validate([
            'event_code' => ['required', 'exists:events,event_code']
        ]);

        $user_id = Auth::user()->id;

        // find the event code and get the event
        $event = Event::where('event_code', $request->event_code)->first();
        
        // check if the event code is valid
        if ($request->event_code == $event->event_code) {
            // check first if the user register and attend the event in the participants table
            $participant = Participant::where('user_id', $user_id)->where('event_id', $event->id)->first();
            
            // check first if empty
            if (empty($participant)) {
                return back()->with('error', 'Invalid participant');
            }
            
            if ($participant->is_register == true and $participant->is_attend == true) {
                 // check if the user has evaluation
                $user_evaluation = Evaluation::where('user_id', $user_id)->where('event_id', $event->id)->first();
                // if the user has no evaluation
                if (empty($user_evaluation)) {

                    $create_evaluation = Evaluation::create([
                        'user_id' => $user_id,
                        'event_id' => $event->id,
                        'is_evaluate' => false,
                    ]);

                    if ($create_evaluation) {
                        // evaluate the event
                        return redirect()->route('evaluates.create', ['evaluation' => $create_evaluation->id]);
                    }
                }

                // if the user has evaluation and already evaluate the event
                if ($user_evaluation->is_evaluate == true) {
                    // redirect to the ticket
                    return redirect()->route('ticket.show', ['ticket' => $user_evaluation->ticket->id]);
                } else {
                // if the user has evaluation but not yet evaluate the event
                    return redirect()->route('evaluates.create', ['evaluation' => $user_evaluation->id]);
                }

            } else {
                // if the user is not register and not attend to the event
                return back()->with('error', 'Something is wrong, either you did not register or did not attend to the event');
            }
            
        } else {
            // invalid event code
            return back()->with('error', 'Invalid event code');
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
