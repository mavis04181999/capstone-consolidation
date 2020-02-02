@extends('layouts.app')

@section('content')

{{-- authenticate with role: admin and organizer --}}
<div id="wrapper">
    
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
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
            Manage Event:
        </div>

        <li class="nav-item">
                <a class="nav-link" href="{{ route('manage.event', ['event' => $event->id]) }}">
                    <i class="fa fa-home"></i>
                    <span>Main Dashboard</span>
                </a>
            </li>
    
            <li class="nav-item">
                <a class="nav-link" href="{{ route('manage.event', ['event' => $event->id]) }}">
                    <i class="fa fa-arrow-left"></i>
                    <span>Return Back</span>
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
                            <a class="dropdown-item" href="#">
                                <i class="fa fa-archive fa-sm fa-fw mr-2 text-gray-400"></i>
                                Archives
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

            {{-- start: container fluid --}}
            <div class="container-fluid">

                @include('include.messages')

                <section>
                    <div class="row justify-content-between">
                        <h4 class="text-dark"><i class="fa fa-users mr-1"></i> {{$event->event_name}}: Attendance</h4>
                    </div>

                    {{-- event image --}}
                    @if (isset($event->event_image))
                    <div class="row">
                        <div class="col-sm-12" style="margin-top: 20px; dispay: inline-block; text-align: center;" >
                            <img style="height: 150px; width: 600px;" src="{{ asset('storage/event-image/'.$event->event_image.' ') }}" alt="">
                        </div>
                    </div>
                    @endif

                    <hr style="height: 25px">

                    <div class="col-sm-12">
                        <form action="{{ route('update.attendance', ['event' => $event->id]) }}" method="post">
                            @csrf
                            @method('patch')
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <div class="row justify-content-center">
                                <div class="form-group-sm col-sm-4 d-flex mb-3">
                                    <label for="" class="col-form-label-sm"><small><i class="fa fa-user-circle"></i></small></label>
                                    <input type="text" class="form-control ml-3" name="username" placeholder="Username">
                                </div>
                            </div>
                            
                            <div class="row justify-content-center">
                                <div class="form-group-sm col-sm-4">
                                    <button type="submit" class="btn btn-primary my-3">Attend</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </section>

                {{-- start: include modals --}}


                {{-- end: include modals --}}
            
            </div>
            <!-- end: container-fluid -->

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

    <script>

    </script>
@endsection