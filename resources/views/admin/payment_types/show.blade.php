@extends('admin_layouts.master')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/extensions/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/vendors/css/forms/selects/select2.min.css') }}">
    <script src="{{ asset('app-assets/js/core/libraries/jquery.min.js') }}"></script>
    <style>
        /* Custom styles for the image modal */
        .modal-img {
            max-width: 100%;
            max-height: 100vh;
        }

        .modal-img {
            width: auto;
            /* Allow the width to scale */
            height: auto;
            /* Allow the height to scale */
            max-width: 90vw;
            /* Set max width to 90% of viewport width */
            max-height: 90vh;
            /* Set max height to 90% of viewport height */
        }
    </style>
@endsection

@section('content')
    <div class="content-body">
        <section id="payment-details">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Payment Details</h4>
                            <div class="heading-elements">
                                <a class="btn btn-primary btn-sm" href="{{ route('payment.index') }}">Back to Payments</a>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>User Name:</strong>
                                            <p class="form-control-static">{{ $paymentType->user->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong>Product Name:</strong>
                                            <p class="form-control-static">{{ $paymentType->product->name }}</p>
                                        </div>
                                    </div>
                                    @if ($paymentType->cash == 'yes')
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Type:</strong>
                                                <p class="form-control-static">Cash Payment</p>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <strong>Type:</strong>
                                                <p class="form-control-static">Online Payment</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <div class="form-group">
                                            <strong>Image:</strong><br>
                                            @if ($paymentType->image)
                                                <img src="{{ asset('storage/' . $paymentType->image) }}" alt="Payment Image"
                                                    class="img-fluid"
                                                    style="max-height: 300px; object-fit: cover; cursor: pointer;"
                                                    data-toggle="modal" data-target="#imageModal">
                                            @else
                                                <span class="text-muted">No image available</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Image Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Payment Image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($paymentType->image)
                            <img src="{{ asset('storage/' . $paymentType->image) }}" alt="Payment Image" class="modal-img">
                        @else
                            <span class="text-muted">No image available</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
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
                toastr.success('<?php echo Session::get('success'); ?>', 'Fastline Says', {
                    timeOut: 2000
                })
            });
        </script>
    @endif
@endsection
