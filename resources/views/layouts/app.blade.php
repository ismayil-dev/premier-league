<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Premier League Simulation</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container pb-5">
    @yield('content')
</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js')}}"></script>
<script>
    window.CSRF_TOKEN = '{{ csrf_token() }}';
</script>
@stack('page-script')
</body>
</html>
