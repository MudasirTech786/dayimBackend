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
            background-color: #f0f0f0;
        }

        .pdfHeader2 {
            font-weight: bold;
            text-align: left;
            background-color: #d0d0d0;
        }

        .pdfDataRows {
            text-align: left;
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
            @foreach ($data['values'] as $key => $row)
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
                    @elseif($key == 3 || $key == 4)
                        @foreach ($row as $cell)
                            @if ($cell !== '')
                                <td colspan="2" class="pdfTableHeaderBold">{{ $cell }}
                                </td>
                            @endif
                        @endforeach
                    @elseif($key == 5)
                        @foreach ($row as $cell)
                            @if ($cell !== '')
                                <td colspan="2" class="pdfTableHeaderBold">{{ $cell }}
                                </td>
                            @endif
                        @endforeach
                        <td colspan="2" class="pdfTableHeaderBold"></td>
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
</body>

</html>
