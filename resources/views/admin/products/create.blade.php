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
                        <form class="form form-horizontal" method="POST" action="{{ route('products.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-hotel"></i>Add Products</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="name">Product Name</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="name" id="name">
                                                    <option value="">Select Option</option>
                                                    <option value="DSA">DSA</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="dealer">Dealer Name</label>
                                        <div class="col-md-9">
                                            <select class="form-control border-primary" name="dealer" id="dealer">
                                                <option value="">Select Dealer</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
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
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                    <option value="Reserved">Reserved</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="purchased_by">Purchased By</label>
                                        <div class="col-md-9">
                                            <select class="form-control border-primary" name="purchased_by" id="purchased_by">
                                                <option value="">Select User</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->name }}">{{ $user->name }}</option>
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
                                                    placeholder="Title" name="title" id="title">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="size">Size</label>
                                        <div class="col-md-9">
                                            <input type="size" class="form-control border-primary" placeholder="Size"
                                                name="size" id="size">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="floor">Floor</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="floor" id="floor"
                                                    required>
                                                    <option value="">Select Floor</option>
                                                    <option value="Lower Ground">Lower Ground</option>
                                                    <option value="Ground">Ground</option>
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
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="sales_value">Number</label>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control border-primary" placeholder="Number"
                                                name="number" id="number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="type">Type</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="type" id="type"
                                                    required>
                                                    <option value="">Select Category</option>
                                                    <option value="Shop">Shop</option>
                                                    <option value="Office">Office</option>
                                                    <option value="Apartment">Apartment</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="image">Image</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control border-primary" name="image"
                                                id="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="la la-check-square-o"></i> Save
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
@endsection
