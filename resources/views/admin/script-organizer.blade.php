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
            email: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-email"
            ).value,
            title: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-title"
            ).value,
            firstname: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-firstname"
            ).value,
            
            middlename: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-middlename"
            ).value,
            lastname: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-lastname"
            ).value,
            nickname: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-nickname"
            ).value,
            
            certificate_name: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-certificate_name"
            ).value,
            contactno: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-contactno"
            ).value,
            address: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-address"
            ).value,
            
            
            occupation: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-occupation"
            ).value,
            sex: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-sex"
            ).value,
            birthday: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-birthday"
            ).value,
            
            department: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-department"
            ).value,
            course: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-course"
            ).value,
            section: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-section"
            ).value,
            year: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-year"
            ).value,
            
            institution: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-institution"
            ).value,
            username: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-username"
            ).value,
            role: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-organizer-role"
            ).value,
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

        const credential = JSON.parse(event.target.dataset.organizer);

        console.log(credential);

        var user_id = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-user_id');
        user_id.value = (credential.id);

        var email = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-email');
        email.value = (credential.email);
        var title = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-title');
        title.value = (credential.title);
        var firstname = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-firstname');
        firstname.value = (credential.firstname);

        var middlename = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-middlename');
        middlename.value = (credential.middlename);
        var lastname = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-lastname');
        lastname.value = (credential.lastname);
        var nickname = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-nickname');
        nickname.value = (credential.nickname);

        var certificate_name = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-certificate_name');
        certificate_name.value = (credential.certificate_name);
        var contactno = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-contactno');
        contactno.value = (credential.contactno);
        var address = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-address');
        address.value = (credential.address);

        var occupation = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-occupation');
        occupation.value = (credential.occupation);
        var sex = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-sex');
        sex.value = (credential.sex);
        var birthday = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-birthday');
        birthday.value = (credential.birthday);

        var department = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-department');
        department.value = (credential.department_id);
        var course = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-course');
        course.value = (credential.course_id);
        var section = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-section');
        section.value = (credential.section_id);
        var year = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-year');
        year.value = (credential.year);

        var institution = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-institution');
        institution.value = (credential.institution);
        var username = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-username');
        username.value = (credential.username);
        
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
            
            email: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-email"
            ).value,
            title: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-title"
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
            nickname: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-nickname"
            ).value,
            
            certificate_name: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-certificate_name"
            ).value,
            contactno: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-contactno"
            ).value,
            address: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-address"
            ).value,
            
            
            occupation: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-occupation"
            ).value,
            sex: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-sex"
            ).value,
            birthday: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-birthday"
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
            
            institution: document.querySelector(
            "#update-organizer-modal #update-organizer-form .modal-body #update-organizer-institution"
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
    function deleteOrganizer(event) {

        var organizer = JSON.parse(event.target.dataset.organizer);

        console.log(organizer);
        
        var user_id = document.querySelector('#delete-user-modal #delete-user-form .modal-body #delete-user-user_id');
        user_id.value = organizer.id;
        
        var name = document.querySelector('#delete-user-modal #delete-user-name');
        name.textContent = organizer.firstname+" "+organizer.lastname;
        
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