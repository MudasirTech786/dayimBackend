@extends('admin_layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/selectize/selectize.css') }}">
    <script src="https://kit.fontawesome.com/d868f4cf6e.js" crossorigin="anonymous"></script>
@endsection
@section('content')
    <div class="content-header row">
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collpase show">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Fast Lines!</b>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('users.update', $user->id) }}"
                            enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la la-car"></i>Edit User</h4>
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput1">Profile Picture</label>
                                            <div
                                                style="display: flex; align-items: center; justify-content: space-between; ">
                                                @if ($route->image != null)
                                                    <img src="{{ asset('uploads/' . $route->image) }} "
                                                        style="width:70px; height:70px; border: 1px solid #ccc; /* Add border */
                                                    border-radius: 5px; margin-left:142px;
                                                    padding: 5px;
                                                    margin-top: 5px;">
                                                @else
                                                    <img src="{{ asset('app-assets/images/profile/profile_picture.jpeg') }} "
                                                        style="width:70px; height:70px; border: 1px solid #ccc; /* Add border */
                                                    border-radius: 5px; margin-left:142px;
                                                    padding: 5px;
                                                    margin-top: 5px;">
                                                @endif
                                                <div class="col-md-9">
                                                    <input type="file" class="form-control border-primary"
                                                        name="image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="name">Name</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control border-primary" placeholder="Name"
                                                    name="name" value="{{ $user->name }}" id="name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="email">Email</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control border-primary" placeholder="Email"
                                                name="email" value="{{ $user->email }}" id="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="cnic">CNIC</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control border-primary" placeholder="CNIC"
                                                    name="cnic" value="{{ $user->cnic }}" required id="cnic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="userinput1">Change Password</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control border-primary" value=""
                                                name="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="dob">DOB</label>
                                            <div class="col-md-9">
                                                <input type="date" value="{{ $user->dob }}" class="form-control border-primary" name="dob"
                                                    id="dob">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="gender">Gender</label>
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="maleGenderRadio" name="gender" value="M"
                                                    {{ $user->gender == 'M' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="maleGenderRadio">Male</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="femaleGenderRadio" name="gender" value="F"
                                                    {{ $user->gender == 'F' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="femaleGenderRadio">Female</label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="occupation">Occupation</label>
                                            <div class="col-md-9">
                                                <input value="{{ $user->occupation }}" type="text" class="form-control border-primary"
                                                    placeholder="Designation" name="occupation" id="occupation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="phone">Phone</label>
                                        <div class="col-md-9">
                                            <input type="number"  value="{{ $user->phone }}" class="form-control border-primary" placeholder="Phone"
                                                name="phone" id="phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="address">Address</label>
                                            <div class="col-md-9">
                                                <input type="address" value="{{ $user->address }}" class="form-control border-primary"
                                                    placeholder="Address" name="address" id="address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="address">Active</label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="form-check-input" id="activeUserCheckbox" name="activeUser" value="1"
                                            {{ $user->active ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="image">Image</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control border-primary"
                                                name="image" id="image" >
                                        </div>
                                    </div> --}}
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput1">Role</label>
                                            <div class="col-md-6">
                                                <select name="roles" class="form-control" style="width: 500px">
                                                    @foreach ($roles as $roleName)
                                                        <option value="{{ $roleName }}">{{ $roleName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions center">
                                <button type="submit" class="btn btn-primary col-md-3">
                                    <i class="la la-check-square-o"></i> Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
