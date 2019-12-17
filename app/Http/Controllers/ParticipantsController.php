<?php

namespace App\Http\Controllers;


use App\Event;
use App\Participant;
use App\User;
use Illuminate\Http\Request;

class ParticipantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        $participants = Participant::with('user')->where('event_id', $event->id)->whereIn('is_register', [0,1])->get();

        return view('event.index-participants', compact('event', 'participants'));
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
        if(boolval($request->user == null)) {
            return back()->with('error', 'There is no selected user');
        }

        $count = 0;

        foreach ($request->user as $user => $value) {
            $getUser = User::find($user);
            
            $participants = [
                'user_id' => $getUser->id,
                'event_id' => $request->event_id,
                'certificate_name' => $getUser->certificate_name,
                'nickname' => $getUser->nickname,
                // 0 means pending
                'is_register' => 0,
            ];

            Participant::create($participants);

            $count++;
        }

        if ($count > 1) {
            return back()->with('success',  'Participants Added Successfully');
        }else {
            return back()->with('success',  'Participant Added Successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function show(Participant $participant, Event $event)
    {
        $users = User::user()->with('department', 'course', 'section')->get();

        $register = Participant::where('event_id', $event->id)->where('is_register', 1)->pluck('user_id')->toArray();

        $pending = Participant::where('event_id', $event->id)->where('is_register', 0)->pluck('user_id')->toArray();

        return view('event.show-participants', compact('event', 'users', 'pending', 'register'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Participant  $participant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Participant $participant, Request $request)
    {
        $participant = Participant::with('user')->find($request->participant_id);

        $name = $participant['user']->lastname." ".$participant['user']->firstname;
        
        if(Participant::destroy($request->participant_id)) {
            return back()->with('success', $name.': Successfully remove from participants');
        }
    }

    public function destroys(Request $request){

        if(boolval($request->participants == null)) {
            return back()->with('error', 'There is no selected participant');
        }
        
        $count = 0;
        
        foreach ($request->participants as $participant => $value) {
            $delparticipant = Participant::find($participant);
            
            Participant::destroy($delparticipant->id);
            
            $count++;
        }
        
        if ($count > 1) {
            return back()->with('success',  'Participants Remove from Event Successfully');
        }else {
            return back()->with('success',  'Participant Remove from Event Successfully');
        }
        
    }
    
}
