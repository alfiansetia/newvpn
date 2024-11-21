@php
    function getx($profile, $profiles)
    {
        $profile = collect($profiles)->where('name', $profile)->first();
        if (!$profile) {
            return 0;
        }
        if ($profile['mikhmon']) {
            return $profile['mikhmon']['selling_price'];
        } else {
            return 0;
        }
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            color: #000000;
            background-color: #FFFFFF;
            font-size: 14px;
            font-family: 'Helvetica', arial, sans-serif;
            margin: 0px;
            -webkit-print-color-adjust: exact;
        }

        table.voucher {
            display: inline-block;
            border: 2px solid black;
            margin: 2px;
        }

        @page {
            size: auto;
            margin-left: 7mm;
            margin-right: 3mm;
            margin-top: 9mm;
            margin-bottom: 3mm;
        }

        @media print {
            table {
                page-break-after: auto
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto
            }

            td {
                page-break-inside: avoid;
                page-break-after: auto
            }

            thead {
                display: table-header-group
            }

            tfoot {
                display: table-footer-group
            }
        }

        #num {
            float: right;
            display: inline-block;
        }

        .qrc {
            width: 30px;
            height: 30px;
            margin-top: 1px;
        }
    </style>
</head>

<body>
    @php
        $key = 0;
    @endphp

    @foreach ($data as $item)
        @php
            $key = $key + 1;
            $param = [
                $item['name'],
                $item['password'] ?? '',
                hrg(getx($item['profile'] ?? '', $profiles)),
                $item['limit-uptime'] ?? '',
                $item['limit-uptime'] ?? '',
                $item['limit_byte_total_parse'] ?? '',
                $template->qr,
                url('/images/default/logo.svg'),
                $router->dnsname,
                $router->contact,
                $key,
            ];
        @endphp
        @if ($mode == 'vc')
            {!! $template->generate_vc($param) !!}
        @else
            {!! $template->generate_up($param) !!}
        @endif
    @endforeach
</body>

</html>
