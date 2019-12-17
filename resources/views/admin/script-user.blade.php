<script>
    // USER:

    // start: create user submit
    const createUserForm = document.querySelector(
        "#create-user-modal #create-user-form"
    );

    createUserForm.addEventListener("submit", event => {
        event.preventDefault();
    
    axios
    .post("{{ route('store.user') }}", {
        email: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-email"
        ).value,
        title: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-title"
        ).value,
        firstname: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-firstname"
        ).value,

        middlename: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-middlename"
        ).value,
        lastname: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-lastname"
        ).value,
        nickname: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-nickname"
        ).value,

        certificate_name: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-certificate_name"
        ).value,
        contactno: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-contactno"
        ).value,
        address: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-address"
        ).value,


        occupation: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-occupation"
        ).value,
        sex: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-sex"
        ).value,
        birthday: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-birthday"
        ).value,

        department: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-department"
        ).value,
        course: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-course"
        ).value,
        section: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-section"
        ).value,
        year: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-year"
        ).value,

        institution: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-institution"
        ).value,
        username: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-username"
        ).value,
        role: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-role"
        ).value,
    })
    .then(response => {
        console.log(response);
        window.location.href = "{{ route('admin.user')}}";
    })
    .catch(error => {
        console.log(error.response);
        
        const errors = error.response.data.errors;
        const firstError = Object.keys(errors)[0];
        console.log(firstError);    
        const firstErrorDom = document.querySelector('#create-user-modal #create-user-form .modal-body #create-user-'+firstError);
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
// end: create user submit

// start: create user submit function

// function createUser(event) {
//     event.preventDefault();
    
//     axios
//     .post("{{ route('store.user') }}", {
//         firstname: document.querySelector("#create-user-modal #create-user-form .modal-body #create-user-firstname"
//         ).value,
//         middlename: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-middlename"
//         ).value,
//         lastname: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-lastname"
//         ).value,
//         email: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-email"
//         ).value,
//         contactno: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-contactno"
//         ).value,
        
//         address: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-address"
//         ).value,
//         username: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-username"
//         ).value,
//         role: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-role"
//         ).value,
//         department: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-department"
//         ).value,
        
//         course: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-course"
//         ).value,
//         section: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-section"
//         ).value,
//         year: document.querySelector(
//         "#create-user-modal #create-user-form .modal-body #create-user-year"
//         ).value
//     })
//     .then(response => {
//         console.log(response);
//         window.location.href = "{{ route('admin.user')}}";
//     })
//     .catch(error => {
//         console.log(error.response);
        
//         const errors = error.response.data.errors;
//         const firstError = Object.keys(errors)[0];
//         console.log(firstError);    
//         const firstErrorDom = document.querySelector('#create-user-modal #create-user-form .modal-body #create-user-'+firstError);
//         const firstErrorMessage = errors[firstError][0];
        
//         // scroll to the error message
//         firstErrorDom.scrollIntoView();
        
//         // remove all the error messages
//         const errorMessages = document.querySelectorAll('#create-user-modal #create-user-form .modal-body .text-danger');
//         errorMessages.forEach(element => element.textContent = '');
        
//         // remove all the highlighted form
//         const formControls = document.querySelectorAll('#create-user-modal #create-user-form .modal-body .form-control');
//         formControls.forEach(element => element.classList.remove('border', 'border-danger'));
        
//         // show the error messages
//         firstErrorDom.insertAdjacentHTML('afterend', `<div class="text-danger">${firstErrorMessage}</div>`);
        
//         // highlight the form control with error
//         firstErrorDom.classList.add('border', 'border-danger');
//     });
// }
// end: create user submit function

// start: update user modal
function updateUser(event) {
    event.preventDefault();

    const credential = JSON.parse(event.target.dataset.user);

    console.log(credential);
    
    var user_id = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-user_id');
    user_id.value = (credential.id);

    var email = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-email');
    email.value = (credential.email);
    var title = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-title');
    title.value = (credential.title);
    var firstname = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-firstname');
    firstname.value = (credential.firstname);

    var middlename = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-middlename');
    middlename.value = (credential.middlename);
    var lastname = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-lastname');
    lastname.value = (credential.lastname);
    var nickname = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-nickname');
    nickname.value = (credential.nickname);

    var certificate_name = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-certificate_name');
    certificate_name.value = (credential.certificate_name);
    var contactno = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-contactno');
    contactno.value = (credential.contactno);
    var address = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-address');
    address.value = (credential.address);

    var occupation = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-occupation');
    occupation.value = (credential.occupation);
    var sex = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-sex');
    sex.value = (credential.sex);
    var birthday = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-birthday');
    birthday.value = (credential.birthday);

    var department = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-department');
    department.value = (credential.department_id);
    var course = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-course');
    course.value = (credential.course_id);
    var section = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-section');
    section.value = (credential.section_id);
    var year = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-year');
    year.value = (credential.year);

    var institution = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-institution');
    institution.value = (credential.institution);
    var username = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-username');
    username.value = (credential.username);
    
    $('#update-user-modal').modal({
        show: true,
        backdrop: "static",
        keyboard: false
    });
}
// end: update user modal

// start: update user submit
var updateUserForm = document.querySelector('#update-user-modal #update-user-form');

updateUserForm.addEventListener('submit', event => {
    event.preventDefault();
    
    axios.patch("{{ route('update.user') }}", {
        user_id: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-user_id"
        ).value,

        email: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-email"
        ).value,
        title: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-title"
        ).value,
        firstname: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-firstname"
        ).value,

        middlename: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-middlename"
        ).value,
        lastname: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-lastname"
        ).value,
        nickname: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-nickname"
        ).value,

        certificate_name: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-certificate_name"
        ).value,
        contactno: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-contactno"
        ).value,
        address: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-address"
        ).value,


        occupation: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-occupation"
        ).value,
        sex: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-sex"
        ).value,
        birthday: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-birthday"
        ).value,

        department: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-department"
        ).value,
        course: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-course"
        ).value,
        section: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-section"
        ).value,
        year: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-year"
        ).value,

        institution: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-institution"
        ).value,
        password: document.querySelector(
        "#update-user-modal #update-user-form .modal-body #update-user-password"
        ).value,
    
    }).then(response => {
        console.log(response);
        window.location.href = "{{ route('admin.user') }}";
    }).catch(error => {
        console.log(error.response);
        
        const errors = error.response.data.errors;
        const firstError = Object.keys(errors)[0];
        console.log(firstError);    
        const firstErrorDom = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-'+firstError);
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
// end: update user submit

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

// ORGANIZER:

// start: create organizer submit
const createOrganizerForm = document.querySelector(
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
        username: document.querySelector("#create-organizer-modal #create-organizer-form .modal-body #create-user-username"
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
        
        const errors = error.response.data.errors;
        const firstError = Object.keys(errors)[0];
        console.log(firstError);    
        const firstErrorDom = document.querySelector('#create-organizer-modal #create-organizer-form .modal-body #create-organizer-'+firstError);
        const firstErrorMessage = errors[firstError][0];
        
        // scroll to the error message
        firstErrorDom.scrollIntoView();
        
        // remove all the error messages
        const errorMessages = document.querySelectorAll('#create-organizer-modal #create-organizer-form .modal-body .text-danger');
        errorMessages.forEach(element => element.textContent = '');
        
        // remove all the highlighted form
        const formControls = document.querySelectorAll('#create-organizer-modal #create-organizer-form .modal-body .form-control');
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
    
    const user_id = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-user_id');
    user_id.value = (event.target.dataset.user_id);
    
    const firstname = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-firstname');
    firstname.value = (event.target.dataset.firstname);
    
    const middlename = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-middlename');
    middlename.value = (event.target.dataset.middlename);
    
    const lastname = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-lastname');
    lastname.value = (event.target.dataset.lastname);
    
    const email = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-email');
    email.value = (event.target.dataset.email);
    
    const contactno = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-contactno');
    contactno.value = (event.target.dataset.contactno);
    
    const address = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-address');
    address.value = (event.target.dataset.address);
    
    const department = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-department');
    department.value = (event.target.dataset.department);
    
    const course = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-course');
    course.value = (event.target.dataset.course);
    
    const section = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-section');
    section.value = (event.target.dataset.section);
    
    const year = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-year');
    year.value = (event.target.dataset.year);
    
    const username = document.querySelector('#update-organizer-modal #update-organizer-form .modal-body #update-organizer-username');
    username.value = (event.target.dataset.username);
    
    $('#update-organizer-modal').modal({
        show: true,
        backdrop: "static",
        keyboard: false
    });
}
// end: update user modal

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
        
        const errors = error.response.data.errors;
        const firstError = Object.keys(errors)[0];
        console.log(firstError);    
        const firstErrorDom = document.querySelector('#update-user-modal #update-user-form .modal-body #update-user-'+firstError);
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
// end: update user submit

</script>