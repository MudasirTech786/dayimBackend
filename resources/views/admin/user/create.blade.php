@extends('admin_layouts.master')

@section('style')
    {{-- Selectize --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/selectize/selectize.css') }}">

    {{-- FontAwesome --}}
    <script src="https://kit.fontawesome.com/d868f4cf6e.js" crossorigin="anonymous"></script>

    <style>
        .status-btn-group .btn {
    min-width: 120px;
    margin-right: 10px;
    font-weight: 500;
    border-radius: 25px;
    transition: all 0.25s ease-in-out;
    opacity: 0.8;
}

/* Make unselected buttons lighter */
.status-btn-group label {
    filter: grayscale(30%);
}

/* Hide radios */
.status-btn-group input[type="radio"] {
    display: none;
}

/* Highlight selected */
.status-btn-group input[type="radio"]:checked+label {
    filter: grayscale(0);
    opacity: 1;
    transform: scale(1.05);
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.4), 0 0 12px rgba(50, 150, 250, 0.6);
    border: 2px solid #333;
    font-weight: 600;
}

    </style>
@endsection

@section('content')
    <div class="content-header row"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-lg border-0">
                <div class="card-content collapse show">

                    {{-- ✅ Error Messages --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong><i class="fa fa-exclamation-triangle"></i> Fast Lines!</strong>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-user-plus"></i> Add User</h4>

                                {{-- Name + Email --}}
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control border-primary" name="name" id="name" placeholder="Enter full name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control border-primary" name="email" id="email" placeholder="Enter email address">
                                    </div>
                                </div>

                                {{-- CNIC + Password --}}
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="cnic">CNIC</label>
                                        <input type="text" class="form-control border-primary" name="cnic" id="cnic" placeholder="Enter CNIC" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control border-primary" name="password" id="password" placeholder="Enter password" required>
                                    </div>
                                </div>

                                {{-- ✅ Hidden Fields --}}
                                <input type="hidden" name="dob" value="">
                                <input type="hidden" name="gender" value="">
                                <input type="hidden" name="occupation" value="">
                                <input type="hidden" name="phone" value="">
                                <input type="hidden" name="address" value="">

                                {{-- Status --}}
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label>Status</label>
                                        <div class="status-btn-group d-flex">
                                            <input type="radio" id="active" name="active" value="1">
                                            <label for="active" class="btn btn-success">Active</label>

                                            <input type="radio" id="blocked" name="active" value="2">
                                            <label for="blocked" class="btn btn-danger">Blocked</label>

                                            <input type="radio" id="nonactive" name="active" value="0">
                                            <label for="nonactive" class="btn btn-secondary">Non Active</label>
                                        </div>
                                    </div>
                                </div>

                                {{-- Role --}}
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <label for="role">Role</label>
                                        <select name="roles" class="form-control border-primary">
                                            @foreach ($roles as $roleName)
                                                <option value="{{ $roleName }}">{{ $roleName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Sheet / Inventory / Form --}}
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="sheet_no">Sheet Number</label>
                                        <input type="text" class="form-control border-primary" name="sheet_no">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="inventory_name">Inventory Name</label>
                                        <input type="text" class="form-control border-primary" name="inventory_name">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="form_no">Form Number</label>
                                        <input type="text" class="form-control border-primary" name="form_no">
                                    </div>
                                </div>
                            </div>

                            {{-- Save --}}
                            <div class="form-actions text-center mt-4">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="la la-check"></i> Save User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{-- Selectize --}}
    <script src="{{ asset('app-assets/vendors/js/forms/select/selectize.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-selectize.js') }}"></script>

    {{-- Fadeout Alerts --}}
    <script>
        setTimeout(() => {
            $(".alert").fadeTo(2000, 0).slideUp(2000, function() {
                $(this).remove();
            });
        }, 2000);
    </script>

    {{-- Toastr Success --}}
    @if (Session::get('success'))
        <script>
            $(function() {
                toastr.success('{{ Session::get('success') }}', 'Fast Lines Says', { timeOut: 2000 })
            });
        </script>
    @endif
@endsection
