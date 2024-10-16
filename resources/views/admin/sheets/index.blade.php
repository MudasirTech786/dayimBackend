@extends('admin_layouts.master')


@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert.css') }}">
    <script src="{{ asset('app-assets/js/core/libraries/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var userId = {{ $user }};
            $('#link_table').DataTable({
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [0, 4]
                }],
                "bProcessing": true,
                "bServerSide": true,
                "aaSorting": [
                    [0, "desc"]
                ],
                "sPaginationType": "full_numbers",
                "aLengthMenu": [
                    [10, 50, 100, 500],
                    [10, 50, 100, 500]
                ],
                "sAjaxSource": `{{ url('get_sheets') }}/${userId}`,
                "searching": false
            });
        });
    </script>
@endsection
@section('content')
    @if (!auth()->user()->hasRole('Admin'))
        <div class="row">
            <div class="col-md-3">
                <div class="card " style="background-color: #cdcd23;">
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
                <div class="card bg-success ">
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
                <div class="card bg-danger ">
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
    @endif
    <div class="content-body">

        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Sheets Details</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-content collapse show ">
                            <div class="card-body card-dashboard ">
                                <p class="card-text"></p>
                                <div class="overflow-auto">
                                    <table class="table table-striped table-bordered zero-configuration data-table "
                                        id="link_table">
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
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@section('script')
    <script src="{{ asset('app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 2000);
    </script>
    @if (Session::get('success'))
        <script>
            $(document).ready(function() {
                toastr.success('<?php echo Session::get('success'); ?>', 'Zindawork Says', {
                    timeOut: 2000
                })
            });
        </script>
    @endif
@endsection
