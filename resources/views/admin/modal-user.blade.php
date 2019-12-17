{{-- start: create user modal --}}
<div id="create-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="create-user-modal-label">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="create-user-modal-label">Create User: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <small class="text-right mx-3 mt-3"><small class="alert-danger">*</small> required to save * required to complete</small>
            
            <form id="create-user-form" action="{{ route('store.user') }}" method="post">
                @csrf
                <div class="modal-body">
                    {{-- include modal form --}}
                    @include('admin.form-create-user')
                    <div class="row justify-content-center">
                        <div class="form-col-sm col-sm-4">                         
                            <label title="Department" for="department" class="col-form-label-sm">Department: <small>*</small></label>
                            <select name="department" id="create-user-department" class="form-control">
                                <option value="">Select Department</option>
                                @if (isset($departments))
                                @foreach ($departments as $department)
                                <option value="{{$department->id}}">{{$department->abbr}}</option>
                                @endforeach
                                @else
                                <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Course" for="Course" class="col-form-label-sm">Course: <small>*</small></label>
                            <select name="course" id="create-user-course" class="form-control">
                                <option value="">Select Course</option>
                                @if (count($courses) > 0)
                                @foreach ($courses as $course)
                                <option value="{{$course->id}}">{{$course->abbr}}</option>
                                @endforeach
                                @else
                                <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <div class="row">
                                <div class="col-sm-8">
                                    <label title="Section" for="Section" class="col-form-label-sm">Section: <small>*</small></label>
                                    <select name="section" id="create-user-section" class="form-control">
                                        <option value="">Select Section...</option>
                                        @if (count($sections) > 0)
                                        @foreach ($sections as $section)
                                        <option value="{{$section->id}}">{{$section->section}}</option>
                                        @endforeach
                                        @else
                                        <option value=""></option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label title="Year" for="year" class="col-form-label-sm">Year <small>*</small></label>
                                    <input type="number" name="year" id="create-user-year" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label title="Institution" for="Institution" class="col-form-label-sm">Institution <small class="alert-danger">*</small></label>
                            <input type="text" name="institution" id="create-user-institution" class="form-control">
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Username" for="username" class="col-form-label-sm">Username <small class="alert-danger">*</small></label>
                            <input type="text" name="username" id="create-user-username" class="form-control">
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Role" for="role" class="col-form-label-sm">Role: <small class="alert-danger">*</small></label>
                            <select name="role" id="create-user-role" class="form-control">
                                <option value="" disabled>Select Role</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: create user modal --}}

{{-- start: update user modal --}}
<div id="update-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="update-user-modal-label">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="update-user-modal-label"><i class="fa fa-user-circle"></i> Edit User: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <small class="text-right mx-3 mt-1"><small class="alert-danger">*</small> required to save * required to complete</small>
            
            <form id="update-user-form" action="{{ route('update.user') }}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <input type="hidden" id="update-user-user_id" name="user_id">
                    {{-- include modal form --}}
                    @include('admin.form-update-user')
                    <div class="row justify-content-center">
                        <div class="form-col-sm col-sm-4">                         
                            <label title="Department" for="department" class="col-form-label-sm">Department: <small>*</small></label>
                            <select name="department" id="update-user-department" class="form-control">
                                <option value="">Select Department</option>
                                @if (isset($departments))
                                @foreach ($departments as $department)
                                    <option value="{{$department->id}}">{{$department->abbr}}</option>
                                @endforeach
                                @else
                                    <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Course" for="Course" class="col-form-label-sm">Course: <small>*</small></label>
                            <select name="course" id="update-user-course" class="form-control">
                                <option value="">Select Course</option>
                                @if (count($courses) > 0)
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->abbr}}</option>
                                    @endforeach
                                @else
                                    <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <div class="row">
                                <div class="col-sm-8">
                                    <label title="Section" for="Section" class="col-form-label-sm">Section: <small>*</small></label>
                                    <select name="section" id="update-user-section" class="form-control">
                                        <option value="">Select Section...</option>
                                        @if (count($sections) > 0)
                                            @foreach ($sections as $section)
                                                <option value="{{$section->id}}">{{$section->section}}</option>
                                            @endforeach
                                        @else
                                            <option value=""></option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label title="Year" for="year" class="col-form-label-sm">Year <small>*</small></label>
                                    <input type="number" name="year" id="update-user-year" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label title="Institution" for="Institution" class="col-form-label-sm">Institution <small class="alert-danger">*</small></label>
                            <input type="text" name="institution" id="update-user-institution" class="form-control">
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Username" for="username" class="col-form-label-sm">Username <small class="alert-danger">*</small></label>
                            <input type="text" name="username" id="update-user-username" class="form-control" disabled>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Password" for="password" class="col-form-label-sm">Password <small>*</small></label>
                            <input type="password" name="password" id="update-user-password" class="form-control" autocomplete>
                        </div>
                    </div>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: update user modal --}}

{{-- start: delete user modal --}}
<div id="delete-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="delete-user-modal-label">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="delete-user-modal-label">Delete User: <span id="delete-user-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <form id="delete-user-form" action="{{ route('delete.user') }}" method="post">
                @csrf
                @method('delete')
                
                <div class="modal-body">
                    <input type="hidden" id="delete-user-user_id" name="user_id">
                    <p>Are you sure?</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: delete user modal --}}

{{-- ORGANIZER: --}}

{{-- start: create organizer modal --}}
<div id="create-organizer-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="create-organizer-modal-label">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="create-organizer-modal-label">Create Organizer: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <small class="text-right mx-3 mt-3"><small class="alert-danger">*</small> required to save * required to complete</small>
            
            <form id="create-organizer-form" action="{{ route('store.user') }}" method="post">
                @csrf
                <div class="modal-body">
                    {{-- include modal form --}}
                    @include('admin.form-create-organizer')
                    <div class="row justify-content-center">
                        <div class="form-col-sm col-sm-4">                         
                            <label title="Department" for="department" class="col-form-label-sm">Department: <small>*</small></label>
                            <select name="department" id="create-organizer-department" class="form-control">
                                <option value="">Select Department</option>
                                @if (isset($departments))
                                @foreach ($departments as $department)
                                <option value="{{$department->id}}">{{$department->abbr}}</option>
                                @endforeach
                                @else
                                <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Course" for="Course" class="col-form-label-sm">Course: <small>*</small></label>
                            <select name="course" id="create-organizer-course" class="form-control">
                                <option value="">Select Course</option>
                                @if (count($courses) > 0)
                                @foreach ($courses as $course)
                                <option value="{{$course->id}}">{{$course->abbr}}</option>
                                @endforeach
                                @else
                                <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <div class="row">
                                <div class="col-sm-8">
                                    <label title="Section" for="Section" class="col-form-label-sm">Section: <small>*</small></label>
                                    <select name="section" id="create-organizer-section" class="form-control">
                                        <option value="">Select Section...</option>
                                        @if (count($sections) > 0)
                                            @foreach ($sections as $section)
                                            <option value="{{$section->id}}">{{$section->section}}</option>
                                            @endforeach
                                            @else
                                            <option value=""></option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label title="Year" for="year" class="col-form-label-sm">Year <small>*</small></label>
                                    <input type="number" name="year" id="create-organizer-year" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label title="Institution" for="Institution" class="col-form-label-sm">Institution <small class="alert-danger">*</small></label>
                            <input type="text" name="institution" id="create-organizer-institution" class="form-control">
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Username" for="username" class="col-form-label-sm">Username <small class="alert-danger">*</small></label>
                            <input type="text" name="username" id="create-organizer-username" class="form-control">
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Role" for="role" class="col-form-label-sm">Role: <small class="alert-danger">*</small></label>
                            <select name="role" id="create-organizer-role" class="form-control">
                                <option value="" disabled>Select Role</option>
                                <option value="organizer">Organizer</option>
                            </select>
                        </div>
                    </div>
                    
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: create organizer modal --}}

{{-- start: update organizer modal --}}
<div id="update-organizer-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="update-organizer-modal-label">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="update-organizer-modal-label"><i class="fa fa-user-circle"></i> Edit Organizer: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <small class="text-right mx-3 mt-1"><small class="alert-danger">*</small> required to save * required to complete</small>
            
            <form id="update-organizer-form" action="{{ route('update.user') }}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <input type="hidden" id="update-organizer-user_id" name="user_id">
                    {{-- include modal form --}}
                    @include('admin.form-update-organizer')
                    <div class="row justify-content-center">
                        <div class="form-col-sm col-sm-4">                         
                            <label title="Department" for="department" class="col-form-label-sm">Department: <small>*</small></label>
                            <select name="department" id="update-organizer-department" class="form-control">
                                <option value="">Select Department</option>
                                @if (isset($departments))
                                @foreach ($departments as $department)
                                    <option value="{{$department->id}}">{{$department->abbr}}</option>
                                @endforeach
                                @else
                                    <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Course" for="Course" class="col-form-label-sm">Course: <small>*</small></label>
                            <select name="course" id="update-organizer-course" class="form-control">
                                <option value="">Select Course</option>
                                @if (count($courses) > 0)
                                    @foreach ($courses as $course)
                                        <option value="{{$course->id}}">{{$course->abbr}}</option>
                                    @endforeach
                                @else
                                    <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <div class="row">
                                <div class="col-sm-8">
                                    <label title="Section" for="Section" class="col-form-label-sm">Section: <small>*</small></label>
                                    <select name="section" id="update-organizer-section" class="form-control">
                                        <option value="">Select Section...</option>
                                        @if (count($sections) > 0)
                                            @foreach ($sections as $section)
                                                <option value="{{$section->id}}">{{$section->section}}</option>
                                            @endforeach
                                        @else
                                            <option value=""></option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <label title="Year" for="year" class="col-form-label-sm">Year <small>*</small></label>
                                    <input type="number" name="year" id="update-organizer-year" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group-sm col-sm-4">
                            <label title="Institution" for="Institution" class="col-form-label-sm">Institution <small class="alert-danger">*</small></label>
                            <input type="text" name="institution" id="update-organizer-institution" class="form-control">
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Username" for="username" class="col-form-label-sm">Username <small class="alert-danger">*</small></label>
                            <input type="text" name="username" id="update-organizer-username" class="form-control" disabled>
                        </div>
                        <div class="form-group-sm col-sm-4">
                            <label title="Password" for="password" class="col-form-label-sm">Password <small>*</small></label>
                            <input type="password" name="password" id="update-organizer-password" class="form-control" autocomplete>
                        </div>
                    </div>

                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: update user modal --}}

    