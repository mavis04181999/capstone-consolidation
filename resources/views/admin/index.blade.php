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
                <small style="font-size: 12px">Event Evaluation System</small>
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
            <a class="nav-link" href="{{ route('admin.user') }}">
                <i class="fa fa-users"></i>
                <span>User Dashboard</span>
            </a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.organizer') }}">
                <i class="fa fa-users"></i>
                <span>Organizer Dashboard</span>
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
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><i class="fa fa-2x fa-user-circle-o mr-1"></i> {{  Auth::user()->firstname }}</span>
                        </a>

                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('view.archives') }}">
                                <i class="fa fa-archive fa-sm fa-fw mr-2 text-gray-400"></i>
                                Archives
                            </a>
                            <a class="dropdown-item" href="{{ route('admin.settings') }}">
                                <i class="fa fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Settings
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                <i class="fa fa-sign-out fa-sm fa-fw mr-2 text-gray-400"></i>
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
                                            data-event="{{ $event }}"
                                            ><i class="fa fa-pencil-square-o"></i> Event Details</button>
                                            <a href="{{ route('manage.event', ['event' => $event->id]) }}">
                                                <button class="btn btn-info btn-sm"><i class="fa fa-list-alt"></i> Manage Event </button>
                                            </a>
                                            @switch(date("Y-m-d"))
                                                {{-- status: pending --}}
                                                @case( date("Y-m-d") < $event->start_date)                                                    
                                                    <button onclick="deleteEvent(event)" type="button" class="btn btn-sm btn-danger"
                                                    data-event="{{ $event }}"
                                                    ><i class="fa fa-trash-o"></i> Delete </button>
                                                    @break
                                                {{-- status: ongoing --}}
                                                @case(date("Y-m-d") >= $event->start_date && date("Y-m-d") < $event->end_date )
                                                    {{-- <p class="text-info">Ongoing</p> --}}
                                                    @break
                                                {{-- status: finish --}}
                                                @case(date("Y-m-d") >= $event->end_date )
                                                    <button onclick="archiveEvent(event)"  type="button" class="btn btn-sm btn-secondary"
                                                    data-event="{{ $event }}"
                                                    ><i class="fa fa-trash-o"></i> Archive</button>                                                    
                                            @endswitch
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
    <i class="fa fa-angle-up"></i>
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

    <script>
        var eventtable = new DataTable('#event-table', {
        sortable: true,
        fixedHeight: true,
        });
    </script>

    @include('admin.script-event')

@endsection



