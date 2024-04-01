@extends('admin_layouts.master')
@section('style')
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
                            <b><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Dayim Marketing!</b>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('dsa.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-hotel"></i>Add Products</h4>
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
                                        <label class="col-md-3 label-control" for="code">Code</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control border-primary" placeholder="Code"
                                                name="code" id="code" required>

                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="form_number">Form Number</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control border-primary"
                                                    placeholder="Form Number" name="form_number" id="form_number">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="floor">Floor</label>
                                        <div class="col-md-9">
                                            {{-- <input type="text" class="form-control border-primary" placeholder="Email"
                                                name="email" id="email" required> --}}
                                            <select class="form-control border-primary" name="floor" id="floor"
                                                required>
                                                <option value="">Select Floor</option>
                                                <option value="lower_ground">Lower Ground</option>
                                                <option value="ground">Ground</option>
                                                <option value="1st">1st</option>
                                                <option value="2nd">2nd</option>
                                                <option value="3rd">3rd</option>
                                                <option value="4th">4th</option>
                                                <option value="5th">5th</option>
                                                <option value="6th">6th</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="category">Category</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="category" id="category"
                                                    required>
                                                    <option value="">Select Category</option>
                                                    <option value="shop">Shop</option>
                                                    <option value="apartment_deluxe">Apartment - Deluxe</option>
                                                    <option value="apartment_executive">Apartment - Executive</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="sales_value">Sales Value</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control border-primary"
                                                placeholder="Sales Value" name="sales_value" id="sales_value">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="type">Type</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control border-primary" placeholder="Type"
                                                    name="type" id="type">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="number">No #</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control border-primary" placeholder="No #"
                                                name="number" id="number" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="size">Size</label>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control border-primary"
                                                    placeholder="Size" name="size" id="size">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="image">Image</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control border-primary" name="image"
                                                id="image" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save
                                    </button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
@endsection
