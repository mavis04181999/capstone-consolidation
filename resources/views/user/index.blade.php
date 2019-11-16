@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Hello User</h1><span>{{ Auth::user()->role }}</span>
    </div>
@endsection