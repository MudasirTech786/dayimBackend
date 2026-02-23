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

        .status-btn-group label {
            filter: grayscale(30%);
        }

        .status-btn-group input[type="radio"] {
            display: none;
        }

        .status-btn-group input[type="radio"]:checked+label {
            filter: grayscale(0);
            opacity: 1;
            transform: scale(1.05);
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.4), 0 0 12px rgba(50, 150, 250, 0.6);
            border: 2px solid #333;
            font-weight: 600;
        }

        .removeSheet {
            margin-top: 28px;
        }
    </style>
@endsection

@section('content')
<div class="content-header row"></div>
<div class="row">
<div class="col-md-12">
<div class="card shadow-lg border-0">
<div class="card-content collapse show">

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<b><i class="fa fa-exclamation-triangle"></i> Fast Lines!</b>
<ul class="mb-0">
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<div class="card-body">

<form method="POST"
      action="{{ route('users.update', $user->id) }}"
      enctype="multipart/form-data"
      autocomplete="off">

@csrf
@method('PATCH')

{{-- 🔥 Chrome Autofill Blocker --}}
<input type="text" name="fake_username" autocomplete="username" style="display:none">
<input type="password" name="fake_password" autocomplete="new-password" style="display:none">

<h4 class="form-section"><i class="la la-user"></i> Edit User</h4>

<div class="row mb-3">
<div class="col-md-6">
<label for="name">Name</label>
<input type="text"
       id="name"
       class="form-control border-primary"
       name="name"
       value="{{ $user->name }}"
       required
       autocomplete="off">
</div>

<div class="col-md-6">
<label for="email">Email</label>
<input type="email"
       id="email"
       class="form-control border-primary"
       name="email"
       value="{{ $user->email ?? '' }}"
       autocomplete="new-email">
</div>
</div>

@if ($currentRole == 'Admin')
<div class="row mb-3">
<div class="col-md-6">
<label for="cnic">CNIC</label>
<input type="text"
       id="cnic"
       class="form-control border-primary"
       name="cnic"
       value="{{ $user->cnic }}"
       required
       autocomplete="off">
</div>

<div class="col-md-6">
<label for="password">Change Password</label>
<input type="password"
       id="password"
       class="form-control border-primary"
       name="password"
       placeholder="Leave blank if unchanged"
       autocomplete="new-password">
</div>
</div>
@endif

<div class="row mb-3">
<div class="col-md-12">
<label>Status</label>
<div class="status-btn-group d-flex flex-wrap">
<input type="radio" id="active" name="active" value="1" {{ $user->active == 1 ? 'checked' : '' }}>
<label for="active" class="btn btn-success">Active</label>

<input type="radio" id="blocked" name="active" value="2" {{ $user->active == 2 ? 'checked' : '' }}>
<label for="blocked" class="btn btn-danger">Blocked</label>

<input type="radio" id="nonactive" name="active" value="0" {{ $user->active == 0 ? 'checked' : '' }}>
<label for="nonactive" class="btn btn-secondary">Non Active</label>
</div>
</div>
</div>

@if ($currentRole == 'Admin')
<div class="row mb-3">
<div class="col-md-6">
<label for="role">Role</label>
<select name="roles" class="form-control border-primary" autocomplete="off">
@foreach ($roles as $roleName)
<option value="{{ $roleName }}"
{{ $user->roles->first() && $roleName == $user->roles->first()->name ? 'selected' : '' }}>
{{ $roleName }}
</option>
@endforeach
</select>
</div>
</div>
@endif

@if ($currentRole == 'Admin')
<h5 class="form-section mt-3"><i class="la la-table"></i> Sheets</h5>
<div id="sheetDiv">
@foreach ($user->sheets as $sheet)
<div class="row sheet-row mb-2">
<input type="hidden" name="sheet_ids[]" value="{{ $sheet->id }}">

<div class="col-md-3">
<input type="text" class="form-control border-primary"
name="sheet_no[]"
value="{{ $sheet->sheet_no }}"
autocomplete="off">
</div>

<div class="col-md-3">
<input type="text" class="form-control border-primary"
name="inventory_name[]"
value="{{ $sheet->inventory_name }}"
autocomplete="off">
</div>

<div class="col-md-3">
<input type="text" class="form-control border-primary"
name="form_no[]"
value="{{ $sheet->form_no }}"
autocomplete="off">
</div>

<div class="col-md-3">
<select class="form-control border-primary"
name="dealer[]"
autocomplete="off">
<option value="">Select Dealer</option>
@foreach ($users as $dealer)
<option value="{{ $dealer->name }}"
{{ $sheet->dealer == $dealer->name ? 'selected' : '' }}>
{{ $dealer->name }}
</option>
@endforeach
</select>
</div>
</div>
@endforeach
</div>

<button type="button" class="btn btn-info mt-2" id="addMoreSheets">
<i class="fa fa-plus"></i> Add More
</button>
@endif

<div class="form-actions text-center mt-4">
<button type="submit" class="btn btn-primary px-4">
<i class="la la-check"></i> Update User
</button>
</div>

</form>
</div>
</div>
</div>
</div>
</div>

<script>
$(document).on("click", "#addMoreSheets", function(e) {
e.preventDefault();

let add_sheet = `
<div class="row sheet-row mb-2">
<input type="hidden" name="sheet_ids[]" value="">
<div class="col-md-3">
<input type="text" class="form-control border-primary" name="sheet_no[]" required autocomplete="off">
</div>
<div class="col-md-3">
<input type="text" class="form-control border-primary" name="inventory_name[]" required autocomplete="off">
</div>
<div class="col-md-3">
<input type="text" class="form-control border-primary" name="form_no[]" required autocomplete="off">
</div>
<div class="col-md-2">
<select class="form-control border-primary" name="dealer[]" required autocomplete="off">
<option value="">Select Dealer</option>
@foreach ($users as $dealer)
<option value="{{ $dealer->name }}">{{ $dealer->name }}</option>
@endforeach
</select>
</div>
<div class="col-md-1 d-flex align-items-center">
<button type="button" class="btn btn-danger btn-sm removeSheet">
<i class="fa fa-minus"></i>
</button>
</div>
</div>`;

$("#sheetDiv").append(add_sheet);
});

$(document).on("click", ".removeSheet", function() {
$(this).closest('.sheet-row').remove();
});
</script>
@endsection