@extends('admin_layouts.master')
@section('style')
    <style>
        .table-responsive {
            max-height: 200px;
            /* Set max height for table */
            overflow-y: auto;
            /* Enable vertical scrolling */
        }

        .table-responsive thead th,
        .table-responsive tbody td {
            white-space: nowrap;
            /* Prevent text wrapping */
        }

        .custom-input {
            width: 200px;
        }
    </style>
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
                            <div class="container">
                                <button id="addRecordBtn" class="btn btn-primary mb-3">Add New Record</button>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Pay Head</th>
                                                <th>Due Date</th>
                                                <th>Due Amount</th>
                                                <th>Deposit Date</th>
                                                <th>Mode</th>
                                                <th>Receipt Number</th>
                                                <th>Paid Amount</th>
                                                <th>Amount</th>
                                                <th>Surcharge</th>
                                                <th>Payment Received</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recordsBody">
                                            <tr>
                                                <td><input type="text" class="form-control custom-input" id="pay_head"
                                                        name="pay_head"></td>
                                                <td><input type="date" class="form-control custom-input" id="due_date"
                                                        name="due_date"></td>
                                                <td><input type="text" class="form-control custom-input" id="due_amount"
                                                        name="due_amount"></td>
                                                <td><input type="date" class="form-control custom-input"
                                                        id="deposit_date" name="deposit_date"></td>
                                                <td><input type="text" class="form-control custom-input" id="mode"
                                                        name="mode"></td>
                                                <td><input type="text" class="form-control custom-input"
                                                        id="receipt_number" name="receipt_number"></td>
                                                <td><input type="text" class="form-control custom-input" id="paid_amount"
                                                        name="paid_amount"></td>
                                                <td><input type="text" class="form-control custom-input" id="amount"
                                                        name="amount"></td>
                                                <td><input type="text" class="form-control custom-input" id="surcharge"
                                                        name="surcharge"></td>
                                                <td><input type="text" class="form-control custom-input"
                                                        id="payment_received" name="payment_received"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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
    <script>
        $(document).ready(function() {
            $('#addRecordBtn').click(function() {
                var newRow = '<tr>' +
                    '<td><input type="text" class="form-control custom-input" name="pay_head"></td>' +
                    '<td><input type="date" class="form-control custom-input" name="due_date"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="due_amount"></td>' +
                    '<td><input type="date" class="form-control custom-input" name="deposit_date"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="mode"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="receipt_number"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="paid_amount"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="amount"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="surcharge"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="payment_received"></td>' +
                    '</tr>';
                $('#recordsBody').append(newRow);
                $(this).hide(); // Hide the button after adding a new record
            });
        });
    </script>
@endsection
