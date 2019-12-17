<?php

namespace App\Http\Controllers;

use App\Event;
use App\Form;
use App\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FormsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        $form = Form::where('event_id', $event['id'])->orderBy('order', 'asc')->get();

        return response()->json([
            'response' => $form
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Event $event)
    {
        return view('form.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // get the login user
       $loginUser = strval(Auth::user()->id);

       $data = $request->validate([
           'event_id' => ['required'],
           'input_type' => ['required'],
           'question' => ['required', 'max:255'],
           'order' => ['required']
       ]);
       
       $form = Form::create([
           'user_id' => $loginUser,
           'event_id' => $data['event_id'],
           'input_type' => $data['input_type'],
           'question' => $data['question'],
           'order' => $data['order']
       ]);

       // create response:
       $response = [
           'response' => $form,
           'status' => (bool) $form,
           'message' => $form ? 'form successfully created' : 'form fail to create'
       ];

       return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function edit(Form $form, Event $event)
    {
        return view('form.edit', compact('event', 'form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Form $form)
    {
        $form->question = $request->question;
        $form->order = $request->order;

        if($form->save()) {
            return response()->json([
                'response' => $form::all(),
                'validated' => $request->question
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Form $form)
    {
        $form = $form->delete();

        $response = [
            'response' => $form,
            'status' => (bool) $form,
            'message' => $form ? 'delete successfully' : 'delete fail'
        ];

        return response()->json($response);
    }

    public function options(Form $form)
    {
        $response = Option::where('form_id', $form['id'])->orderBy('value', 'desc')->get();

        return response()->json([
            'response' => $response
        ]);

    }

    public function optionsdel(Form $form)
    {
        $response = DB::delete('DELETE FROM `options` WHERE form_id = '. $form->id);

        $response = [
            'response' => $response,
            'status' => (bool) $response,
            'message' => $response ? 'delete successfully' : 'delete fail'
        ];

        return response()->json($response);
    }
}
