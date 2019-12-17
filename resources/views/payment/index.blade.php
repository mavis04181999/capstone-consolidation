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
                <small class="text-xs" style="font-size: 10px">Centralized Event Management System</small>
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

        <li class="nav-item">
            <a class="nav-link" href="{{ route('index.attendance', ['event' => $event->id]) }}">
                <i class="fa fa-calendar-check-o"></i>
                <span>Attendance</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa fa-calendar-minus-o"></i>
                <span>Event Profile</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="{{ route('index.participants', ['event' => $event->id]) }}">
                <i class="fa fa-users"></i> 
                <span>Participants</span>
            </a>
        </li>

        <li class="nav-item active">
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

            {{-- start: container fluid --}}
            <div class="container-fluid">

                @include('include.messages')

                <section>
                    <div class="row justify-content-between">
                        <h4 class="text-dark"><i class="fa fa-users mr-1"></i> {{$event->event_name}} Payment Logs</h4>
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
                                    <th>Receipt</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($payments) > 0)
                                @foreach ($payments as $payment)
                                <tr>
                                    <td><input type="checkbox" name="payments[{{$payment->id}}]" id="payments[{{$payment->id}}]" class="check-payments"></td>
                                    <td>{{ $payment->user->username }}</td>
                                    <td>{{ $payment->user->lastname }} {{ $payment->user->firstname }}</td>
                                    <td>{{ $payment->receipt }}</td>
                                    <td>{{ $payment->date }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm text-danger" onclick="removePayment(event)"
                                        data-payment="{{ $payment }}"
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
                        <button type="button" class="btn btn-sm btn-primary" onclick="checkPayments(event)"><i class="fa fa-check-circle"></i> Check All</button>
                        <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i> Delete</button>
                    </form>

                    <div class="row">
                        <div class="col-sm-12">
                            <form action="{{route('import.payment')}}" method="post" enctype="multipart/form-data">
                            @csrf
                                <input type="hidden" name="event_id" value="{{ $event->id }}">
                                <div class="form-content">
                                    <div class="form-body form-group-sm mb-3">
                                        <label for="import payment"></label>
                                        <input type="file" name="import_payment" id="import_payment" class="form-control-file">
                                    </div>
                                    <div class="form-footer form-group-sm">
                                        {{-- button: import users --}}
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload mr-1"></i> Import Payment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

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