<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/default/favicon.ico') }}">
    <title>Document</title>
    {!! $template->header !!}
    <script src="{{ asset('js/qrious.min.js') }}"></script>
</head>

<body onload="window.print()">
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
                "id='" . $item['name'] . "'",
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

    {!! $template->footer !!}
</body>


@foreach ($data as $item)
    <script>
        (function() {
            let qr = new QRious({
                value: "http://{{ $router->dnsname }}/login?username={{ $item['name'] }}&password={{ $item['password'] }}"
            });
            let url = qr.toDataURL();
            document.getElementById('{{ $item['name'] }}').src = url
        })
        ();
    </script>
@endforeach

</html>
