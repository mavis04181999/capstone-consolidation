{{-- start: create event modal --}}
<div id="create-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="create-event-modal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="create-event-modal-label">Create Event: </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <small class="text-right mx-3 mt-3"><small class="alert-danger">*</small> required to save * required to complete</small>
            
            <form id="create-event-form" action="{{ route('store.event') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group-sm col-sm-5 offset-1">
                            <label title="Event Name" for="event_name" class="col-form-label-sm">Event Name <small class="alert-danger">*</small></label>
                            <input type="text" name="event_name" id="create-event-event_name" class="form-control">
                        </div>
                        <div class="form-group-sm col-sm-5">
                            <label title="Role" for="role" class="col-form-label-sm">Organizer: <small class="alert-danger">*</small></label>
                            <select name="organizer_id" id="create-event-organizer_id" class="form-control">
                                <option value="" disabled>Select Organizer</option>
                                @if (isset($organizers))
                                @foreach ($organizers as $organizer)
                                <option value="{{$organizer->id}}">{{ $organizer->firstname ? $organizer->lastname.", ".$organizer->firstname : $organizer->username }}</option>
                                @endforeach
                                @else
                                <option value=""></option>
                                @endif
                            </select>
                        </div>
                    </div>
                    @include('admin.form-create-event')
                    <div class="row">
                        <div class="form-group-sm col-sm-5 offset-1">
                            <label title="Department" for="department" class="col-form-label-sm">Department: <small>*</small></label>
                            <select name="department_id" id="create-event-department_id" class="form-control">
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
                        <div class="col-sm-5">
                            <label title="Maximum Participants" for="max_participants" class="col-form-label-sm">Maximum Participants <small>*</small></label>
                            <input type="number" name="max_participants" id="create-event-max_participants" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group-sm col-sm-5 offset-1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label title="Allow Pre-Registration" for="allow_prereg" class="col-form-label-sm">Pre-Registration: <small>*</small></label>
                                    <select name="allow_prereg" id="create-event-allow_prereg" class="form-control" onchange="changePreReg0(event)">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label title="Pre-Registration Slot" for="prereg_slot" class="col-form-label-sm">Slot: <small>*</small></label>
                                    <input type="number" name="prereg_slot" id="create-event-prereg_slot" class="form-control" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group-sm col-sm-10 offset-1">
                            
                            <label title="Event Overview" for="event_overview" class="col form-label-sm">Event Overview <small class="alert-danger">*</small></label>
                            <textarea name="event_overview" id="create-event-event_overview" cols="5" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: create event modal --}}

{{-- start: update event modal --}}
<div id="update-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="update-event-modal-label">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="update-event-modal-label">Update Event: </h5>
                <button type="button" class="close" data-d  ismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <small class="text-right mx-3 mt-3"><small class="alert-danger">*</small> required to save * required to complete</small>
            
            <form id="update-event-form" action="{{ route('update.event') }}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <input type="hidden" id="update-event-event_id" name="event_id">
                    <div class="row">
                        <div class="form-group-sm col-sm-5 offset-1">
                            <label title="Event Name" for="event_name" class="col-form-label-sm">Event Name <small class="alert-danger">*</small></label>
                            <input type="text" name="event_name" id="update-event-event_name" class="form-control">
                        </div>
                        <div class="form-group-sm col-sm-5">
                            <label title="Role" for="role" class="col-form-label-sm">Organizer: <small class="alert-danger">*</small></label>
                            <select name="organizer_id" id="update-event-organizer_id" class="form-control">
                                <option value="" disabled>Select Organizer</option>
                                @if (isset($organizers))
                                @foreach ($organizers as $organizer)
                                {{-- if organizer is null use his / her username --}}
                                <option value="{{$organizer->id}}">{{ $organizer->firstname ? $organizer->lastname.", ".$organizer->firstname : $organizer->username }}</option>
                                @endforeach
                                @else
                                <option value=""></option>
                                @endif
                            </select>
                        </div>
                    </div>
                    @include('admin.form-update-event')
                    <div class="row">
                        <div class="form-group-sm col-sm-5 offset-1">
                            <label title="Department" for="department" class="col-form-label-sm">Department: <small>*</small></label>
                            <select name="department_id" id="update-event-department_id" class="form-control">
                                <option value="" disabled>Select Department</option>
                                @if (isset($departments))
                                    @foreach ($departments as $department)
                                        <option value="{{$department->id}}">{{$department->abbr}}</option>
                                    @endforeach
                                @else
                                    <option value=""></option>
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <label title="Maximum Participants" for="max_participants" class="col-form-label-sm">Maximum Participants <small>*</small></label>
                            <input type="number" name="max_participants" id="update-event-max_participants" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group-sm col-sm-5 offset-1">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label title="Allow Pre-Registration" for="allow_prereg" class="col-form-label-sm">Pre-Registration: <small>*</small></label>
                                    <select name="allow_prereg" id="update-event-allow_prereg" class="form-control" onchange="changePreReg1(event)">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label title="Pre-Registration Slot" for="prereg_slot" class="col-form-label-sm">Slot: <small>*</small></label>
                                    <input type="number" name="prereg_slot" id="update-event-prereg_slot" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label title="Status" for="status" class="col-form-label-sm">Status <small>*</small></label>
                                    <select name="status" id="update-event-status" class="form-control">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group-sm col-sm-10 offset-1">
                            <label title="Event Overview" for="event_overview" class="col-form-label-sm">Event Overview <small class="alert-danger">*</small></label>
                            <textarea name="event_overview" id="update-event-event_overview" cols="5" rows="5" class="form-control"></textarea>
                        </div>
                        
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: update event modal --}}

{{-- start: delete event modal --}}
<div id="delete-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="delete-event-modal-label">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="delete-event-modal-label">Delete Event: <span id="delete-event-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <form id="delete-event-form" action="{{ route('delete.event') }}" method="post">
                @csrf
                @method('delete')
                
                <div class="modal-body">
                    <input type="hidden" id="delete-event-event_id" name="event_id">
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
{{-- end: delete event modal --}}


{{-- start: archive event modal --}}
<div id="archive-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="archive-event-modal-label">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="archive-event-modal-label">Archive Event: <span id="archive-event-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <form id="archive-event-form" action="{{ route('archive.event') }}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <input type="hidden" id="archive-event-event_id" name="event_id">
                    <p>Are you sure?</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Archive</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: archive event modal --}}


{{-- start: unarchive event modal --}}
<div id="unarchive-event-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="unarchive-event-modal-label">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            
            <div class="modal-header justify-content-between">
                <h5 class="modal-title" id="unarchive-event-modal-label">Unarchive Event: <span id="unarchive-event-name"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            
            <form id="unarchive-event-form" action="{{ route('unarchive.event') }}" method="post">
                @csrf
                @method('patch')
                <div class="modal-body">
                    <input type="hidden" id="unarchive-event-event_id" name="event_id">
                    <p>Are you sure?</p>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Unarchive</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end: archive event modal --}}

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
                    
                    @foreach ($features as $feature)

                    <div class="form-group-sm offset-1">
                        <input type="checkbox" class="event-feature-{{ $feature->id }}" name="feature[{{$feature->id}}]" id="event-feature[{{$feature->id}}]">
                        <label title="{{$feature->name}}" for="{{$feature->name}}" class="col-form-label">{{$feature->name}}</label>
                    </div>

                    @endforeach
                    
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

