<?php

namespace App\Http\Controllers;

use App\Event;
use App\Imports\ImportPayments;
use App\Payment;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Event $event)
    {
        $payments = Payment::with('user')->latest()->get();

        return view('payment.index', compact('event', 'payments'));
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
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment, Request $request)
    {
        $payment = Payment::with('user')->find($request->payment_id);

        $name = $payment['user']->lastname." ".$payment['user']->firstname;
        
        if(Payment::destroy($request->payment_id)) {
            return back()->with('success', $name.': Successfully remove from payments');
        }
    }

    public function destroys(Request $request) {
        if(boolval($request->payments == null)) {
            return back()->with('error', 'There is no selected participant');
        }
        
        $count = 0;
        
        foreach ($request->payments as $payment => $value) {
            $delpayment = Payment::find($payment);
            
            Payment::destroy($delpayment->id);
            
            $count++;
        }
        
        if ($count > 1) {
            return back()->with('success',  'Payments Remove from Event Successfully');
        }else {
            return back()->with('success',  'Payment Remove from Event Successfully');
        }
    }

    public function import(Request $request){
        // validate
        $validate = $request->validate([
            'import_payment' => ['required', 'file'],
            'event_id' => ['required']
        ]);

        $event_id = Event::find($validate['event_id']);

        try {

            // Excel::import(new ImportUsers(),  request()->file('import'));

            // return redirect()->route('admin.user')->with('success', 'Import Successfully');

            Excel::import(new ImportPayments($event_id), $validate['import_payment']);

            return back()->with('success', 'Import Payment Successfully');

        }    catch(\Maatwebsite\Excel\Validators\Failure $e) {
            $failures = $e->failures;

            foreach ($failures as $learn) {
                $learn->row();
                $learn->attribute();
                $learn->errors();
                $learn->values();
            }

        }
    }
}
