@extends('layouts.app')

@section('content')
    <div class="container">
        @include('include.messages')

        <section id="user-profile">
            <div class="row">
                <div class="col-sm-12">
                   <h4 class="text-gray-900">Profile {{ $user->firstname.' '.$user->lastname }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">                    

                    <form id="form-update-profile" action="{{ route('update.profile') }}" method="post">
                        @csrf
                        @method('patch')                    
                        <input type="hidden" name="user_id" id="edit-profile-user_id" value="{{ Auth::user()->id }}">
                        
                        <div class="modal-content">

                            <small class="text-right mx-3 mt-3"><small class="alert-danger">*</small> required to save * required to complete</small>

                            <div class="modal-body">
                                
                                {{-- first row --}}
                                <div class="row">
                                    <div class="form-group-sm col-sm-4">
                                        <label for="email" class="col-form-label-sm">Email <small class="alert-danger">*</small></label>
                                        <input type="text" class="form-control" name="email" id="edit-profile-email" value="{{ $user->email ? $user->email : null }}">
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label title="title" for="title" class="col-form-label-sm">Title: <small>*</small></label>
                                        <select name="title" id="edit-profile-title" name="profile-title" class="form-control">
                                            <option value="" disabled>Select...</option>                                                                        
                                            @foreach ($user->titles() as $title)
                                                <option value="{{ $title }}" {{ $user->title == $title ? 'selected' : null }}> {{ $title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="firstname" class="col-form-label-sm">Firstname <small class="alert-danger">*</small></label>
                                        <input type="text" class="form-control" name="firstname" id="edit-profile-firstname" value="{{ $user->firstname ? $user->firstname : null }}">
                                    </div>
                                </div>

                                 {{-- second row --}}
                                 <div class="row">
                                    <div class="form-group-sm col-sm-4">
                                        <label for="middlename" class="col-form-label-sm">Middlename <small>*</small></label>
                                        <input type="text" class="form-control" name="middlename" id="edit-profile-middlename" value="{{ $user->middlename ? $user->middlename : null }}">
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="lastname" class="col-form-label-sm">Lastname <small class="alert-danger">*</small></label>
                                        <input type="text" class="form-control" name="lastname" id="edit-profile-lastname" value="{{ $user->lastname ? $user->lastname : null }}">
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="nickname" class="col-form-label-sm">Nickname <small class="alert-danger">*</small></label>
                                        <input type="text" class="form-control" name="nickname" id="edit-profile-nickname" value="{{ $user->nickname ? $user->nickname : null }}">
                                    </div>
                                </div>

                                 {{-- third row --}}
                                 <div class="row">
                                    <div class="form-group-sm col-sm-4">
                                        <label for="certificate-name" class="col-form-label-sm">Certificate Name <small class="alert-danger">*</small></label>
                                        <input type="text" class="form-control" name="certificate_name" id="edit-profile-certificate_name" value="{{ $user->certificate_name ? $user->certificate_name : null }}">
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="contact" class="col-form-label-sm">Contact <small>*</small></label>
                                        <input type="text" class="form-control" name="contactno" id="edit-profile-contactno" value="{{ $user->contactno ? $user->contactno : null }}">
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="address" class="col-form-label-sm">Address <small>*</small></label>
                                        <input type="text" class="form-control" name="address" id="edit-profile-address" value="{{ $user->address ? $user->address : null }}">
                                    </div>
                                </div>

                                 {{-- fourth row --}}
                                 <div class="row">
                                    <div class="form-group-sm col-sm-4">
                                        <label for="occupation" class="col-form-label-sm">Occupation <small>*</small></label>
                                        <input type="text" class="form-control" name="occupation" id="edit-profile-occupation" value="{{ $user->occupation ? $user->occupation : null }}">
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="sex" class="col-form-label-sm">Sex <small>*</small></label>
                                        <select name="sex" id="edit-profile-sex" class="form-control">
                                            @foreach ($user->sexs() as $sex)
                                                <option value="{{ $sex }}" {{ $user->sex == $sex ? 'selected' : null }}>{{ $sex }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="birthday" class="col-form-label-sm">Date of Birth <small>*</small></label>
                                        <input type="date" class="form-control" name="birthday" id="edit-profile-birthday" value="{{ $user->birthday ? $user->birthday : null }}">
                                    </div>
                                </div>

                                 {{-- fifth row --}}
                                 <div class="row">
                                    <div class="form-group-sm col-sm-4">
                                        <label for="department" class="col-form-label-sm">Department <small>*</small></label>                                        
                                        <select name="department" id="edit-profile-department" class="form-control">
                                            @foreach ($departments as $department)
                                                <option value="{{$department->id}}" {{ $department->id == $user->department_id ? 'selected' : ''}}>{{$department->abbr}}</option>
                                            @endforeach                                        
                                        </select>
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="course" class="col-form-label-sm">Course <small>*</small></label>
                                        <select name="course" id="edit-profile-course" class="form-control">
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}" {{$user->course_id == $course->id ? 'selected' : null }}>{{ $course->abbr }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <div class="row">
                                            <div class="form-group-sm col-sm-6">
                                                <label for="section" class="col-form-label-sm">Section <small>*</small></label>
                                                <select name="section" id="edit-profile-section" class="form-control">
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}" {{ $user->section_id == $section->id ? 'selected' : null }}>{{ $section->section }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group-sm col-sm-6">
                                                <label for="year" class="col-form-label-sm">Year <small>*</small></label>
                                                <input type="text" class="form-control" name="year" id="edit-profile-year" value="{{ $user->year ? $user->year : null }}">
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                 {{-- sixth row --}}
                                 <div class="row">
                                    <div class="form-group-sm col-sm-4">
                                        <label for="institution" class="col-form-label-sm">Institution <small class="alert-danger">*</small></label>
                                        <input type="text" class="form-control" name="institution" id="edit-profile-institution" value="{{ $user->institution ? $user->institution : null }}">
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="username" class="col-form-label-sm">Username <small>*</small></label>
                                        <input type="text" class="form-control" name="username" id="edit-profile-username" value="{{ $user->username ? $user->username : null }}" disabled>
                                    </div>
                                    <div class="form-group-sm col-sm-4">
                                        <label for="password" class="col-form-label-sm">Password <small >*</small></label>
                                        <input type="password" class="form-control" name="password" id="edit-profile-password">
                                    </div>
                                </div>

                                <br>

                               <div class="modal-footer">
                                   <button type="submit" class="btn btn-primary"> <i class="fa fa-save"></i> Save</button>
                               </div>

       
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    @include('profile.script-profile')
@endsection
