<?php

namespace App\Http\Controllers;

use App\Event;
use App\Participant;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        $attends = Participant::with('user')->where('is_attend', 1)->get();

        return view('attendance.index', compact('event', 'attends'));
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
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event, Participant $participant)
    {

        return view('attendance.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function edit(Participant $participant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Participant $participant)
    {
        $validate = $request->validate([
            'event_id' => ['required'],
            'username' => ['required', 'exists:users,username'],
        ]);

        // check if he is registered participant
        
        // get the user
        $user = User::where('username', $validate['username'])->first();

        $name = $user->lastname." ".$user->firstname;
        
        $participant = Participant::where('event_id', $validate['event_id'])->where('user_id', $user->id)->first();

        if($participant->is_register == 1 && $participant->is_paid == 1) {

            $participant->update([
                'is_attend' => 1,
                'date_attendance' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);

            return back()->with('success', $name.': Thank you for attending the event');
        }else {
            return back()->with('error', 'Failed to comply requirements');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participant $participant)
    {
        //
    }
}
