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
            <a class="nav-link" href="{{ route('manage.event', ['event' => $event]) }}">
                <i class="fa fa-home"></i>
                <span>Main Dashboard</span>
            </a>
        </li>

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
                        <h4 class="text-dark"><i class="fa fa-calendar-o mr-1"></i> {{$event->event_name}}</h4>
                        <button onclick="eventFeature(event)" class="btn btn-primary"
                        data-event_id="{{$event->id}}"
                        data-event_name="{{$event->event_name}}"
                        {{-- data-features="{{$event->features()->pluck('feature_id')}}" --}}
                        data-features="{{ $event_plucks }}"
                        ><i class="fa fa-plus"></i> Event Feature</button>
                    </div>
                    <hr>
                    
                    <div class="row justify-content-center">
                        @if (count($event_features) > 0)
                            @foreach ($event_features as $feature)
                                @switch($feature)
                                @case($feature->feature_id == '1')
                                    <a href="{{ route('show.registration', ['event' => $event->id]) }}" class="col-sm-9" style="text-decoration: none; ">
                                        <div class="card mb-3 py-1 border-bottom-primary">
                                            <div class="card-body text-center">
                                                <h5 class="text-primary"><i class="fa fa-users"></i> Registration of Participants</h5>
                                            </div>
                                        </div>
                                    </a>                                
                                    @break
                                @case($feature->feature_id == '2')
                                    <a href="{{ route('show.attendance', ['event' => $event->id]) }}" class="col-sm-9" style="text-decoration: none; ">
                                        <div class="card mb-3 py-1 border-bottom-primary">
                                            <div class="card-body text-center">
                                                <h5 class="text-primary"><i class="fa fa-calendar-check-o"></i> Attendance</h5>
                                            </div>
                                        </div>
                                    </a>
                                    @break
                                @case($feature->feature_id == '3')
                                    <a href="{{ route('show.payment', ['event' => $event->id]) }}" class="col-sm-9" style="text-decoration: none; ">
                                        <div class="card mb-3 py-1 border-bottom-primary">
                                            <div class="card-body text-center">
                                                <h5 class="text-primary"><i class="fa fa-usd"></i> Payment Collection</h5>
                                            </div>
                                        </div>
                                    </a>
                                    @break
                                @case($feature->feature_id == '4')
                                    <a href="" class="col-sm-9" style="text-decoration: none; ">
                                        <div class="card mb-3 py-1 border-bottom-primary">
                                            <div class="card-body text-center">
                                                <h5 class="text-primary"><i class="fa fa-certificate"></i> Certification and ID Generation</h5>
                                            </div>
                                        </div>
                                    </a>
                                    @break
                                @case($feature->feature_id == '5')
                                    <a href="" class="col-sm-9" style="text-decoration: none; ">
                                        <div class="card mb-3 py-1 border-bottom-primary">
                                            <div class="card-body text-center">
                                                <h5 class="text-primary"><i class="fa fa-cutlery"></i> Kits and Meal Distribution</h5>
                                            </div>
                                        </div>
                                    </a>
                                    @break
                                @case($feature->feature_id == '6')
                                    @if ($event->form_type == null)
                                        {{-- go to modal and create choose/select form type --}}
                                        <button type="button" class="col-sm-9 form-group" style="text-decoration: none; background: none; border: none; padding: 0; margin: 0;" data-target="#select-formtype-modal" data-toggle="modal">
                                            <div class="card mb-3 py-1 border-bottom-primary ">
                                                <div class="card-body text-center">
                                                    <h5 class="text-primary"><i class="fa fa-list-alt"></i> Event Evaluation</h5>
                                                </div>
                                            </div>
                                        </button>
                                    @else
                                        {{-- else redirect to manage event --}}
                                        <a href="{{ route('show.event', ['event' => $event->id ]) }}" class="col-sm-9 form-group" style="text-decoration: none; ">
                                            <div class="card mb-3 py-1 border-bottom-primary ">
                                                <div class="card-body text-center">
                                                    <h5 class="text-primary"><i class="fa fa-list-alt"></i> Event Evaluation</h5>
                                                </div>
                                            </div>
                                        </a>
                                    @endif    
                                    @break
                                @endswitch
                            @endforeach
                        @else
                            <div class="col sm-9">
                                <p class="alert alert-info">no event feature available</p>
                            </div>
                        @endif
                    </div>
                </section>

                {{-- start: include modals --}}

                {{-- start: feature event modal --}}
                <div id="feature-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="feature-event-modal-label">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header justify-content-between">
                                <h5 class="modal-title" id="feature-event-modal-label">Feature Event: <span id="feature-event-name"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            
                            <form id="feature-event-form" action="{{ route('feature.event') }}" method="post">
                                @csrf
                                
                                <div class="modal-body">
                                    <input type="hidden" id="feature-event-event_id" name="event_id">
                                    

                                    @if (count($features) > 0)
                                        @foreach ($features as $feature)
                                        
                                        <div class="form-group-sm offset-1">
                                            <input type="checkbox" class="event-feature-{{ $feature->id }}" name="feature[{{$feature->id}}]" id="event-feature[{{$feature->id}}]">
                                            <label title="{{$feature->name}}" for="{{$feature->name}}" class="col-form-label">{{$feature->name}}</label>
                                        </div>
                                        
                                        @endforeach
                                    @endif
                                    
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end: feature event modal --}}
                
                {{-- start: feature event modal --}}
                <div id="select-formtype-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="select-formtype-modal-label">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header justify-content-between">
                                <h5 class="modal-title" id="select-formtype-modal-label">Select Form Type: <span id="feature-event-name"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            
                            <form id="feature-event-form" action="{{ route('formtype.event') }}" method="post">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <div class="modal-body">
                                    <div class="row form-group-sm col-sm-10">
                                        Evaluation Form types:
                                    </div>
                                    <div class="row form-group-sm col-sm-10">
                                        <div class="form-group-sm col-sm-5">
                                            <input type="radio" name="form_type" id="event-form-type-standard" value="0">
                                            <label for="Standard Form" class="col-form-label-sm">Standard Form</label>
                                        </div>
                                        <div class="form-group-sm col-sm-5">
                                            <input type="radio" name="form_type" id="event-form-type-custom" value="1">
                                            <label for="Custom Form" class="col-form-label-sm">Custome Form</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end: feature event modal --}}

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
    <script>
        function eventFeature(event) {
            var event_id = document.querySelector('#feature-event-modal #feature-event-form .modal-body #feature-event-event_id');
            event_id.value = event.target.dataset.event_id;
            
            var name = document.querySelector('#feature-event-modal #feature-event-name');
            name.textContent = event.target.dataset.name;
            
            var features = JSON.parse(event.target.dataset.features);
            
            if(features.length > 0) {
                features.forEach(element => {
                    console.log(element);
                    document.querySelector(`#feature-event-modal .event-feature-${element}`).checked = true;
                });
            }
            
            $('#feature-event-modal').modal({
                show: true,
                backdrop: "static",
                keyboard: false
            });
        }
    </script>
@endsection