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
        <li class="nav-item">
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
        <li class="nav-item active">
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

                {{-- organizers table --}}
                <section id="organizer-dashboard">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row justify-content-between">
                                <h1 class="h4 mb-0 text-gray-900"><i class="fa fa-users mr-1"></i> Organizer Dashboard</h1>
                                <button type="button" class="btn btn-primary" data-target="#create-organizer-modal" data-toggle="modal"><i class="fa fa-plus"></i> Create Organizer</button>
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
                                @if (count($organizers) > 0)
                                    @foreach ($organizers as $organizer)
                                    <tr>
                                        <td><input type="checkbox" class="check-organizer" name="user[{{$organizer->id}}]" id="user[{{$organizer->id}}]"></td>
                                        <td>{{$organizer->firstname }}</td>
                                        <td>{{$organizer->lastname }}</td>
                                        <td>{{$organizer->email }}</td>
                                        <td>{{$organizer->username }}</td>
                                        <td>{{$organizer->temppassword}}</td>
                                        <td>
                                            <button onclick="updateOrganizer(event)" type="button" class="btn btn-sm btn-info"
                                            data-user_id="{{$organizer->user_id}}"
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
                            <button type="button" class="btn btn-sm btn-primary check-organizer" onclick="checksOrganizers(event)"><i class="fa fa-check-circle"></i> Check all</button>
                            <button type="submit" class="btn btn-sm btn-danger ml-1 delete-organizer"><i class="fa fa-trash-o"></i> Delete</button>
                        </form>
                        </div>
                    </div>
                </section>
                <hr class="divider">

                {{-- start: include modals --}}

                @include('admin.modal-user')

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

    @include('admin.script-organizer')

    @include('admin.script-delete')

@endsection






<script>

    // ORGANIZER:

    var organizertable = new DataTable('#organizer-table', {
        sortable: true,
        fixedHeight: true,
    });
    
    // start: create organizer submit
    var createOrganizerForm = document.querySelector(
    "#create-organizer-modal #create-organizer-form"
    );
    
    createOrganizerForm.addEventListener("submit", event => {
        event.preventDefault();
        
        axios
        .post("{{ route('store.user') }}", {
            firstname: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-firstname"
            ).value,
            middlename: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-middlename"
            ).value,
            lastname: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-lastname"
            ).value,
            email: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-email"
            ).value,
            contactno: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-contactno"
            ).value,
            
            address: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-address"
            ).value,
            username: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-username"
            ).value,
            role: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-role"
            ).value,
            department: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-department"
            ).value,
            
            course: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-course"
            ).value,
            section: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-section"
            ).value,
            year: document.querySelector(
            "#create-organizer-modal #create-organizer-form .modal-body #create-organizer-year"
            ).value
        })
        .then(response => {
            console.log(response);
            window.location.href = "{{ route('admin.organizer')}}";
        })
        .catch(error => {
            console.log(error.response);
            
            var errors = error.response.data.errors;
            var firstError = Object.keys(errors)[0];
            console.log(firstError);    
            var firstErrorDom = document.querySelector('#create-organizer-modal #create-organizer-form .modal-body #create-organizer-'+firstError);
            var firstErrorMessage = errors[firstError][0];
            
            // scroll to the error message
            firstErrorDom.scrollIntoView();
            
            // remove all the error messages
            var errorMessages = document.querySelectorAll('#create-organizer-modal #create-organizer-form .modal-body .text-danger');
            errorMessages.forEach(element => element.textContent = '');
            
            // remove all the highlighted form
            var formControls = document.querySelectorAll('#create-organizer-modal #create-organizer-form .modal-body .form-control');
            formControls.forEach(element => element.classList.remove('border', 'border-danger'));
            
            // show the error messages
            firstErrorDom.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`);
            
            // highlight the form control with error
            firstErrorDom.classList.add('border', 'border-danger');
        });
    });
    // end: create organizer submit
    
    
    // start: update organizer modal
    function updateOrganizer(event) {
        event.preventDefault();

        // var organizer = JSON.parse(event.target.dataset.user_id);

        // console.log(organizer.address);
        
        var user_id = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-user_id');
        user_id.value = (event.target.dataset.user_id);
        
        var firstname = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-firstname');
        firstname.value = (event.target.dataset.firstname);
        
        var middlename = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-middlename');
        middlename.value = (event.target.dataset.middlename);
        
        var lastname = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-lastname');
        lastname.value = (event.target.dataset.lastname);
        
        var email = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-email');
        email.value = (event.target.dataset.email);
        
        var contactno = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-contactno');
        contactno.value = (event.target.dataset.contactno);
        
        var address = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-address');
        address.value = (event.target.dataset.address);
        
        var department = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-department');
        department.value = (event.target.dataset.department);
        
        var course = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-course');
        course.value = (event.target.dataset.course);
        
        var section = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-section');
        section.value = (event.target.dataset.section);
        
        var year = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-year');
        year.value = (event.target.dataset.year);
        
        var username = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-username');
        username.value = (event.target.dataset.username);
        
        $('#update-organizer-modal').modal({
            show: true,
            backdrop: "static",
            keyboard: false
        });
    }
    // end: update organizer modal
    
    // start: update organizer submit
    var updateOrganizerForm = document.querySelector('#update-organizer-modal #update-organizer-form');
    
    updateOrganizerForm.addEventListener('submit', event => {
        event.preventDefault();
        
        axios.patch("{{ route('update.user') }}", {
            user_id: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-user_id"
            ).value,
            firstname: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-firstname"
            ).value,
            middlename: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-middlename"
            ).value,
            lastname: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-lastname"
            ).value,
            email: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-email"
            ).value,
            
            contactno: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-contactno"
            ).value, 
            address: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-address"
            ).value,
            
            department: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-department"
            ).value,
            course: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-course"
            ).value,
            section: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-section"
            ).value,
            year: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-year"
            ).value,
            
            password: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-password"
            ).value
        }).then(response => {
            console.log(response);
            window.location.href = "{{ route('admin.organizer') }}";
        }).catch(error => {
            console.log(error.response);
            
            var errors = error.response.data.errors;
            var firstError = Object.keys(errors)[0];
            console.log(firstError);    
            var firstErrorDom = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-'+firstError);
            var firstErrorMessage = errors[firstError][0];
            
            // scroll to the error message
            firstErrorDom.scrollIntoView();
            
            // remove all the error messages
            var errorMessages = document.querySelectorAll('#update-organizer-modal #update-organizer-form .modal-body .text-danger');
            errorMessages.forEach(element => element.textContent = '');
            
            // remove all the highlighted form
            var formControls = document.querySelectorAll('#update-organizer-modal #update-organizer-form .modal-body .form-control');
            formControls.forEach(element => element.classList.remove('border', 'border-danger'));
            
            // show the error messages
            firstErrorDom.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`);
            
            // highlight the form control with error
            firstErrorDom.classList.add('border', 'border-danger');
        });
    });
    // end: update user submit

        
    // start: delete user modal
    function deleteUser(event) {
        
        var user_id = document.querySelector('#delete-user-modal #delete-user-form .modal-body #delete-user-user_id');
        user_id.value = event.target.dataset.user_id;
        
        var name = document.querySelector('#delete-user-modal #delete-user-name');
        name.textContent = event.target.dataset.name;
        
        $('#delete-user-modal').modal({
            show: true,
            backdrop: "static",
            keyboard: false
        });
    }
    // end: delete user modal
    
    // remove all the unwanted changes and remove all the error messages once the modal close
    var closeButtons = document.querySelectorAll('.modal-footer .close-modal');
    closeButtons.forEach(element => {
        element.addEventListener('click', (event) => {
            // remove all the error messages once the modal close
            const errorMessages = document.querySelectorAll('.text-danger');
            errorMessages.forEach(element => element.textContent = '');
            
            // remove all the highlighted form controls once the modal close
            const formControls = document.querySelectorAll('.form-control');
            formControls.forEach(element => element.classList.remove('border', 'border-danger'));
        });
    });

</script>



