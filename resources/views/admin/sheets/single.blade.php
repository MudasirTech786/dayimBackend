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
                            <div class="d-flex align-items-center justify-content-between">
                                <h4 class="card-title">Statement</h4>
                                <form id="" action="{{ route('download.pdf', $id) }}" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Download</button>
                                </form>
                            </div>

                            {{-- <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a> --}}

                        </div>
                        <div class="card-content collapse show">
                            <div class="card-body card-dashboard">
                                <table class="table table-responsive table-bordered">
                                    @foreach ($data['values'] as $key => $row)
                                        <tr>
                                            @if ($key === 0 || $key === 1)
                                                {{-- do nothing --}}
                                            @elseif($key == 2)
                                                @foreach ($row as $cell)
                                                    @if ($cell !== '')
                                                        @if (trim($cell) === 'Active')
                                                            <td colspan="2" rowspan="2" class="pdfTableHeaderBold"
                                                                style="">
                                                                {{ trim($cell) }}
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="pdfTableHeaderBold">
                                                                {{ trim($cell) }}
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @elseif($key == 3)
                                                @foreach ($row as $cell)
                                                    @if ($cell !== '')
                                                        <td colspan="2" class="pdfTableHeaderBold">{{ $cell }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @elseif($key == 4)
                                                @foreach ($row as $cell)
                                                    @if ($cell !== '')
                                                        <td colspan="2" class="pdfTableHeaderBold">{{ $cell }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @elseif($key == 5)
                                                @foreach ($row as $cell)
                                                    @if ($cell !== '')
                                                        @if (trim($cell) === 'Product Code')
                                                            <td colspan="4" class="pdfTableHeaderBold">
                                                                {{ $cell }}
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="pdfTableHeaderBold">
                                                                {{ $cell }}
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @elseif($key == 6)
                                                @foreach ($row as $cell)
                                                    @if ($cell !== '')
                                                        @if (trim($cell) === 'Receipt Details')
                                                            <td colspan="4" class="pdfTableHeaderBold">
                                                                {{ $cell }}
                                                            </td>
                                                        @else
                                                            <td colspan="2" class="pdfTableHeaderBold">
                                                                {{ $cell }}
                                                            </td>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @elseif($key == 7)
                                                @foreach ($row as $cell)
                                                    @if ($cell !== '')
                                                        <td class="pdfHeader2">
                                                            {{ $cell }}
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @else
                                                @foreach (array_pad($row, 10, '') as $cell)
                                                    <td class="pdfDataRows">{{ $cell }}</td>
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
