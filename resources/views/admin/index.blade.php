@extends('layouts.app')

@section('content')
    @include('include.messages')
    {{-- users dashboard --}}
    <section id="user-dashboard">
        <div class="row">
            <div class="col-sm-12">
                <div class="row justify-content-between">
                    <h1 class="h4 mb-0 text-gray-900">User Dashboard</h1>
                    <button type="button" class="btn btn-outline-primary" data-target="#create-user-modal" data-toggle="modal">Create User</button>
                </div>
                
                <hr class="divider">

                {{-- users table --}}
                <form id="delete-users-form" action="{{ route('deletes.user') }}" method="post">
                    @csrf
                    @method('delete')
                    <table id="user-table" class="table table-condensed text-dark table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Course</th>
                                <th>Section</th>
                                <th>Default Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($users))
                                @foreach ($users as $user)
                                    <tr>
                                        <td><input type="checkbox" class="check-user" name="user[{{$user->id}}]" id="user[{{$user->id}}]"></td>
                                        <td>{{$user->firstname}}</td>
                                        <td>{{$user->lastname}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->course->abbr}}</td>
                                        <td>{{$user->section->section}}</td>
                                        <td>{{$user->temppassword}}</td>
                                        <td>
                                            <button onclick="updateUser(event)" type="button" class="btn btn-sm btn-info"
                                            data-user_id="{{$user->id}}"
                                            data-firstname="{{$user->firstname}}"
                                            data-middlename="{{$user->middlename}}"
                                            data-lastname="{{$user->lastname}}"
                                            data-email="{{$user->email}}"
                                            data-address="<?php echo $address = (isset($user->address)) ? $user->address : null ; ?>"
                                            data-contactno="<?php echo $contactno = (isset($user->contactno)) ? $user->contactno : null ; ?>"
                                            data-department="<?php echo $department = (isset($user->department->id)) ? $user->department->id : null ; ?>"
                                            data-course="<?php echo $course = (isset($user->course->abbr)) ? $user->course->abbr : null ; ?>"
                                            data-section="<?php echo $section = (isset($user->section->section)) ? $user->section->section : null ; ?>"
                                            data-year="<?php echo $year = (isset($user->year)) ? $user->year : null ; ?>"
                                            data-username="{{$user->username}}"
                                            >Edit</button>
                                            <button onclick="deleteUser(event)" type="button" class="btn btn-sm btn-danger"
                                            data-user_id="{{$user->id}}"
                                            data-name="{{$user->firstname}} {{$user->lastname}}"
                                            >Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <p class="alert alert-info">No Record Found</p>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                        <button type="button" id="checkall-user" class="btn btn-primary check-user">Check all</button>
                        <button type="submit" class="btn btn-danger ml-1 delete-user">Delete</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
            <form action="{{route('import.user')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-content">
                    <div class="form-body form-group-sm mb-3">
                        <label for="import-user"></label>
                        <input type="file" name="import" id="import" class="form-control-file">
                    </div>
                    <div class="form-footer form-group-sm">
                        {{-- button: import users --}}
                        <button type="submit" class="btn btn-outline-primary">Import File</button>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </section>
    <hr class="divider">
    {{-- organizers table --}}
    <section id="organizer-dashboard">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <h1 class="h4 mb-0 text-gray-900">Organizer Table</h1>
                </div>
                <hr class="divider">
                {{-- organizers table --}}
                <form action="{{ route('deletes.user') }}" id="delete-organizer-form" method="post">
                    @csrf
                    @method('delete')
                    <table id="organizer-table" class="table table-condensed text-dark">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Username</th>
                                <th>Default Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($organizers))
                                @foreach ($organizers as $organizer)
                                    <tr>
                                        <td><input type="checkbox" class="check-organizer" name="user[{{$organizer->id}}]" id="user[{{$organizer->id}}]"></td>
                                        <td>{{$organizer->firstname }}</td>
                                        <td>{{$organizer->lastname }}</td>
                                        <td>{{$organizer->email }}</td>
                                        <td>{{$organizer->username }}</td>
                                        <td>{{$organizer->temppassword}}</td>
                                        <td>
                                            <button onclick="updateUser(event)" type="button" class="btn btn-sm btn-info"
                                            data-user_id="{{$organizer->id}}"
                                            data-firstname="{{$organizer->firstname}}"
                                            data-middlename="{{$organizer->middlename}}"
                                            data-lastname="{{$organizer->lastname}}"                                            
                                            data-email="{{$organizer->email}}"
                                            data-address="<?php echo $address = (isset($organizer->address)) ? $organizer->address : null ; ?>"                            
                                            data-contactno="<?php echo $contactno = (isset($organizer->contactno)) ? $organizer->contactno : null ; ?>"
                                            data-department="<?php echo $department = (isset($organizer->department->id)) ? $organizer->department->id : null ; ?>"
                                            data-course="<?php echo $course = (isset($organizer->course->abbr)) ? $organizer->course->abbr : null ; ?>"
                                            data-section="<?php echo $section = (isset($organizer->section->section)) ? $organizer->section->section : null ; ?>"
                                            data-year="<?php echo $year = (isset($organizer->year)) ? $organizer->year : null ; ?>"
                                            data-username="{{$organizer->username}}"
                                            >Edit</button>
                                            <button onclick="deleteUser(event)" type="button" class="btn btn-sm btn-danger"
                                            data-user_id="{{$organizer->id}}"
                                            data-name="{{$organizer->firstname}} {{$organizer->lastname}}"
                                            >Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <p class="alert alert-info">No Record Found</p>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <button type="button" id="checkall-organizer" class="btn btn-primary check-organizer">Check all</button>
                    <button type="submit" class="btn btn-danger ml-1 delete-organizer">Delete</button>
                </form>
            </div>
        </div>
    </section>
    <hr class="divider">
    {{-- events table --}}
    <section id="event-dashboard">
        <div class="row">
            <div class="col-sm-12">
                <div class="row justify-content-between">
                    <h1 class="h4 mb-0 text-gray-900">Event Dashboard</h1>
                    <button class="btn btn-outline-primary">Create Event</button>
                </div>
                <hr class="divider">
                {{-- event table --}}
                <form id="delete-event-form" action="" method="post">
                    @csrf
                    @method('delete')
                    <table id="event-table" class="table table-condensed text-dark">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Event Code</th>
                                <th>Event Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </form>
            </div>
        </div>
    </section>

    {{-- start: modals --}}
    
    @include('admin.modal-user')

    {{-- end: modals --}}
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/vanilla-dataTables.min.css')}}">
    <script src="{{ asset('js/vanilla-dataTables.js') }}"></script>
    @include('admin.script-user')
    @include('admin.script-tables')
    @include('admin.script-delete')
@endsection



