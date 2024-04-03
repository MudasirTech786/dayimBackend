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
                        <form class="form form-horizontal" method="POST" action="{{ route('payments.store') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="container">
                                <button type="button" id="addRecordBtn" class="btn btn-primary mb-3">Add New
                                    Record</button>
                                <input type="text" class="form-control custom-input" id="pay_head" name="booking_id"
                                    value="{{ $bookingid }}" hidden></td>
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
                                                <th>surchange</th>
                                                <th>Payment Received</th>
                                            </tr>
                                        </thead>
                                        <tbody id="recordsBody">
                                            @foreach ($sales as $sale)
                                                <tr>
                                                    <td><input type="text" class="form-control custom-input"
                                                            id="pay_head" name="pay_head[]"
                                                            value="{{ $sale['pay_head'] }}">
                                                        <input type="text" name="id[]" value="{{ $sale['id'] }}"
                                                            hidden>
                                                    </td>

                                                    </td>
                                                    <td><input type="date" class="form-control custom-input"
                                                            id="due_date" name="due_date[]"
                                                            value="{{ $sale['due_date'] }}">
                                                    </td>
                                                    <td><input type="text" class="form-control custom-input"
                                                            id="due_amount" name="due_amount[]"
                                                            value="{{ $sale['due_amount'] }}"></td>
                                                    <td><input type="date" class="form-control custom-input"
                                                            id="deposite_date" name="deposite_date[]"
                                                            value="{{ $sale['deposit_date'] }}"></td>
                                                    <td><input type="text" class="form-control custom-input"
                                                            id="mode" name="mode[]" value="{{ $sale['mode'] }}"></td>
                                                    <td><input type="text" class="form-control custom-input"
                                                            id="receipt" name="receipt[]" value="{{ $sale['receipt'] }}">
                                                    </td>
                                                    <td><input type="text" class="form-control custom-input"
                                                            id="paid_amount" name="paid_amount[]"
                                                            value="{{ $sale['paid_amount'] }}"></td>
                                                    <td><input type="text" class="form-control custom-input"
                                                            id="amount" name="amount[]" value="{{ $sale['amount'] }}">
                                                    </td>
                                                    <td><input type="text" class="form-control custom-input"
                                                            id="surchange" name="surchange[]"
                                                            value="{{ $sale['surchange'] }}"></td>
                                                    <td>
                                                        <button class="btn btn-primary">Save</button>
                                                        <button class="btn btn-danger delete-btn" type="button"
                                                            data-id="{{ $sale['id'] }}">Delete</button>
                                                        <button class="btn btn-success complete-btn" type="button"
                                                            data-id="{{ $sale['id'] }}">Complete</button>
                                                    </td>
                                                </tr>
                                            @endforeach
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

            $('#addRecordBtn').click(function(e) {
                e.preventDefault();
                var newRow = '<tr>' +
                    '<td><input type="text" class="form-control custom-input" name="pay_head[]"><input type="text" name="id[]" value="" hidden></td>' +
                    '<td><input type="date" class="form-control custom-input" name="due_date[]"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="due_amount[]"></td>' +
                    '<td><input type="date" class="form-control custom-input" name="deposite_date[]"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="mode[]"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="receipt[]"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="paid_amount[]"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="amount[]"></td>' +
                    '<td><input type="text" class="form-control custom-input" name="surchange[]"></td>' +
                    '<td><button class="btn btn-primary">Save</button>'
                '</tr>';
                $('#recordsBody').append(newRow);
                // $(this).hide(); // Hide the button after adding a new record
            });
        });


        $('.save-btn').click(function() {
            // Perform save action here
        });

        $('.delete-btn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete this payment plan?")) {
                $.ajax({
                    url: '{{ route('payments.destroy', '') }}/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            window.location.href = '{{ route('bookings.index') }}';
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error response
                    }
                });
            }
        });

        $('.complete-btn').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $.ajax({
                url: '/complete/' + id,
                method: 'POST',
                success: function(response) {
                    // Handle success response
                },
                error: function(xhr, status, error) {
                    // Handle error response
                }
            });
        });
    </script>
@endsection
