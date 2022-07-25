@extends('layouts.app')
@section('body')


<!-- Wrapper-->
<div id="wrapper">

    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page wraper -->
    <div id="page-wrapper" class="gray-bg">

        <!-- Page wrapper -->
        @include('layouts.topnavbar')

        @include('layouts.error')

        <!-- Main view  -->
        @yield('content')

        <!-- Footer -->
        @include('layouts.footer')

    </div>
    <!-- End page wrapper-->

</div>
<!-- End wrapper-->

<script src="{!! asset('assets/js/app.js') !!}" type="text/javascript"></script>
@if(isset($js) && ! empty($js))
@foreach($js as $js_files)
 <script src="{!! asset('assets/'.$js_files) !!}" type="text/javascript"></script>
@endforeach
@endif

@section('scripts')
@show
@endsection
