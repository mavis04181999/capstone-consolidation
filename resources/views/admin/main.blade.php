@extends('layouts.app')

@section('content')

{{-- authenticate with role: admin and organizer --}}
<div id="wrapper">
    
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.index') }}">
            <div class="sidebar-brand-icon">
                <small><img src="{{ asset('storage/logo/cspc-logo.png')}}" height="50" width="50" alt=""></small>
            </div>
            <div class="sidebar-brand-text mr-1">
                <small class="text-xs" style="font-size: 10px">Centralized Event Management System</small>
            </div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            <i class="fa fa-user-circle-o mr-2"></i>Admin Dashboard
        </div>

        <!-- Nav Item - Charts -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('admin.index') }}">
                <i class="fa fa-home"></i>
                <span>Main Dashboard</span>
            </a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.user') }}">
                <i class="fa fa-users"></i>
                <span>User Table</span>
            </a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard.organizer') }}">
                <i class="fa fa-users"></i>
                <span>Organizer Table</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
    <!-- End of Sidebar -->
                
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <div class="topbar-divider d-none d-sm-block"></div>

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><i class="fa fa-2x fa-user-secret mr-1"></i> {{  Auth::user()->firstname }}</span>
                        {{-- <img class="img-profile rounded-circle" src="https://source.unsplash.com/QAB-WJcbgJk/60x60"> --}}
                        </a>

                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="dropdown-item" href="#">
                                <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                Activity Log
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                Logout
                            </a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->

            <div class="container-fluid">

                @include('include.messages')
                {{-- users dashboard --}}
                <section id="user-dashboard">
                    <div class="row">
                        <div class="col-sm-12">
                        <div class="row justify-content-between">
                            <h1 class="h4 mb-0 text-gray-900"><i class="fa fa-users mr-1"></i> User Dashboard</h1>
                            <button type="button" class="btn btn-primary" data-target="#create-user-modal" data-toggle="modal"><i class="fa fa-plus"></i> Create User</button>
                        </div>

                        <hr class="divider">

                            {{-- users table --}}
                        <form id="delete-users-form" action="{{ route('deletes.user') }}" method="post">
                        @csrf
                        @method('delete')
                        <table id="user-table" class="table table-condensed text-dark table-striped">
                            <thead>
                                <tr>
                                    <th>.</th>
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
                                @if (isset($users) && count($users) > 0)
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
                                        data-middlename="<?php echo $middlename = ($user->middlename != null) ? $user->middlename : null ;  ?>"
                                        data-lastname="{{$user->lastname}}"
                                        data-email="{{$user->email}}"
                                        data-address="<?php echo $address = ($user->address != null) ? $user->address : null ;  ?>"
                                        data-contactno="<?php echo $contactno = ($user->contactno != null) ? $user->contactno : null ; ?>"
                                        data-department="<?php echo $department_id = ($user->department_id != null) ? $user->department_id : null ; ?>"
                                        data-course="<?php echo $course = ($user->course->abbr != null) ? $user->course->abbr : null ; ?>"
                                        data-section="<?php echo $section = ($user->section->section != null) ? $user->section->section : null ; ?>"
                                        data-year="<?php echo $year = ($user->year != null) ? $user->year : null ; ?>"
                                        data-username="{{$user->username}}"
                                        ><i class="fa fa-pencil-square-o"></i> Edit</button>
                                        <button onclick="deleteUser(event)" type="button" class="btn btn-sm btn-danger"
                                        data-user_id="{{$user->id}}"
                                        data-name="{{$user->firstname}} {{$user->lastname}}"
                                        ><i class="fa fa-trash-o"></i> Delete</button>
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
                            <button type="button" id="checkall-user" class="btn btn-primary btn-sm check-user"><i class="fa fa-check-circle"></i> Check all</button>
                            <button type="submit" class="btn btn-sm btn-danger ml-1 delete-user"><i class="fa fa-trash-o"></i> Delete</button>
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
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload mr-1"></i> Import File</button>
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
                                <h1 class="h4 mb-0 text-gray-900"><i class="fa fa-users mr-1"></i> Organizer Table</h1>
                            </div>
                        <hr class="divider">
                        {{-- organizers table --}}
                        <form action="{{ route('deletes.user') }}" id="delete-organizer-form" method="post">
                        @csrf
                        @method('delete')
                        <table id="organizer-table" class="table table-condensed text-dark">
                            <thead>
                                <tr>
                                    <th>.</th>
                                    <th>Firstname</th>
                                    <th>Lastname</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Default Password</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($organizers) && count($organizers) > 0)
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
                                            data-department="<?php echo $department = (isset($organizer->department_id)) ? $organizer->department_id : null ; ?>"
                                            data-course="<?php echo $course = (isset($organizer->course->abbr)) ? $organizer->course->abbr : null ; ?>"
                                            data-section="<?php echo $section = (isset($organizer->section->section)) ? $organizer->section->section : null ; ?>"
                                            data-year="<?php echo $year = (isset($organizer->year)) ? $organizer->year : null ; ?>"
                                            data-username="{{$organizer->username}}"
                                            ><i class="fa fa-pencil-square-o"></i> Edit</button>
                                            <button onclick="deleteUser(event)" type="button" class="btn btn-sm btn-danger"
                                            data-user_id="{{$organizer->id}}"
                                            data-name="{{$organizer->firstname}} {{$organizer->lastname}}"
                                            ><i class="fa fa-trash-o"></i> Delete</button>
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
                            <button type="button" id="checkall-organizer" class="btn btn-sm btn-primary check-organizer"><i class="fa fa-check-circle"></i> Check all</button>
                            <button type="submit" class="btn btn-sm btn-danger ml-1 delete-organizer"><i class="fa fa-trash-o"></i> Delete</button>
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
                                <h1 class="h4 mb-0 text-gray-900"><i class="fa fa-calendar-o mr-1"></i> Event Dashboard</h1>
                                <button type="button" class="btn btn-primary" data-target="#create-event-modal" data-toggle="modal"><i class="fa fa-plus"></i> Create Event</button>
                            </div>
                        <hr class="divider">
                        {{-- event table --}}
                        <table id="event-table" class="table table-condensed text-dark">
                            <thead>
                                <tr>
                                    <th>Event Code</th>
                                    <th>Event Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($events) && count($events) > 0)
                                    @foreach ($events as $event)
                                    <tr>
                                        <td>{{$event->event_code }}</td>
                                        <td>{{$event->event_name }}</td>
                                        <td>
                                            <button onclick="updateEvent(event)" type="button" class="btn btn-sm btn-info"
                                            data-event_id = "{{$event->id}}"
                                            data-event_name= "{{$event->event_name}}"
                                            data-organizer_id= "{{$event->organizer_id}}"
                                            data-location= "{{$event->location}}"
                                            data-event_type= "{{$event->event_type}}"
                                            
                                            data-start_date= "{{$event->start_date}}"
                                            data-end_date= "{{$event->end_date}}"
                                            data-department_id= "<?php echo $department_id = ($event->department_id != null) ? $event->department_id : null ;  ?>"
                                            data-max_participants= "<?php echo $max_participants = ($event->max_participants != null) ? $event->max_participants : null ;  ?>"
                                            
                                            data-allow_prereg= "<?php echo $allow_prereg = ($event->allow_prereg != null) ? $event->allow_prereg : null ;  ?>"
                                            data-prereg_slot= "<?php echo $prereg_slot = ($event->prereg_slot != null) ? $event->prereg_slot : null ;  ?>"
                                            data-fee= "<?php echo $fee = ($event->fee != null) ? $event->fee : null ;  ?>"
                                            data-event_overview= "<?php echo $event_overview = ($event->event_overview != null) ? $event->event_overview : null ;  ?>"
                                            data-status= "<?php echo $status = ($event->status != null) ? $event->status : null ;  ?>"
                                            ><i class="fa fa-pencil-square-o"></i> Event Details</button>
                                            {{-- <button onclick="eventFeature(event)" class="btn btn-sm btn-info"
                                            data-event_id="{{$event->id}}"
                                            data-event_name="{{$event->event_name}}"
                                            data-features={{$event->features()->pluck('feature_id')}}
                                            >Feature</button> --}}
                                            <a href="{{ route('show.event', ['event' => $event->id]) }}">
                                                <button class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i> Manage Event</button>
                                            </a>
                                            <button onclick="deleteEvent(event)" type="button" class="btn btn-sm btn-danger"
                                            data-event_id="{{$event->id}}"
                                            data-event_name="{{$event->event_name}}"
                                            ><i class="fa fa-trash-o"></i> Delete</button>
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
                        </div>
                    </div>
                </section>

                {{-- start: include modals --}}

                @include('admin.modal-user')

                @include('admin.modal-event')

                {{-- end: include modals --}}
            
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; CSPC BSIT - 2019</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
                
</div>
<!-- End of Page Wrapper -->
            
<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
        
@endsection

@section('scripts')
    <link rel="stylesheet" href="{{ asset('css/vanilla-dataTables.min.css')}}">

    <script src="{{ asset('js/vanilla-dataTables.js') }}"></script>

    @include('admin.script-user')

    @include('admin.script-event')

    @include('admin.script-tables')

    @include('admin.script-delete')

@endsection



