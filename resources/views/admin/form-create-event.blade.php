<div class="row">
    <div class="form-group-sm col-sm-5 offset-1">
        <label title="Location" for="location" class="col-form-label-sm">Location <small>*</small></label>
        <input type="text" name="location" id="create-event-location" class="form-control">
    </div>
    <div class="form-group-sm col-sm-5">
        <label title="Event Type" for="event-type" class="col-form-label-sm">Event-type <small class="alert-danger">*</small></label>
        <select name="event_type" id="create-event-event_type" class="form-control">
            <option value="">Select Event Type</option>
            <option value="0">Exclusive</option>
            <option value="1">Open</option>
        </select>
    </div>
</div>
<div class="row">
    <div class="form-group-sm col-sm-5 offset-1">
        <label title="Event: Start Date" for="start-date" class="col-form-label-sm">Start Date <small class="alert-danger">*</small></label>
        <input type="date" name="start_date" id="create-event-start_date" class="form-control">
    </div>
    <div class="form-group-sm col-sm-5">
        <label title="Event: End Date" for="end-date" class="col-form-label-sm">End Date <small class="alert-danger">*</small></label>
        <input type="date" name="end_date" id="create-event-end_date" class="form-control">
    </div>
</div>