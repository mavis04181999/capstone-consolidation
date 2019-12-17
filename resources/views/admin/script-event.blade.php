<script>
    // allow_prereg script create-event-modal:
    function changePreReg0(event){
        var value = document.querySelector('#create-event-modal #create-event-form #create-event-allow_prereg').value;
        var slot = document.querySelector('#create-event-modal #create-event-form #create-event-prereg_slot');
        // if pre-registration is allow remove the disabled attr of pre-reg slot
        if (value == 1) {
            slot.disabled = false;
            // $('#create-event-modal #create-event-form #create-event-prereg_slot').attr('disabled', false);
        }else {
            slot.disabled = true;
        }
    }
    
    // create event modal:
    const createEventModal = document.querySelector('#create-event-modal #create-event-form');
    
    createEventModal.addEventListener('submit', event => {
        event.preventDefault();
        
        axios.post("{{ route('store.event') }}", {
            
            event_name: document.querySelector('#create-event-modal #create-event-form #create-event-event_name').value,
            organizer_id: document.querySelector('#create-event-modal #create-event-form #create-event-organizer_id').value,
            location: document.querySelector('#create-event-modal #create-event-form #create-event-location').value,
            event_type: document.querySelector('#create-event-modal #create-event-form #create-event-event_type').value,
            
            start_date: document.querySelector('#create-event-modal #create-event-form #create-event-start_date').value,
            end_date: document.querySelector('#create-event-modal #create-event-form #create-event-end_date').value,
            department_id: document.querySelector('#create-event-modal #create-event-form #create-event-department_id').value,
            max_participants: document.querySelector('#create-event-modal #create-event-form #create-event-max_participants').value,
            
            allow_prereg: document.querySelector('#create-event-modal #create-event-form #create-event-allow_prereg').value,
            prereg_slot: document.querySelector('#create-event-modal #create-event-form #create-event-prereg_slot').value,
            fee: document.querySelector('#create-event-modal #create-event-form #create-event-fee').value,
            event_overview: document.querySelector('#create-event-modal #create-event-form #create-event-event_overview').value,
            
        }).then(response => {
            console.log(response);
            window.location.href = "{{route('admin.index')}}";
        }).catch(error => {
            console.log(error.response);
            
            const errors = error.response.data.errors;
            const firstError = Object.keys(errors)[0];
            console.log(firstError);    
            const firstErrorDom = document.querySelector('#create-event-modal #create-event-form .modal-body #create-event-'+firstError);
            const firstErrorMessage = errors[firstError][0];
            
            // scroll to the error message
            firstErrorDom.scrollIntoView();
            
            // remove all the error messages
            const errorMessages = document.querySelectorAll('#create-event-modal #create-event-form .modal-body .text-danger');
            errorMessages.forEach(element => element.textContent = '');
            
            // remove all the highlighted form
            const formControls = document.querySelectorAll('#create-event-modal #create-event-form .modal-body .form-control');
            formControls.forEach(element => element.classList.remove('border', 'border-danger'));
            
            // show the error messages
            firstErrorDom.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`);
            
            // highlight the form control with error
            firstErrorDom.classList.add('border', 'border-danger');
        });
    });
    
    function changePreReg1(event){
        var value = document.querySelector('#update-event-modal #update-event-form #update-event-allow_prereg').value;
        var slot = document.querySelector('#update-event-modal #update-event-form #update-event-prereg_slot');
        // if pre-registration is allow remove the disabled attr of pre-reg slot
        if (value == 1) {
            slot.disabled = false;
            // $('#create-event-modal #create-event-form #create-event-prereg_slot').attr('disabled', false);
        }else {
            slot.disabled = true;
        }
    }
    
    function updateEvent(event) {
        
        event.preventDefault();

        var credential = JSON.parse(event.target.dataset.event);
        
        const event_id = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-event_id');
        event_id.value = (credential.id);
        
        const event_name = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-event_name');
        event_name.value = (credential.event_name);
        const organizer_id = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-organizer_id');
        organizer_id.value = (credential.organizer_id);
        const location = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-location');
        location.value = (credential.location);
        const event_type = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-event_type');
        event_type.value = (credential.event_type);
        
        const start_date = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-start_date');
        start_date.value = (credential.start_date);
        const end_date = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-end_date');
        end_date.value = (credential.end_date);
        const department_id = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-department_id');
        department_id.value = (credential.department_id);
        const max_participants = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-max_participants');
        max_participants.value = (credential.max_participants);
        
        const allow_prereg = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-allow_prereg');
        allow_prereg.value = (credential.allow_prereg);
        const prereg_slot = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-prereg_slot');
        prereg_slot.value = (credential.prereg_slot);
        const fee = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-fee');
        fee.value = (credential.fee);
        const event_overview = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-event_overview');
        event_overview.value = (credential.event_overview);
        
        
        const status = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-status');
        status.value = (credential.status);
        
        var value = document.querySelector('#update-event-modal #update-event-form #update-event-allow_prereg').value;
        var slot = document.querySelector('#update-event-modal #update-event-form #update-event-prereg_slot');
        // if pre-registration is allow remove the disabled attr of pre-reg slot
        if (value == 1) {
            slot.disabled = false;
            // $('#create-event-modal #create-event-form #create-event-prereg_slot').attr('disabled', false);
        }else {
            slot.disabled = true;
        }
        
        $('#update-event-modal').modal({
            show: true,
            backdrop: "static",
            keyboard: false
        });
    }
    
    const updateEventForm = document.querySelector('#update-event-modal #update-event-form');
    
    updateEventForm.addEventListener('submit', event => {
        event.preventDefault();
        
        axios.patch("{{ route('update.event') }}", {
            event_id : document.querySelector('#update-event-modal #update-event-form .modal-body #update-event-event_id').value,
            
            event_name: document.querySelector('#update-event-modal #update-event-form #update-event-event_name').value,
            organizer_id: document.querySelector('#update-event-modal #update-event-form #update-event-organizer_id').value,
            location: document.querySelector('#update-event-modal #update-event-form #update-event-location').value,
            event_type: document.querySelector('#update-event-modal #update-event-form #update-event-event_type').value,
            
            start_date: document.querySelector('#update-event-modal #update-event-form #update-event-start_date').value,
            end_date: document.querySelector('#update-event-modal #update-event-form #update-event-end_date').value,
            department_id: document.querySelector('#update-event-modal #update-event-form #update-event-department_id').value,
            max_participants: document.querySelector('#update-event-modal #update-event-form #update-event-max_participants').value,
            
            allow_prereg: document.querySelector('#update-event-modal #update-event-form #update-event-allow_prereg').value,
            prereg_slot: document.querySelector('#update-event-modal #update-event-form #update-event-prereg_slot').value,
            fee: document.querySelector('#update-event-modal #update-event-form #update-event-fee').value,
            event_overview: document.querySelector('#update-event-modal #update-event-form #update-event-event_overview').value,
            
            status: document.querySelector('#update-event-modal #update-event-form #update-event-status').value,
        }).then(response => {
            console.log(response);
            window.location.href = "{{ route('admin.index') }}";
        }).catch(error => {
            console.log(error.response);
            
            const errors = error.response.data.errors;
            const firstError = Object.keys(errors)[0];
            console.log(firstError);    
            const firstErrorDom = document.querySelector('#update-event-modal #update-event-form .modal-body #update-event'+firstError);
            const firstErrorMessage = errors[firstError][0];
            
            // scroll to the error message
            firstErrorDom.scrollIntoView();
            
            // remove all the error messages
            const errorMessages = document.querySelectorAll('#update-event-modal #update-event-form .modal-body .text-danger');
            errorMessages.forEach(element => element.textContent = '');
            
            // remove all the highlighted form
            const formControls = document.querySelectorAll('#update-event-modal #update-event-form .modal-body .form-control');
            formControls.forEach(element => element.classList.remove('border', 'border-danger'));
            
            // show the error messages
            firstErrorDom.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`);
            
            // highlight the form control with error
            firstErrorDom.classList.add('border', 'border-danger');
        });
    });
    
    function deleteEvent(event) {
        var credential = JSON.parse(event.target.dataset.event);

        var event_id = document.querySelector('#delete-event-modal #delete-event-form .modal-body #delete-event-event_id');
        event_id.value = credential.id;
        
        var name = document.querySelector('#delete-event-modal #delete-event-name');
        name.textContent = credential.event_name;
        
        $('#delete-event-modal').modal({
            show: true,
            backdrop: "static",
            keyboard: false
        });
    }

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