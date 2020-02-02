<script>

    const profileForm = document.querySelector('#form-update-profile')

    profileForm.addEventListener('submit', function(event) {
        event.preventDefault();

       axios.patch("{{ route('update.profile') }}" , {
        user_id: document.querySelector('#form-update-profile #edit-profile-user_id').value,
        
        email: document.querySelector('#form-update-profile #edit-profile-email').value,
        title: document.querySelector('#form-update-profile #edit-profile-title').value,
        firstname: document.querySelector('#form-update-profile #edit-profile-firstname').value,

        middlename: document.querySelector('#form-update-profile #edit-profile-middlename').value,
        lastname: document.querySelector('#form-update-profile #edit-profile-lastname').value,
        nickname: document.querySelector('#form-update-profile #edit-profile-nickname').value,


        certificate_name: document.querySelector('#form-update-profile #edit-profile-certificate_name').value,
        contactno: document.querySelector('#form-update-profile #edit-profile-contactno').value,
        address: document.querySelector('#form-update-profile #edit-profile-address').value,

        occupation: document.querySelector('#form-update-profile #edit-profile-occupation').value,

        birthday: document.querySelector('#form-update-profile #edit-profile-birthday').value,
        department: document.querySelector('#form-update-profile #edit-profile-department').value,
        course: document.querySelector('#form-update-profile #edit-profile-course').value,

        section: document.querySelector('#form-update-profile #edit-profile-section').value,
        year: document.querySelector('#form-update-profile #edit-profile-year').value,
        institution: document.querySelector('#form-update-profile #edit-profile-institution').value,

        password: document.querySelector('#form-update-profile #edit-profile-password').value,

       }).then( function(response) {
           console.log(response);
           window.location.href = "{{ route('user.index') }}";
       }).catch( function(error) {
            const errors = error.response.data.errors;
            const firstError = Object.keys(errors)[0];
            console.log('FIrst Error:',firstError);    
            const firstErrorDom = document.querySelector('#form-update-profile #edit-profile-'+firstError);
            const firstErrorMessage = errors[firstError][0];

            // scroll to the error message
            firstErrorDom.scrollIntoView();

            // remove all the error messages
            const errorMessages = document.querySelectorAll('#form-update-profile .text-danger');
            errorMessages.forEach(element => element.textContent = '');

            // remove all the highlighted form
            const formControls = document.querySelectorAll('#form-update-profile .form-control');
            formControls.forEach(element => element.classList.remove('border', 'border-danger'));

            // show the error messages
            firstErrorDom.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`);

            // highlight the form control with error
            firstErrorDom.classList.add('border', 'border-danger');
            })

    })

</script>