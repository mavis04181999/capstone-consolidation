@extends('layouts.app') 

@section('content')
    <div class="container">
        @include('include.messages')
        {{-- start: event table --}}
        <div class="row">
            <div class="col-sm-2">
                <button
                class="btn btn-outline-primary float-right mb-3"
                onclick="loginEventModal(event)"
                {{-- data-event_id="{{$event->id}}"
                data-event_name="{{$event->event_name}}" --}}
                >
                <i class="fa fa-list-alt"></i> Evaluate
                </button>
            </div>
            <div class="col-sm-10">
                @if (count($evaluations) > 0 )
                    @foreach ($evaluations as $evaluation)     
                        @foreach ($events as $event)
                            @if ($event->id == $evaluation->event_id)
                                @if ($evaluation->is_evaluate == true)
                                    <div class="card card-body">
                                        <div class="col-md-8 col-sm-8">
                                            <h3 class="card-title">
                                            <i class="fa fa-calendar-check-o"></i> Event: {{$event->event_name}}
                                            </h3>
                                            {{-- <small>Organizer: {{$event->organizer->firstname}} {{$event->organizer->lastname}}</small> --}}
                                            <a href="{{route('ticket.show', ['ticket' => $evaluation->ticket->id])}}">
                                            <button
                                            class="btn btn-outline-primary float-right"
                                            >
                                            <i class="fa fa-ticket"></i> Ticket Code
                                            </button></a>
                                        </div>
                                    </div>
                                    <hr>
                                @else
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="col-md-8 col-sm-8">
                                            <h3 class="card-title">
                                            Event: {{$event->event_name}}
                                            </h3>
                                            <small>Organizer: {{$event->user->firstname}}</small>
                                            <button
                                            class="btn btn-outline-primary float-right"
                                            onclick="loginEventModal(event)"
                                            data-event_id="{{$event->id}}"
                                            data-event_name="{{$event->event_name}}"
                                            >
                                            Evaluate
                                            </button>
                                            </div> 
                                        </div>
                                    </div>                            
                                @endif
                                {{-- end of evaluation is evaluate --}}
                            @else
                            {{-- if there is no evaluation to event do nothing --}}
                            @endif
                        @endforeach
                    @endforeach
                @else
                    <p class="alert alert-info">you have no available evaluation</p>
                @endif
            </div>
        
        
        </div>
        {{-- end: event table --}}
    </div>
    {{-- end: div container --}}


{{-- start: event login modal --}}
<div
    class="modal fade"
    id="event-login-modal"
    tabindex="-1"
    role="dialog"
    aria-hidden="true"
    aria-labelledby="user-modal-label"
>
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event-login-label">
                    Login Event:
                </h5>

                <button
                    class="close"
                    type="button"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- make evaluation when validate the eventcode and start evaluate --}}
            <form action="{{route('evaluation.store')}}" method="post">
                <div class="modal-body">
                    @csrf
                    <div class="form-group row">
                        <label
                            for=""
                            class="col-md-4 col-form-label text-md-right"
                            ><i class="fa fa-key"></i> Event Code:
                        </label>

                        <div class="col-md-6">
                            <input
                                type="text"
                                class="form-control @error('event-code') is-invalid @enderror"
                                name="event_code"
                                value="{{ old('event-code') }}"
                                required
                                autofocus
                            />

                            @error('event-code')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-send"></i> Submit
                    </button>

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        <i class="fa fa-close"></i> Close
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: event login modal --}}
@endsection

@section('scripts')
    <script>
        function loginEventModal(event) {
            console.log(event.target.dataset);
            
            $("#event-login-modal").modal({
                show: true,
                backdrop: "static",
                keyboard: false
            });
        }
    </script>
@endsection
