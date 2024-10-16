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
                <div class="card-content collapse show">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Dayim Marketing!</b>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    @if (Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST"
                            action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-hotel"></i>Edit Products</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="name">Product Name</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="name" id="name">
                                                    <option value="">Select Option</option>
                                                    <option value="DSA" {{ $product->name == 'DSA' ? 'selected' : '' }}>
                                                        DSA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="dealer">Dealer Name</label>
                                        <div class="col-md-9">
                                            <select class="form-control border-primary" name="dealer"
                                                id="dealer">
                                                <option value="">Select Dealer</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->name }}"
                                                        {{ $product->dealer == $user->name ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
    
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="sold">Sold</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="sold" id="sold">
                                                    <option value="">Select Option</option>
                                                    <option value="Yes" {{ $product->sold == 'Yes' ? 'selected' : '' }}>
                                                        Yes</option>
                                                    <option value="No" {{ $product->sold == 'No' ? 'selected' : '' }}>No
                                                    </option>
                                                    <option value="Reserved" {{ $product->sold == 'Reserved' ? 'selected' : '' }}>Reserved
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="purchased_by">Purchased By</label>
                                        <div class="col-md-9">
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

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="title">Title</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control border-primary"
                                                    placeholder="Title" name="title" id="title"
                                                    value="{{ $product->title }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="size">Size</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control border-primary" placeholder="Size"
                                                name="size" id="size" value="{{ $product->size }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="floor">Floor</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="floor" id="floor">
                                                    <option value="">Select Floor</option>
                                                    <option value="Lower Ground"
                                                        {{ $product->floor == 'Lower Ground' ? 'selected' : '' }}>Lower
                                                        Ground</option>
                                                    <option value="Ground"
                                                        {{ $product->floor == 'Ground' ? 'selected' : '' }}>Ground</option>
                                                    <option value="1st"
                                                        {{ $product->floor == '1st' ? 'selected' : '' }}>1st</option>
                                                    <option value="2nd"
                                                        {{ $product->floor == '2nd' ? 'selected' : '' }}>2nd</option>
                                                    <option value="3rd"
                                                        {{ $product->floor == '3rd' ? 'selected' : '' }}>3rd</option>
                                                    <option value="4th"
                                                        {{ $product->floor == '4th' ? 'selected' : '' }}>4th</option>
                                                    <option value="5th"
                                                        {{ $product->floor == '5th' ? 'selected' : '' }}>5th</option>
                                                    <option value="6th"
                                                        {{ $product->floor == '6th' ? 'selected' : '' }}>6th</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="number">Number</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control border-primary" placeholder="Number"
                                                name="number" id="number" value="{{ $product->number }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="type">Type</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="type"
                                                    id="type">
                                                    <option value="">Select Category</option>
                                                    <option value="Shop"
                                                        {{ $product->type == 'Shop' ? 'selected' : '' }}>Shop</option>
                                                    <option value="Office"
                                                        {{ $product->type == 'Office' ? 'selected' : '' }}>Office</option>
                                                    <option value="Apartment"
                                                        {{ $product->type == 'Apartment' ? 'selected' : '' }}>Apartment
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="image">Image</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control border-primary" name="image"
                                                id="image">
                                            @if ($product->image)
                                                <img src="{{ asset('uploads/' . $product->image) }}" alt="Product Image"
                                                    style="max-width: 100px; margin-top: 10px;">
                                            @endif
                                        </div>
                                    </div>
                                </div>

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
    <script src="{{ asset('app-assets/vendors/js/forms/select/selectize.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/core/libraries/jquery_ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('app-assets/js/scripts/forms/select/form-selectize.js') }}" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
                toastr.success('{{ Session::get('success') }}', 'Dayim Marketing Says', {
                    timeOut: 2000
                });
            });
        </script>
    @endif
@endsection
