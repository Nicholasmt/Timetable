<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="site_url" content="{{url('')}}">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title> {{"TimeTable "}} @yield('title') </title>

    <link rel="shortcut icon" type="image/png" href="{{ asset ('assets/image/main_logo.png') }}">
    <link href="{{ asset('assets/css/css/custom_app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/css/custom_style.css') }}" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    {{-- <link rel="stylesheet" href="{!! asset('assets/css/bootstrap.min.css') !!}" /> --}}
    <link rel="stylesheet" href="{!! asset('assets/css/vendor.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/app.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/font-awesome/css/font-awesome.css') !!}" />
    <link rel="stylesheet" href="{!! asset('assets/css/modal-css.css') !!}" />


    @if(isset($css) && ! empty($css))
      @foreach($css as $css_files)
      <link rel="stylesheet" href="{!! asset('assets/'.$css_files) !!}" />
      @endforeach
    @endif

</head>
<body>

 @yield('body')


</body>
</html>
