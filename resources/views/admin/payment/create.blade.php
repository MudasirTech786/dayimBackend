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
                        {{-- <h2 class="text-success font-bold">You have 5 payments to add</h2> --}}
                        <form class="form form-horizontal" method="POST" action="{{ route('payments.store_proof', $payment['id']) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-body">
                                <h4 class="form-section"><i class="la la-hotel"></i>Add Payment</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="pay_head">Pay Head</label>
                                            <div class="col-md-9">
                                                <input type="text" disabled class="form-control border-primary" value="{{$payment['pay_head']}}"
                                                name="pay_head" id="pay_head" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="due_date">Due Date</label>
                                        <div class="col-md-9">
                                            <input type="date" disabled class="form-control border-primary"
                                                name="due_date" id="due_date" value="{{$payment['due_date']}}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="due_amount">Due amount</label>
                                            <div class="col-md-9">
                                                <input type="text" placeholder="Due Amount"
                                                    class="form-control border-primary" name="due_amount" value="{{$payment['due_amount']}}" id="due_amount"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 row">
                                        <label class="col-md-3 label-control" for="payment_proof">Payment Proof</label>
                                        <div class="col-md-9">
                                            <input type="file" class="form-control border-primary" name="prof_image"
                                                id="prof_image" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-3 label-control" for="due_amount">Payment Proof</label>
                                            <div class="col-md-9">
                                                @if (isset($payment['prof_image']))
                                                <img src="{{ asset('proofs/' . $payment['prof_image']) }}" alt="Due Amount Image">
                                           
                                            @else
                                            <input type="text" class="form-control" value="Proof Not Added" disabled>
                                            @endif
                                                

                                            </div>
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
