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

        <li class="nav-item active">
            <a class="nav-link" href="#">
                <i class="fa fa-home"></i>
                <span>Main Dashboard</span>
            </a>
        </li>


        @if (Auth::user()->role == 'admin')
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('index.attendance', ['event' => $event->id]) }}">
            <i class="fa fa-calendar-check-o"></i>
            <span>Attendance</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('index.participants', ['event' => $event->id]) }}">
            <i class="fa fa-users"></i> 
            <span>Participants</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('index.payment', ['event' => $event->id]) }}">
            <i class="fa fa-usd"></i>
            <span>Payment Logs</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('index.setting', ['event' => $event->id]) }}">
            <i class="fa fa-cog"></i>
            <span>Event Setting</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.index') }}">
            <i class="fa fa-arrow-left"></i>
            <span>Return Admin</span>
          </a>
        </li>
        @endif

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
                           @if (Auth::user()->role == 'admin')
                            <a class="dropdown-item" href="{{ route('view.archives') }}">
                              <i class="fa fa-archive fa-sm fa-fw mr-2 text-gray-400"></i>
                              Archives
                            </a>
                            <div class="dropdown-divider"></div>
                           @endif                            
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
                
                <!-- Page Heading -->
                {{-- d-sm-flex --}}
                <div class="row mb-4 justify-content-between">
                    <div class="row col-sm-6">
                        <h3 class="h3 mb-0 text-gray-800"><i class="fa fa-calendar-check-o"></i> Event: {{$event->event_name}}</h3>
                    </div>
                    <div class="row col-sm-6 justify-content-end">
                        @switch(date("Y-m-d"))
                            @case(date("Y-m-d") < $event->start_date)
                                <a href="{{ route('form.edit', ['event' => $event->id]) }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mx-1"><i class="fa fa-pencil-square-o fa-sm text-white-50"></i> Edit Form</a>
                                @break
                            @case(date("Y-m-d") >= $event->start_date || date("Y-m-d") > $event->end_date)
                            <a href="{{ route('form.show', ['event' => $event->id]) }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mx-1"><i class="fa fa-envelope-open fa-sm text-white-50"></i> Show Form</a>
                                @break
                        @endswitch                                                
                        <a href="{{ route('event.pdfreport', ['event' => $event->id]) }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mx-1"><i class="fa fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>
                </div>
                
                <hr>
                
                <!-- Content Row -->
                <div class="row">
                  
                  <!-- Total Number of Users -->
                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$totalusers}}</div>
                          </div>
                          <div class="col-auto">
                            {{-- <i class="fas fa-calendar fa-2x text-gray-300"></i> --}}
                            <i class="material-icons">people</i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- Event Progress -->
                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Event Progress</div>
                            <div class="row no-gutters align-items-center">
                              <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">@if ($isevaluate > 0) {{round(($isevaluate / $totalusers)* 100)}} @else 0 @endif%</div>
                              </div>
                              <div class="col">
                                <div class="progress progress-sm mr-2">
                                  
                                  <div class="progress-bar bg-info" role="progressbar" @if ($isevaluate > 0) style="width:{{round(($isevaluate / $totalusers)* 100)}}%" @else style="width:0%" @endif aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-auto">
                            {{-- <i class="fas fa-clipboard-list fa-2x text-gray-300"></i> --}}
                            <i class="material-icons">track_changes</i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <!-- No. of Users Evaluate -->
                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Complete Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$isevaluate}}</div>
                          </div>
                          <div class="col-auto">
                            {{-- <i class="fas fa-dollar-sign fa-2x text-gray-300"></i> --}}
                            <i class="material-icons">thumb_up</i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  
                  <!-- Pending Requests Card Example -->
                  <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Requests</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$isntevaluate}}</div>
                          </div>
                          <div class="col-auto">
                            {{-- <i class="fas fa-comments fa-2x text-gray-300"></i> --}}
                            <i class="material-icons">timelapse</i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <!-- Content Row -->
                
                <!-- Bar Chart -->
                <div class="card shadow mb-4">
                  <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Bar Chart</h6>
                  </div>
                  <div class="card-body">
                    <div class="chart-bar">
                      {{-- <canvas id="myBarChart"></canvas> --}}
                      {!! $evaluationchart->container() !!}
                    </div>
                    <hr>
                    
                  </div>
                </div>
                
                <div class="row">
                  @foreach ($reports as $report)
                  <div class="col-lg-6">
                    @if (isset($report['remarks']))
                    @switch($report['remarks'])
                    @case($report['remarks'] > 3)
                    <div class="card mb-4 py-3 border-left-success">
                      <div class="card-body">
                        Rating: {{$report['question']}}
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$report['remarks']}} / {{ $maxOption}}</div>
                        </div>
                        <div class="progress progress-sm mr-2">                          
                          <div class="progress-bar bg-info" role="progressbar" style="width:{{round(($report['remarks'] / $maxOption)* 100)}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                    @break
                    @case($report['remarks'] > 2)
                    <div class="card mb-4 py-3 border-left-info">
                      <div class="card-body">
                        Rating: {{$report['question']}}
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$report['remarks']}} / {{ $maxOption}}</div>
                        </div>
                        <div class="progress progress-sm mr-2">                          
                          <div class="progress-bar bg-info" role="progressbar" style="width: {{round(($report['remarks'] / $maxOption)* 100)}}%" aria-valuenow="2.5" aria-valuemin="0" aria-valuemax="5"></div>
                        </div>
                      </div>
                    </div>
                    @break
                    @default
                    <div class="card mb-4 py-3 border-left-warning">
                      <div class="card-body">
                        Rating: {{$report['question']}}
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$report['remarks']}} / {{ $maxOption}}</div>
                        </div>
                        <div class="progress progress-sm mr-2">                          
                          <div class="progress-bar bg-info" role="progressbar" style="width:{{$report['remarks']}}" aria-valuenow="2.5" aria-valuemin="0" aria-valuemax="5"></div>
                        </div>
                      </div>
                    </div>
                    @endswitch
                    @else
                    <div class="card mb-4 py-3 border-left-warning">
                      <div class="card-body">
                        Rating: {{$report['question']}}
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="progress progress-sm mr-2">                          
                          <div class="progress-bar bg-info" role="progressbar" style="width:1%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                    @endif
                  </div>
                  
                  @endforeach
                </div>
                {{-- end: row --}}
                

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
<link href="{{ asset('css/chartjs/Chart.min.css') }}" rel="stylesheet">

<script src="">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
  <script src="{{ asset('js/chartjs/Chart.min.js') }}"></script>
  {!! $evaluationchart->script() !!}
</script>

@endsection

