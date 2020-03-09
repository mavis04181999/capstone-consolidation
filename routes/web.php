<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



// Route::get('/', function(){
//     return redirect()->route('login');
// });

// routes for login, logout, register, reset password and forget password
    Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

// routes for admin:
    Route::get('/dashboard/event', 'AdminsController@index')->name('admin.index');
    Route::get('/dashboard/user', 'AdminsController@dashboardUser')->name('admin.user');
    Route::get('/dashboard/organizer', 'AdminsController@dashboardOrganizer')->name('admin.organizer');
    Route::get('/dashboard/settings', 'AdminsController@dashboardSettings')->name('admin.settings');

    // Departments
    Route::post('/dashboard/settings/department', 'DepartmentsController@store')->name('store.department');
    Route::delete('/dashboard/settings/department/{department}', 'DepartmentsController@destroy')->name('delete.department');
    // Courses
    Route::post('/dashboard/settings/course', 'CoursesController@store')->name('store.course');
    Route::delete('/dashboard/settings/course/{course}', 'CoursesController@destroy')->name('delete.course');
    // Sections
    Route::post('/dashboard/settings/section', 'SectionsController@store')->name('store.section');
    Route::delete('/dashboard/settings/section/{section}', 'SectionsController@destroy')->name('delete.section');

    Route::post('/import/user', 'AdminsController@import')->name('import.user');
    Route::post('/admin/user', 'AdminsController@store')->name('store.user');
    Route::patch('/admin/user/user', 'AdminsController@update')->name('update.user');
    Route::delete('/admin/user/user', 'AdminsController@destroy')->name('delete.user');
    Route::delete('/admin/users/users', 'AdminsController@destroys')->name('deletes.user');

// routes for events:
    Route::get('/admin/event/{event}', 'EventsController@show')->name('show.event');
    Route::get('/admin/event/{event}/manage', 'EventsController@manage')->name('manage.event');
    Route::get('/admin/archives', 'EventsController@viewArchives')->name('view.archives');
    Route::post('/admin/event', 'EventsController@store')->name('store.event');
    Route::post('/admin/event/feature', 'EventsController@feature')->name('feature.event');
    Route::patch('/admin/event/archive', 'EventsController@archive')->name('archive.event');
    Route::patch('/admin/event/unarchive', 'EventsController@unarchive')->name('unarchive.event');
    Route::patch('/admin/event/event', 'EventsController@update')->name('update.event');
    Route::patch('/admin/event/formtype', 'EventsController@formtype')->name('formtype.event');
    Route::delete('/admin/event/event', 'EventsController@destroy')->name('delete.event');
    

// Route for events-participants:
    Route::get('/admin/event/{event}/participants', 'ParticipantsController@index')->name('index.participants');
    Route::get('/admin/event/{event}/add-participants', 'ParticipantsController@show')->name('show.participants');

    Route::post('/admin/event/participants', 'ParticipantsController@store')->name('store.participants');
    Route::delete('/admin/event/participant', 'ParticipantsController@destroy')->name('remove.participant');
    Route::delete('/admin/event/participants', 'ParticipantsController@destroys')->name('remove.participants');

// Route for events-payment collection
    Route::get('/event/{event}/payment', 'PaymentsController@show')->name('show.payment');
    Route::get('/admin/event/{event}/payment', 'PaymentsController@index')->name('index.payment');  

    Route::post('/admin/event/payment', 'PaymentsController@store')->name('store.payment');
    Route::post('admin/event/payments', 'PaymentsController@import')->name('import.payments');

    Route::delete('admin/event/payment', 'PaymentsController@destroy')->name('delete.payment');
    Route::delete('admin/event/payments', 'PaymentsController@destroys')->name('delete.payments');

// Route for events-attendance
    Route::get('/admin/event/{event}/attendance', 'AttendancesController@index')->name('index.attendance');
    Route::get('/event/{event}/attendance', 'AttendancesController@show')->name('show.attendance');

    Route::patch('/event/{event}/attendance', 'AttendancesController@update')->name('update.attendance');

// Route for events registration
    Route::get('/event/{event}/registration', 'RegistrationsController@show')->name('show.registration');
    Route::patch('/event/{event}/registration', 'RegistrationsController@update')->name('update.registration');

// Route for events setting
    Route::get('/admin/event/{event}/setting', 'EventsController@eventsetting')->name('index.setting');
    Route::post('/admin/event/eventimage', 'EventsController@eventimage')->name('import.eventimage');
    Route::post('/admin/event/certificate', 'EventsController@certificate')->name('import.certificate');
    Route::post('/admin/event/eventid', 'EventsController@eventid')->name('import.eventid');

// Route for events-form
    Route::get('admin/form/event-{event}/create', 'FormsController@create')->name('form.create');
    Route::get('admin/form/event-{event}/edit', 'FormsController@edit')->name('form.edit');
    Route::get('admin/form/event-{event}/show', 'FormsController@show')->name('form.show');
    // Form Route:
    Route::get('/admin/forms/{event}', 'FormsController@index')->name('form.index');
    Route::post('/admin/forms', 'FormsController@store')->name('form.store');
    Route::patch('/admin/forms/{form}', 'FormsController@update')->name('form.update');
    Route::delete('/admin/forms/{form}', 'FormsController@destroy')->name('form.delete');
    // Option Route:
    Route::get('/admin/forms/{form}/option', 'FormsController@options')->name('form.option');
    Route::post('/admin/options', 'OptionsController@store')->name('option.store');
    Route::patch('/admin/options/{option}', 'OptionsController@update')->name('option.update');
    Route::delete('/admin/options/{form}', 'FormsController@optionsdel')->name('option.delete');

// Evaluation Route:
Route::post('/evaluations', 'EvaluationsController@store')->name('evaluation.store');

Route::get('/evaluate/evaluation-{evaluation}/create', 'EvaluatesController@create')->name('evaluates.create');
Route::post('/evaluate', 'EvaluatesController@store')->name('evaluates.store');

Route::get('/ticket/{ticket}', 'TicketsController@show')->name('ticket.show');

Route::get('/admin/events/{event}/pdfreport', 'EventsController@pdfreport')->name('event.pdfreport');
Route::get('/certificate/{event}', 'TicketsController@pdfcertificate')->name('event.pdfcertificate');
Route::get('/participants/{event}', 'ParticipantsController@pdfparticipants')->name('event.pdfparticipants');


// routes for organizer:
    Route::get('/organizer', 'OrganizersController@index')->name('organizer.index');

// routes for user:
    Route::get('/home', 'UsersController@index')->name('user.index')->middleware('user');
    Route::get('/profile/{user}', 'UsersController@show')->name('show.profile');
    Route::patch('/profile/user/user', 'UsersController@update')->name('update.profile');

    // redirect to welcome page
    Route::get('/', function () {
        if (Auth::guest()) {
            return redirect()->route('login');
        }

        switch (Auth::user()->role) {
            case 'admin':
                return back();
                break;
            case 'organizer':
                return back();
                break;
            case 'user':
                return back();
                break;
        }
        
    });
