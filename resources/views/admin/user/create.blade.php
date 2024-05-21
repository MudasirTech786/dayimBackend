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
                        <form class="form form-horizontal" method="POST" action="{{ route('users.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la la-car"></i>Add User</h4>
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput1">Profile Picture</label>
                                            <div class="col-md-9">
                                                <input type="file" class="form-control border-primary" name="image">
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
                                                    name="name" id="name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="email">Email</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control border-primary" placeholder="Email"
                                                name="email" id="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="cnic">CNIC</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control border-primary" placeholder="CNIC"
                                                    name="cnic" required id="cnic">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="password">Password</label>
                                        <div class="col-md-9">
                                            <input type="password" class="form-control border-primary"
                                                placeholder="Password" name="password" required id="password">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="dob">DOB</label>
                                            <div class="col-md-9">
                                                <input type="date" class="form-control border-primary" name="dob"
                                                    id="dob">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="gender">Gender</label>
                                        <div class="col-md-9">
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="maleGenderRadio"
                                                    name="gender" value="M">
                                                <label class="form-check-label" for="maleGenderRadio">Male</label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" class="form-check-input" id="femaleGenderRadio"
                                                    name="gender" value="F">
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
                                                <input type="text" class="form-control border-primary"
                                                    placeholder="Designation" name="occupation" id="occupation">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="phone">Phone</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control border-primary" placeholder="Phone"
                                                name="phone" id="phone">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="address">Address</label>
                                            <div class="col-md-9">
                                                <input type="address" class="form-control border-primary"
                                                    placeholder="Address" name="address" id="address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="address">Active</label>
                                        <div class="col-md-9">
                                            <input type="checkbox" class="form-check-input" id="activeUserCheckbox"
                                                name="active" value="1">
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
                                    {{-- <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput1">Sheet No.</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control border-primary"
                                                    placeholder="Sheet #" name="sheet_no">
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput1">Role</label>
                                            <div class="col-md-6">
                                                <select name="roles" class="form-control">
                                                    @foreach ($roles as $roleName)
                                                        <option value="{{ $roleName }}">{{ $roleName }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-md-4 label-control" for="userinput1">Sheet
                                                    Number</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control border-primary"
                                                        placeholder="Sheet #" name="sheet_no" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-md-4 label-control" for="userinput1">Inventory
                                                    Name</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control border-primary"
                                                        placeholder="Sheet #" name="inventory_name" value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <label class="col-md-4 label-control" for="userinput1">Form
                                                    Number</label>
                                                <div class="col-md-8">
                                                    <input type="text" class="form-control border-primary"
                                                        placeholder="Sheet #" name="form_no" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="form-actions center">
                                <button type="submit" class="btn btn-primary col-md-3">
                                    <i class="la la-check-square-o"></i> Save
                                </button>
                            </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('app-assets/vendors/js/forms/select/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-selectize.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        window.setTimeout(function() {
            $(".alert").fadeTo(2000, 0).slideUp(2000, function() {
                $(this).remove();
            });
        }, 2000);
    </script>
    @if (Session::get('success'))
        <script>
            $(document).ready(function() {
                toastr.success('<?php echo Session::get('success'); ?>', 'Fast Lines Says', {
                    timeOut: 2000
                })
            });
        </script>
    @endif
@endsection
