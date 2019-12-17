<?php

namespace App\Http\Controllers;

use App\Evaluate;
use App\Evaluation;
use App\Event;
use App\Form;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EvaluatesController extends Controller
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
    public function create(Evaluation $evaluation, Evaluate $evaluate)
    {
        $event = Event::findorFail($evaluation->event_id);
        $forms = Form::where('event_id', $evaluation->event_id)->orderBy('order', 'asc')->get();
        return view('evaluates.create', compact('evaluation', 'evaluate', 'event', 'forms'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $forms = [];
        
        $evaluation_id = $request->evaluation_id;
        foreach ($request->answer as $answer => $value) {
            $forms[$answer] = [
                'evaluation_id' => $evaluation_id,
                'form_id' => $answer,
                'answer' => $value
            ];
        }
        $formA = [];
        foreach ($forms as $form => $value) {
            Evaluate::create($value);
        }
        
        $evaluation = Evaluation::find($evaluation_id);
        $evaluation->update([
            'is_evaluate' => true
            ]);
            
            $ticketdata = [
                'evaluation_id' => $evaluation_id,
                'ticket_code' => substr(Str::upper(Str::uuid()), 9, 9)
            ];
            
            $ticket = Ticket::create($ticketdata);
            
            return redirect()->route('ticket.show', $ticket->id)->with('success', 'Thank you for evaluating the event');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evaluate  $evaluate
     * @return \Illuminate\Http\Response
     */
    public function show(Evaluate $evaluate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evaluate  $evaluate
     * @return \Illuminate\Http\Response
     */
    public function edit(Evaluate $evaluate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evaluate  $evaluate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Evaluate $evaluate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evaluate  $evaluate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evaluate $evaluate)
    {
        //
    }
}
