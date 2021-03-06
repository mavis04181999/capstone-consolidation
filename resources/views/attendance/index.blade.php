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
            <a class="nav-link" href="{{ route('manage.event', ['event' => $event]) }}">
                <i class="fa fa-home"></i>
                <span>Main Dashboard</span>
            </a>
        </li>

        <li class="nav-item active">
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
                        <h4 class="text-dark"><i class="fa fa-users mr-1"></i> {{$event->event_name}}: Attendance</h4>
                        <a href="" target="_blank" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mx-1"><i class="fa fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <hr>

                    <form action="{{ route('delete.payments') }}" method="post">
                        @csrf
                        @method('delete')
                        <table id="payment-logs-table" class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>.</th>
                                    <th>Username</th>
                                    <th>Name</th>
                                    <th>Date and Time</th>
                                    <th>Institution</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($attends) > 0)
                                    @foreach ($attends as $attend)
                                        <tr>
                                            <td><input type="checkbox" name="" id=""></td>
                                            <td>{{ $attend->user->username }}</td>
                                            <td>{{ $attend->user->lastname }} {{ $attend->user->firstname }}</td>
                                            <td>{{ $attend->date_attendance }}</td>
                                            <td>{{ $attend->user->institution }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p class="alert alert-info">No Record Found</p>
                                @endif
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-sm btn-primary" onclick="checkPayments(event)"><i class="fa fa-check-circle"></i> Check All</button>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
                    </form>

                </section>

                {{-- start: include modals --}}

                {{-- start: delete event modal --}}
                <div id="remove-payment-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="remove-payment-modal-label">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            
                            <div class="modal-header justify-content-between">
                                <h5 class="modal-title" id="remove-payment-modal-label">Remove Payment: <span id="remove-payment-name"></span></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            
                            <form id="remove-participant-form" action="{{ route('delete.payment') }}" method="post">
                                @csrf
                                @method('delete')                                
                                <div class="modal-body">
                                    <input type="hidden" id="remove-payment-id" name="payment_id">
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
                {{-- end: delete event modal --}}

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

        const paymentLogsTable = new DataTable('#payment-logs-table', {
            sortable: true,
            fixedHeight: true,
        });

        function removePayment(event) {
            var payment = JSON.parse(event.target.dataset.payment);
            console.log(payment);

            var payment_id = document.querySelector('#remove-payment-modal #remove-payment-id');
            payment_id.value = payment.id;

            var name = document.querySelector('#remove-payment-modal #remove-payment-name');
            name.textContent = payment['user'].lastname+" "+payment['user'].firstname;

            $('#remove-payment-modal').modal({
                show: true,
                backdrop: "static",
                keyboard: false
            });
        }

        function checkPayments(event) {
            var count = 0;
            
            const checkBoxes = document.querySelectorAll('#payment-logs-table .check-payments');
            
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