@extends('admin_layouts.master')

@section('style')
@endsection

@section('content')
    <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="la la-file"></i>
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="card-title">No Sheets Available</h4>
                            </div>
                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body">
                                <div class="alert alert-info text-center">
                                    <h5>You don't have any sheets yet.</h5>
                                    <p>Once sheets are added, you will be able to view them here.</p>
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
@endsection
