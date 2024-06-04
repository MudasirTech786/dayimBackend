@extends('admin_layouts.master')


@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-success ">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="card-title text-white font-medium-3">Welcome To</h2>
                        <h5 class="text-white font-small-3">Dayim Marketing</h5>
                    </div>
                    <img src="{{ asset('images/dashboard/icon1.png') }}" style="height: 60px">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info ">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="card-title text-white font-medium-3">{{ $totalBookings }}</h2>
                        <h5 class="text-white font-small-3">Booking</h5>
                    </div>
                    <img src="{{ asset('images/dashboard/icon2.png') }}" style="height: 50px">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger ">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="card-title text-white font-medium-3">{{ number_format($totalReceived) }}</h2>
                        <h5 class="text-white font-small-3">received</h5>
                    </div>
                    <img src="{{ asset('images/dashboard/icon3.png') }}" style="height: 60px">
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary ">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h2 class="card-title text-white font-medium-3">{{ number_format($totalBalance) }}</h2>
                        <h5 class="text-white font-small-3">Pending Balance</h5>
                    </div>
                    <img src="{{ asset('images/dashboard/icon4.png') }}" style="height: 50px">
                </div>
            </div>
        </div>

    </div>
    <table id="dataTable" class="display" style="">
        <thead>
            <tr>
                <th>Registration Number</th>
                <th>Property Code</th>
                <th>Total Price</th>
                <th>Paid Amount</th>
                <th>Outstanding Balance</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sheets as $key => $item)
                <tr>
                    <td>{{ $item['registrationNumber'] }}</td>
                    <td>{{ $item['productCode'] }}</td>
                    <td>{{ $item['totalPrice'] }}</td>
                    <td>{{ number_format($item['paidAmount']) }}</td>
                    <td>{{ number_format($item['outstandingBalance']) }}</td>
                    <td><a href="{{ url('sheet/' . $key) }}" class="" style="">
                            View Statement
                        </a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>
@endsection
