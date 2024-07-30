<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-bordered {
            /* border: 1px solid #000; */
        }

        .table-bordered td {
            border: 1px solid #000;
        }

        .pdfTableHeaderBold {
            font-weight: bold;
            text-align: center;
            /* background-color: #f0f0f0; */
            background-color: white;
        }

        .pdfHeader2 {
            font-weight: bolder;
            text-align: left;
            background-color: #5b9bd4;
            color: white;
            font-size: 10px;
        }

        .pdfDataRows {
            text-align: left;
            font-size: 10px;
        }

        .table-responsive {
            /* display: block; */
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div style="">
        <table class="table table-responsive table-bordered">
            <tr>
                <td colspan="2" class="pdfTableHeaderBold">
                    <img src="{{ asset('images/dsa_logo_report.png') }}" height="100" width="100"
                        style="object-fit: contain" />
                </td>
                <td colspan="8" class="pdfTableHeaderBold" style="font-size: 22px; font-weight:900">DAYIM MARKETING
                    AND DEVELOPERS
                </td>
            </tr>
            <tr>
                <td class="pdfTableHeaderBold" colspan="10">
                    <span style="font-size: 20px; font-weight:900">Statement</span>
                </td>
            </tr>
            @foreach ($data['values'] as $key => $row)
                @php
                    // Check if all cells in the row are empty
                    $allCellsEmpty = true;
                    foreach ($row as $cell) {
                        if (trim($cell) !== '') {
                            $allCellsEmpty = false;
                            break;
                        }
                    }
                @endphp

                @if (!$allCellsEmpty)
                    <tr>
                        @if ($key === 0 || $key === 1)
                            {{-- do nothing --}}
                        @elseif($key == 2)
                            @foreach ($row as $cell)
                                @if ($cell !== '')
                                    @if (trim($cell) === 'Active')
                                        <td colspan="2" rowspan="2" class="pdfTableHeaderBold" style="">
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
                                    <td colspan="2" class="pdfTableHeaderBold">{{ $cell }}</td>
                                @endif
                            @endforeach
                        @elseif($key == 4)
                            @php $i = 1; @endphp
                            @foreach ($row as $cell)
                                @if ($cell !== '' && $i == 3)
                                    <td colspan="2" rowspan="2" class="pdfTableHeaderBold">
                                        {{ $cell }}
                                    </td>
                                    @php $i++; @endphp
                                @elseif ($cell !== '' && $i != 3)
                                    <td colspan="2" class="pdfTableHeaderBold">
                                        {{ $cell }}
                                    </td>
                                    @php $i++; @endphp
                                @endif
                            @endforeach
                        @elseif($key == 5)
                            @foreach ($row as $cell)
                                @if ($cell !== '')
                                    @if (trim($cell) === 'Product Code')
                                        <td colspan="2" class="pdfTableHeaderBold">
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
                                        <td colspan="4" class="pdfTableHeaderBold">{{ $cell }}</td>
                                    @else
                                        <td colspan="2" class="pdfTableHeaderBold">{{ $cell }}</td>
                                    @endif
                                @endif
                            @endforeach
                        @elseif($key == 7)
                            @foreach ($row as $cell)
                                @if ($cell !== '')
                                    <td class="pdfHeader2">{{ $cell }}</td>
                                @endif
                            @endforeach
                        @elseif($key >= 50)
                            {{-- this is for removing the empty lines between 50 onwards --}}
                        @else
                            @foreach (array_pad($row, 10, '') as $cell)
                                <td class="pdfDataRows">{{ $cell }}</td>
                            @endforeach
                        @endif
                    </tr>
                @endif
            @endforeach
        </table>
    </div>
</body>

</html>
