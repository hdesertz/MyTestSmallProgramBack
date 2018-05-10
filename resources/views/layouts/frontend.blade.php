<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="author" content="{{config("app.name")}}">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}" >
    <title>{{config("app.name")}}</title>
    <base href="/" />
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap/4.1.0/css/bootstrap.min.css">
    @yield('style')
</head>

<body>
@yield('content')
<script src="https://cdn.bootcss.com/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
<script src="vendor/layer/layer.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dateType:"json"
    });
</script>
@yield('script')

</body>
</html>