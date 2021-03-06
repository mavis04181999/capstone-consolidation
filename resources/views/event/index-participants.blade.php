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
                <i class="fa fa-users"></i>
                <span>Participants</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('show.participants', ['event' => $event->id]) }}">
                <i class="fa fa-user-plus"></i>
                <span>Add Participants</span>
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
                            <a class="dropdown-item" href="{{ route('view.archives') }}">
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
                        <h4 class="text-dark"><i class="fa fa-users mr-1"></i> {{$event->event_name}} Participants</h4>
                        <a href="{{ route('event.pdfparticipants', ['event' => $event->id]) }}" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mx-1"><i class="fa fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>
                    <hr>

                    <form action="{{ route('remove.participants') }}" method="post">
                        @csrf
                        @method('delete')
                        <table id="show-participants-table" class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>.</th>
                                    <th>Name</th>
                                    <th>Register</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($participants) > 0)
                                    @foreach ($participants as $participant)
                                    <tr>
                                        <td><input type="checkbox" name="participants[{{ $participant->id }}]" id="participant[{{ $participant->id }}]" class="check-participant"></td>
                                        <td>{{ $participant->user->lastname }} {{ $participant->user->firstname }}</td>
                                        <td>
                                            @if ($participant->is_register == 0)
                                            <small class="text-info">Pending</small>
                                            @else
                                            <small class="text-success">Confirm</small>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm text-danger" onclick="removeParticipant(event)"
                                            data-participant="{{ $participant }}"
                                            ><i class="fa fa-trash-o"></i> Remove
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else                                    
                                    <p class="alert alert-info">No Record Found</p>                                    
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-primary" onclick="checkParticipants(event)"><i class="fa fa-check-circle"></i> Check All</button>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Remove</button>
                    </form>


                </section>

                {{-- start: include modals --}}

                {{-- start: remove participant modal --}}
                <div id="remove-participant-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="remove-participant-modal-label">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header justify-content-between">
                                <h5 class="modal-title" id="remove-participant-modal-label">Remove Participant: <span id="remove-participant-name"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            
                            <form id="remove-participant-form" action="{{ route('remove.participant') }}" method="post">
                                @csrf
                                @method('delete')                                
                                <div class="modal-body">
                                    <input type="hidden" id="remove-participant-id" name="participant_id">
                                    <p>Are you sure?</p>
                                </div>
                                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger"><i class="fa fa-user-times"></i> Remove</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                {{-- end: remove participant modal --}}

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
        const showParticipantsTable = new DataTable('#show-participants-table', {
            sortable: true,
            fixedHeight: true,
        });

        function removeParticipant(event) {
            var participant = JSON.parse(event.target.dataset.participant);
            console.log(participant);

            var participant_id = document.querySelector('#remove-participant-modal #remove-participant-id');
            participant_id.value = participant.id;

            var name = document.querySelector('#remove-participant-modal #remove-participant-name');
            name.textContent = participant['user'].lastname+" "+participant['user'].firstname;

            $('#remove-participant-modal').modal({
                show: true,
                backdrop: "static",
                keyboard: false
            });
        }

        function checkParticipants(event) {
            var count = 0;
            
            const checkBoxes = document.querySelectorAll('#show-participants-table .check-participant');
            
            checkBoxes.forEach(element => {
                // check if there is a checkbox and count it 
                if(element.checked == true) {
                    count++;
                }
            });
            
            if (count == 0) {
                checkBoxes.forEach(element => {
                    element.checked = true;
                });
            }else {
                checkBoxes.forEach(element => {
                    element.checked = false;
                });
            }
        }
    </script>
@endsection