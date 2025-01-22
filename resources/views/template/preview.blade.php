<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    {!! $data->header !!}
</head>

<body>

    <h2>VOUCHER MODE</h2>
    {!! $data->sample_vc() !!}
    <h2>USER MODE</h2>
    {!! $data->sample_up() !!}

    {!! $data->footer !!}

</body>

</html>
