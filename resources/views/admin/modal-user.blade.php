{{-- start: create user modal --}}
<div id="create-user-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="create-user-modal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="create-user-modal-label">Create User: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <small class="text-right mx-3 mt-3"><small class="alert-danger">*</small> required to save * required to complete</small>

        <form id="create-user-form" action="{{ route('store.user') }}" method="post">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="form-group-sm col-sm-5 offset-1">
                        <label title="Username" for="username" class="col-form-label-sm">Username <small class="alert-danger">*</small></label>
                        <input type="text" name="username" id="create-username" class="form-control">
                    </div>
                    <div class="form-group-sm col-sm-5">
                        <label title="Role" for="role" class="col-form-label-sm">Role: <small class="alert-danger">*</small></label>
                        <select name="role" id="create-role" class="form-control">
                            <option value="" disabled>Select Role</option>
                            <option value="organizer">Organizer</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                </div>
                @include('admin.form-create-user')
                <div class="row">
                    <div class="form-group-sm col-sm-5 offset-1">
                        <div class="row">
                            <div class="col-sm-8">
                                <label title="Department" for="department" class="col-form-label-sm">Department: <small>*</small></label>
                                <select name="department" id="create-department" class="form-control">
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
                            <div class="col-sm-4">
                                <label title="Course" for="course" class="col-form-label-sm">Course <small>*</small></label>
                                <input type="text" name="course" id="create-course" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group-sm col-sm-5">
                        <div class="row">
                            <div class="col-sm-8">
                                <label title="Section" for="section" class="col-form-label-sm">Section <small>*</small></label>
                                <input type="text" name="section" id="create-section" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label title="Year" for="year" class="col-form-label-sm">Year <small>*</small></label>
                                <input type="text" name="year" id="create-year" class="form-control">
                            </div>
                        </div>
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
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="update-user-modal-label">Edit User: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

            <small class="text-right mx-3 mt-3"><small class="alert-danger">*</small> required to save * required to complete</small>

        <form id="update-user-form" action="{{ route('update.user') }}" method="post">
            @csrf
            @method('patch')
            <div class="modal-body">
                <input type="hidden" id="update-user_id" name="user_id">
                @include('admin.form-update-user')
                <div class="row">
                    <div class="form-group-sm col-sm-5 offset-1">
                        <div class="row">
                            <div class="col-sm-8">
                                <label title="Department" for="department" class="col-form-label-sm">Department: <small>*</small></label>
                                <select name="department" id="update-department" class="form-control">
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
                            <div class="col-sm-4">
                                <label title="Course" for="course" class="col-form-label-sm">Course <small>*</small></label>
                                <input type="text" name="course" id="update-course" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="form-group-sm col-sm-5">
                        <div class="row">
                            <div class="col-sm-8">
                                <label title="Section" for="section" class="col-form-label-sm">Section <small>*</small></label>
                                <input type="text" name="section" id="update-section" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <label title="Year" for="year" class="col-form-label-sm">Year <small>*</small></label>
                                <input type="text" name="year" id="update-year" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group-sm col-sm-5 offset-1">
                        <label title="Username" for="username" class="col-form-label-sm">Username <small class="alert-danger">*</small></label>
                        <input type="text" name="username" id="update-username" class="form-control" disabled>
                    </div>
                    <div class="form-group-sm col-sm-5 offset">
                        <label title="Password" for="password" class="col-form-label-sm">Password <small>*</small></label>
                        <input type="password" name="password" id="update-password" class="form-control" autocomplete>
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
                <h5 class="modal-title" id="delete-user-modal-label">Delete User: <span id="delete-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>

        <form id="delete-user-form" action="{{ route('delete.user') }}" method="post">
            @csrf
            @method('delete')

            <div class="modal-body">
                <input type="hidden" id="delete-user_id" name="user_id">
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