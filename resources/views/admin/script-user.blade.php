<script>
    // create user modal
    const createUserForm = document.querySelector(
    "#create-user-modal #create-user-form"
    );
    
    createUserForm.addEventListener("submit", event => {
        event.preventDefault();
        
        axios
        .post("{{ route('store.user') }}", {
            firstname: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-firstname"
            ).value,
            middlename: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-middlename"
            ).value,
            lastname: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-lastname"
            ).value,
            email: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-email"
            ).value,
            contactno: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-contactno"
            ).value,
            
            address: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-address"
            ).value,
            username: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-username"
            ).value,
            role: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-role"
            ).value,
            department: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-department"
            ).value,
            
            course: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-course"
            ).value,
            section: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-section"
            ).value,
            year: document.querySelector(
            "#create-user-modal #create-user-form .modal-body #create-year"
            ).value
        })
        .then(response => {
            console.log(response);
            window.location.href = "{{ route('admin.index')}}";
        })
        .catch(error => {
            console.log(error.response);

            const errors = error.response.data.errors;
            const firstError = Object.keys(errors)[0];
            console.log(firstError);    
            const firstErrorDom = document.querySelector('#create-user-modal #create-user-form .modal-body #create-'+firstError);
            const firstErrorMessage = errors[firstError][0];

            // scroll to the error message
            firstErrorDom.scrollIntoView();

            // remove all the error messages
            const errorMessages = document.querySelectorAll('#create-user-modal #create-user-form .modal-body .text-danger');
            errorMessages.forEach(element => element.textContent = '');

            // remove all the highlighted form
            const formControls = document.querySelectorAll('#create-user-modal #create-user-form .modal-body .form-control');
            formControls.forEach(element => element.classList.remove('border', 'border-danger'));

            // show the error messages
            firstErrorDom.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`);

            // highlight the form control with error
            firstErrorDom.classList.add('border', 'border-danger');
        });
    });

    function updateUser(event) {
        event.preventDefault();

        const user_id = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user_id');
        user_id.value = (event.target.dataset.user_id);

        const firstname = document.querySelector('#update-user-modal #update-user-form .modal-body #update-firstname');
        firstname.value = (event.target.dataset.firstname);

        const middlename = document.querySelector('#update-user-modal #update-user-form .modal-body #update-middlename');
        middlename.value = (event.target.dataset.middlename);

        const lastname = document.querySelector('#update-user-modal #update-user-form .modal-body #update-lastname');
        lastname.value = (event.target.dataset.lastname);

        const email = document.querySelector('#update-user-modal #update-user-form .modal-body #update-email');
        email.value = (event.target.dataset.email);

        const contactno = document.querySelector('#update-user-modal #update-user-form .modal-body #update-contactno');
        contactno.value = (event.target.dataset.contactno);

        const address = document.querySelector('#update-user-modal #update-user-form .modal-body #update-address');
        address.value = (event.target.dataset.address);

        const department = document.querySelector('#update-user-modal #update-user-form .modal-body #update-department');
        department.value = (event.target.dataset.department);

        const course = document.querySelector('#update-user-modal #update-user-form .modal-body #update-course');
        course.value = (event.target.dataset.course);

        const section = document.querySelector('#update-user-modal #update-user-form .modal-body #update-section');
        section.value = (event.target.dataset.section);

        const year = document.querySelector('#update-user-modal #update-user-form .modal-body #update-year');
        year.value = (event.target.dataset.year);

        const username = document.querySelector('#update-user-modal #update-user-form .modal-body #update-username');
        username.value = (event.target.dataset.username);

        $('#update-user-modal').modal({
            show: true,
            backdrop: "static",
            keyboard: false
        });
    }

    const updateUserForm = document.querySelector('#update-user-modal #update-user-form');

    updateUserForm.addEventListener('submit', event => {
        event.preventDefault();

        axios.patch("{{ route('update.user') }}", {
            user_id: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-user_id"
            ).value,
            firstname: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-firstname"
            ).value,
            middlename: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-middlename"
            ).value,
            lastname: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-lastname"
            ).value,
            email: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-email"
            ).value,

            contactno: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-contactno"
            ).value, 
            address: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-address"
            ).value,

            department: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-department"
            ).value,
            course: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-course"
            ).value,
            section: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-section"
            ).value,
            year: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-year"
            ).value,

            password: document.querySelector(
            "#update-user-modal #update-user-form .modal-body #update-password"
            ).value
        }).then(response => {
            console.log(response);
            window.location.href = "{{ route('admin.index') }}";
        }).catch(error => {
            console.log(error.response);

            const errors = error.response.data.errors;
            const firstError = Object.keys(errors)[0];
            console.log(firstError);    
            const firstErrorDom = document.querySelector('#update-user-modal #update-user-form .modal-body #update-'+firstError);
            const firstErrorMessage = errors[firstError][0];

            // scroll to the error message
            firstErrorDom.scrollIntoView();

            // remove all the error messages
            const errorMessages = document.querySelectorAll('#update-user-modal #update-user-form .modal-body .text-danger');
            errorMessages.forEach(element => element.textContent = '');

            // remove all the highlighted form
            const formControls = document.querySelectorAll('#update-user-modal #update-user-form .modal-body .form-control');
            formControls.forEach(element => element.classList.remove('border', 'border-danger'));

            // show the error messages
            firstErrorDom.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`);

            // highlight the form control with error
            firstErrorDom.classList.add('border', 'border-danger');
        });
    });
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

    function deleteUser(event) {

        var user_id = document.querySelector('#delete-user-modal #delete-user-form .modal-body #delete-user_id');
        user_id.value = event.target.dataset.user_id;

        var name = document.querySelector('#delete-user-modal #delete-name');
        name.textContent = event.target.dataset.name;

        $('#delete-user-modal').modal({
            show: true,
            backdrop: "static",
            keyboard: false
        });
    }
</script>