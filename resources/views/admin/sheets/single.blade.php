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
                            <i class="la la-cars"></i>
                            <h4 class="card-title">Details</h4>
                            <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>

                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-responsive table-striped">
                                    @foreach ($data['values'] as $key => $row)
                                        <tr>
                                            @if ($key === 0)
                                                <td colspan="10">{{ $row[0] }}</td>
                                            @else
                                                @foreach (array_pad($row, 10, '') as $cell)
                                                    <td>{{ $cell }}</td>
                                                @endforeach
                                            @endif
                                        </tr>
                                    @endforeach
                                </table>

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
