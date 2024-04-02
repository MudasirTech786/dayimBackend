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
                        <h2 class="text-success font-bold">No payment to add</h2>
                        {{-- <h2 class="text-success font-bold">You have 5 payments to add</h2> --}}
                        <form class="form form-horizontal" method="POST" action="{{ route('dsa.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-hotel"></i>Add Payment</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="pay_head">Pay Head</label>
                                            <div class="col-md-9">
                                                <select class="form-control border-primary" name="pay_head" id="pay_head"
                                                    required>
                                                    <option value="">Select Pay Head</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="due_date">Due Date</label>
                                        <div class="col-md-9">
                                            <input type="date" disabled class="form-control border-primary"
                                                name="due_date" id="due_date" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="due_amount">Due amount</label>
                                            <div class="col-md-9">
                                                <input type="text" placeholder="Due Amount"
                                                    class="form-control border-primary" name="due_amount" id="due_amount"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="payment_proof">Payment Proof</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control border-primary" name="payment_proof"
                                                id="payment_proof" required>
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
