<?php

namespace App\Http\Controllers;

use App\Event;
use App\Participant;
use App\Payment;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegistrationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
    public function show(Participant $participant, Event $event)
    {   
        return view('registration.show', compact('event'));
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
            'username' => ['required', 'exists:users,username', 'min: 3'],
            'certificate_name' => ['required', 'min: 3'],
            'nickname' => ['required'],
            'receipt' => ['required', 'exists:payments,receipt'],
            'password' => ['required']
        ]);  

        // get the user from username from participant
        $user = User::where('username', $validate['username'])->first();

        $participant = Participant::with('user')->where('user_id', $user->id)->first();

        // authenticate the user by his password
        if(Hash::check($validate['password'], $user->password) == true) {
            // check if payment is correct
            $payment = Payment::where('receipt', strtoupper($validate['receipt']))->first();

            if($participant->user_id == $payment->user_id) {
                // dd($user->id, $validate);
                $participant->update([
                    'certificate_name' => $validate['certificate_name'],
                    'nickname' => $validate['nickname'],
                    'is_paid' => 1,
                    'is_register' => 1,
                    'date_registered' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);

                return back()->with('success', 'You are now register');
            }else {
                return back()->with('error', 'Receipt do not match to the user');
            }

        }else {
            return back()->with('error', 'User Credentials do not match');
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
