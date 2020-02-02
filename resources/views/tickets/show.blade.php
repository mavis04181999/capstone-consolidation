@extends('layouts.app')

@section('content')
    <div class="container">    
        @include('include.messages') 
        <h1>{{$ticket->user_id}}</h1>
        @if (!Auth::guest())
            @if (Auth::user()->id == $user->id)
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6 offset-sm-3">
                            <div id="user-ticket" class="card justify-content-center text-center">
                                <div class="card-header m-1">
                                    <h3><i class="fa fa-ticket"></i> Ticket Code</h3>
                                </div>
                                <div class="card card-body" style="height: 300px">
                                    <div class="mb-3">
                                        <p>Thank you for Evaluating the {{$event->event_name}}</p>
                                        <small>Ticket : {{$ticket->ticket_code }}</small>                                        
                                    </div>
                                    <div>
                                        <a href="{{ route('event.pdfcertificate', ['event' => $event->id]) }}" target="_blank" class="btn btn-sm btn-primary shadow-sm mx-1"><i class="fa fa-certificate fa-sm text-white-50"></i> Certificate</a>
                                    </div>
                                </div>
                                <div class="card-footer">                       
                                    <button class="btn btn-outline-primary" type="button" onclick="returnHome(event)"><i class="fa fa-home"></i> Return Home</button>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
@endsection

@section('scripts')
    <script>
        function returnHome(event){
            console.log('click');

            window.location.href = "{{ route('user.index') }}";
        }
    </script>
@endsection