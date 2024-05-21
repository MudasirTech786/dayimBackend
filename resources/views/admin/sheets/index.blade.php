@extends('admin_layouts.master')


@section('style')
@endsection
@section('content')
    {{-- <div class="content-body">
        <section id="configuration">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="la la-cars"></i>
                            <h4 class="card-title">Events</h4>
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
    </div> --}}
    @if ($sheets->isEmpty())
        <p>No sheets found.</p>
    @else
    <?php $i=1; ?>
    <div class="shadow-lg d-flex text-center justify-center space-x-3">
        @foreach ($sheets as $sheet)
        <a href="{{ url('sheet/' . $sheet->sheet_no) }}"
        class="bg-white p-5  text-center mr-3 custom-sheet-link" style="width: 250px">
        <h3>Inventroy # {{$i}}</h3><br>
            <h5>Sheet Number: <b>{{ $sheet->sheet_no }}</b></h5>
            <h5>Invenory Name: <b>{{ $sheet->inventory_name  }}</b></h5>
            <h5>Form Number: <b>{{ $sheet->form_no  }}</b></h5>
        </a>
        <?php $i++; ?>
        @endforeach
        {{-- <a href="{{ url('sheet/') }}"
            class="bg-white p-5  text-center mr-3 custom-sheet-link" style="width: 250px">
            <h5>Inventory 2</h5>
        </a> --}}
    </div>
    @endif
@endsection


@section('script')
@endsection
