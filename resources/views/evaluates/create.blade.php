@extends('layouts.app')

@section('content')
    <div class="container">
        @include('include.messages')


        <div class="header-wrapper mb-3">
            <h3 class="ml-2 text-dark"><i class="fa fa-calendar-check-o"></i> Event: {{$event->event_name}} </h3> 
        </div>
        <form id="submitForm" action="{{route('evaluates.store')}}" method="post">
            @csrf
            <input type="hidden" name="evaluation_id" id="evaluation-id" value="{{$evaluation->id}}">
            @foreach ($forms as $form)
            <div class="card">
                <h1></h1>
                <div class="card-body">
                    @if ($form->input_type == "comment")
                            <div class="form-group">
                                <label for="{{$form->question}}">{{$form->question}}</label>
                                {{-- <input class="form-control" type="text" name="answer[{{$form->id}}]" id="answer[{{$form->id}}]" placeholder="(optional)"> --}}
                                <textarea name="answer[{{$form->id}}]" id="answer[{{$form->id}}]" cols="10" rows="5" class="form-control" placeholder="Comments and Recommendation (optional)"></textarea>
                            </div>
                    @else
                            <label for="">{{$form->question}}</label>
                            @isset($form->option)
                                @foreach ($form->option as $option)
                                    <div class="form-group">                                 
                                        <input type="radio" name="answer[{{$form->id}}]" id="answer[{{$form->id}}]" value="{{$option->value}}" required>
                                        <label class="form-control-sm" for="{{$option->label}}">{{$option->label}}</label>
                                    </div>
                                @endforeach
                            @endisset  
                    @endif
                </div>
            </div>
            <hr>
            @endforeach
    
            <button type="submit" class="btn btn-primary" ><i class="fa fa-send"></i> Submit Evaluation</button>
        </form>
    </div>
@endsection
