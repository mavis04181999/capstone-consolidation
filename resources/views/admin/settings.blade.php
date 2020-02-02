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
                
                <section id="admin-settings">
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row justify-content-between">
                                <h1 class="h4 mb-0 text-gray-900"><i class="fa fa-cogs"></i> Settings</h1>
                            </div>
                            <hr class="divider">
                            {{-- Department --}}
                            <form action="{{ route('store.department') }}" method="post" id="form-department">
                                @csrf
                                <div class="row">
                                    <div class="form-group-sm col-sm-6">                                        
                                        <input name="department" type="text" class="form-control" placeholder="Department">    
                                        <label for="Department" class="col-form-label-sm">Department</label>
                                    </div>

                                    <div class="form-group-sm col-sm-2">                                        
                                        <input name="department-abbr" type="text" class="form-control" placeholder="Abbr">    
                                        <label for="Department" class="col-form-label-sm">Department Abbr</label>
                                    </div>

                                    <div class="form-group-sm col-sm-4">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Department</button>
                                    </div>
                                </div>                                
                            </form>

                            <table id="departments-table" class="table table-condensed text-dark">
                                <thead>
                                    <tr>
                                        <th>Department</th>
                                        <th>Abbr</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if (isset($departments) && count($departments) > 0)
                                       @foreach ($departments as $department)
                                           <tr>
                                               <td>{{ $department->name ? $department->name : null }}</td>
                                               <td>{{ $department->abbr ? $department->abbr : null }}</td>
                                               <td>
                                                 <form action="{{ route('delete.department', ['department' => $department->id]) }}" method="post">
                                                     @csrf
                                                     @method('delete')                                                    
                                                    <button type="submit" class="btn btn-sm text-danger">
                                                        <i class="fa fa-trash-o"></i> Delete
                                                    </button>
                                                 </form>
                                               </td>
                                           </tr>
                                       @endforeach
                                    @else
                                        <p class="alert alert-info">no record available</p>
                                   @endif
                                </tbody>
                            </table>

                            <hr class="divider">
                            {{-- Course --}}
                            <form action="{{ route('store.course') }}" method="post" id="form-course">
                                @csrf
                                <div class="row">
                                    <div class="form-group-sm col-sm-4">                                        
                                        <input type="text" class="form-control" placeholder="Course" name="course">    
                                        <label for="Course" class="col-form-label-sm">Course</label>
                                    </div>
                                    <div class="form-group-sm col-sm-4">                                        
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" placeholder="Abbr" name="course-abbr">    
                                                <label for="Course" class="col-form-label-sm">Course Abbr</label>
                                            </div>
                                            <div class="col-sm-6">
                                                <select class="form-control" name="course-department" id="course-department">
                                                    <option value="" disabled>Select Department</option>
                                                    @if (isset($departments) && count($departments) > 0)
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->id }}">{{ $department->abbr }}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="">No Department Available</option>
                                                    @endif
                                                </select>
                                                <label for="Department" class="col-form-label-sm">Department</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Course</button>
                                    </div>
                                </div>                                
                            </form>

                            <table id="courses-table" class="table table-condensed text-dark">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Abbr</th>
                                        <th>Department</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if (isset($courses) && count($courses) > 0)
                                       @foreach ($courses as $course)
                                           <tr>
                                                <td>{{ $course->name ? $course->name : null }}</td>
                                                <td>{{ $course->abbr ? $course->abbr : null }}</td>
                                                <td>{{ $course->department ? $course->department->abbr : null }}</td>                                            
                                                <td>
                                                    <form action="{{ route('delete.course', ['course' => $course->id]) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm text-danger"><i class="fa fa-trash-o"></i> Delete</button>
                                                    </form>
                                               </td>
                                           </tr>
                                       @endforeach
                                    @else
                                        <p class="alert alert-info">no record found</p>
                                   @endif
                                </tbody>
                            </table>

                            <hr class="divider">
                            {{-- Section --}}
                            <form action="{{ route('store.section') }}" method="post" id="form-section">
                                @csrf
                                <div class="row">
                                    <div class="form-group-sm col-sm-4">                                        
                                        <input type="text" class="form-control" placeholder="Section" name="section">    
                                        <label for="Section" class="col-form-label-sm">Section</label>
                                    </div>
                                    <div class="form-group-sm col-sm-4">                                        
                                        <select class="form-control" name="course" id="section-course">
                                            <option value="" disabled>Select Course</option>
                                            @if (isset($courses) && count($courses) > 0)
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->abbr }}</option>
                                                @endforeach
                                            @else
                                                <option value="">No Course Available</option>
                                            @endif
                                        </select>
                                        <label for="Course" class="col-form-label-sm">Course</label>
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Add Section</button>
                                    </div>
                                </div>                                
                            </form>
                            <table id="sections-table" class="table table-condensed text-dark">
                                <thead>
                                    <tr>
                                        <th>Section</th>
                                        <th>Course</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   @if (isset($sections) && count($sections) > 0)
                                       @foreach ($sections as $section)
                                           <tr>
                                                <td>{{ $section->section ? $section->section : null }} - {{$section->id }}</td>
                                                <td>{{ $section->course ? $section->course->abbr : null }}</td>
                                                <td>
                                                    <form action="{{ route('delete.section', ['section' => $section->id]) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-sm text-danger">
                                                            <i class="fa fa-trash-o"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                           </tr>
                                       @endforeach
                                    @else
                                        <p class="alert alert-info">no record found</p>
                                   @endif
                                </tbody>
                            </table>

                        </div>
                    </div>

                </section>

                {{-- start: include modals --}}

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
        var departmentstable = new DataTable('#departments-table', {
        sortable: true,
        fixedHeight: true,
        });

        var coursestable = new DataTable('#courses-table', {
        sortable: true,
        fixedHeight: true,
        });

        var sectionstable = new DataTable('#sections-table', {
        sortable: true,
        fixedHeight: true,
        });
    </script>

    {{-- @include('admin.script-event') --}}

@endsection
