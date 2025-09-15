@extends('admin_layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/selects/selectize.default.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/plugins/forms/selectize/selectize.css') }}">
    <script src="https://kit.fontawesome.com/d868f4cf6e.js" crossorigin="anonymous"></script>
@endsection
@section('content')
    <div class="content-header row"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-content collapse show">
                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <b><i class="fa fa-exclamation-triangle"></i> Dayim Marketing!</b>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Success / Error Messages --}}
                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger">{{ Session::get('error') }}</div>
                    @endif

                    <div class="card-body">
                        <form class="form form-horizontal" method="POST"
                            action="{{ route('products.zindagi_update', $product->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-hotel"></i> Edit Zindagi Product</h4>

                                {{-- Dealer + Purchased By --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dealer">Dealer</label>
                                            <select class="form-control border-primary" name="dealer" id="dealer">
                                                <option value="">Select Dealer</option>
                                                @foreach ($dealers as $dealer)
                                                    <option value="{{ $dealer->name }}"
                                                        {{ $product->dealer == $dealer->name ? 'selected' : '' }}>
                                                        {{ $dealer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="purchased_by">Purchased By</label>
                                            <select class="form-control border-primary" name="purchased_by"
                                                id="purchased_by">
                                                <option value="">Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->name }}"
                                                        {{ $product->purchased_by == $user->name ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Sold + Title --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="sold">Sold</label>
                                            <select class="form-control border-primary" name="sold" id="sold">
                                                <option value="">Select Option</option>
                                                <option value="Yes" {{ $product->sold == 'Yes' ? 'selected' : '' }}>Yes
                                                </option>
                                                <option value="No" {{ $product->sold == 'No' ? 'selected' : '' }}>No
                                                </option>
                                                <option value="Reserved"
                                                    {{ $product->sold == 'Reserved' ? 'selected' : '' }}>Reserved</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control border-primary" name="title"
                                                id="title" value="{{ $product->title }}" placeholder="Title">
                                        </div>
                                    </div>
                                </div>

                                {{-- Category + DZ Type --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select class="form-control border-primary" name="category" id="category">
                                                <option value="">Select Category</option>
                                                <option value="Commercial Outlets"
                                                    {{ $product->category == 'Commercial Outlets' ? 'selected' : '' }}>
                                                    Commercial Outlets / Office</option>
                                                <option value="Apartment"
                                                    {{ $product->category == 'Apartment' ? 'selected' : '' }}>Apartment
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="dz_type">Type</label>
                                            <select class="form-control border-primary" name="dz_type" id="dz_type">
                                                <option value="">Select Type</option>
                                                <option value="Studio"
                                                    {{ $product->dz_type == 'Studio' ? 'selected' : '' }}>Studio</option>
                                                <option value="One Bed"
                                                    {{ $product->dz_type == 'One Bed' ? 'selected' : '' }}>One Bed</option>
                                                <option value="Two Bed"
                                                    {{ $product->dz_type == 'Two Bed' ? 'selected' : '' }}>Two Bed</option>
                                                <option value="Outlet"
                                                    {{ $product->dz_type == 'Two Bed' ? 'selected' : '' }}>Two Bed</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Subtype (full width if needed) --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="subtype">Subtype</label>
                                            <select class="form-control border-primary" name="subtype" id="subtype">
                                                <option value="">Select Subtype</option>
                                                @if ($product->subtype)
                                                    <option value="{{ $product->subtype }}" selected>
                                                        {{ $product->subtype }}</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                {{-- Size + Floor + Number --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="size">Size</label>
                                            <input type="text" class="form-control border-primary" name="size"
                                                id="size" value="{{ $product->size }}" placeholder="Size">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="floor">Floor</label>
                                            <select class="form-control border-primary" name="floor" id="floor">
                                                <option value="">Select Floor</option>
                                                @foreach (['Lower Ground', 'Ground', '1st', '2nd', '3rd', '4th', '5th', '6th', '7th'] as $f)
                                                    <option value="{{ $f }}"
                                                        {{ $product->floor == $f ? 'selected' : '' }}>{{ $f }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="number">Number</label>
                                            <input type="number" class="form-control border-primary" name="number"
                                                id="number" value="{{ $product->number }}" placeholder="Number">
                                        </div>
                                    </div>
                                </div>

                                {{-- Image --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="image">Image</label>
                                            <input type="file" class="form-control border-primary" name="image"
                                                id="image">
                                            @if ($product->image)
                                                <img src="{{ asset('uploads/' . $product->image) }}" alt="Product Image"
                                                    style="max-width: 100px; margin-top: 10px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Submit --}}
                                <div class="form-actions right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Update
                                    </button>
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
    <script src="{{ asset('app-assets/vendors/js/forms/select/selectize.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-selectize.js') }}"></script>
    <script>
        // Dynamic subtype options
        const subtypeOptions = {
            "Studio": ["Elite", "Royal"],
            "One Bed": ["Blue View", "Elite", "Royal"],
            "Two Bed": ["Twin Treat"]
        };

        function loadSubtype(selectedType) {
            let subtypeSelect = $("#subtype");
            subtypeSelect.empty().append('<option value="">Select Subtype</option>');
            if (subtypeOptions[selectedType]) {
                subtypeOptions[selectedType].forEach(opt => {
                    let selected = "{{ $product->subtype }}" === opt ? "selected" : "";
                    subtypeSelect.append(`<option value="${opt}" ${selected}>${opt}</option>`);
                });
            }
        }

        $(document).ready(function() {
            // Load on page load
            loadSubtype($("#dz_type").val());

            // Load on change
            $("#dz_type").on("change", function() {
                loadSubtype($(this).val());
            });
        });
    </script>
@endsection
