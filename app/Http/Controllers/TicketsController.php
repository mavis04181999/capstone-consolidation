<?php

namespace App\Http\Controllers;

use App\Event;
use App\Participant;
use App\Ticket;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        $event = Event::where('id', $ticket->evaluation->event_id)->first();
        $user = User::where('id', $ticket->evaluation->user_id)->first();
        
        if(Auth::user()->id !== $user->id) {
            return redirect()->back()->with('error', 'Unauthorized Access');
        }
        return view('tickets.show', compact('ticket', 'event', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }

    public function pdfcertificate(Event $event, Request $request) {

        $participant = User::where('id', Auth::user()->id)->first();

        // dd($participant);

        $pdf = PDF::loadView('event.pdfcertificate', compact('event', 'participant'))->setPaper('letter', 'landscape')->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        
        $fileName = $event->event_name.'-report';

        return $pdf->stream($fileName.'.pdf');

    }
}
