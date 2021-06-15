<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @include('layouts.theme.styles')

</head>
<body class="loading">
    <!-- Begin page -->
    <div class="wrapper">
        @include('layouts.theme.partials.left-sidebar')

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                @include('layouts.theme.partials.topbar')

                <!-- Start Content-->
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            @include('layouts.theme.partials.footer')

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    @include('layouts.theme.partials.right-sidebar')

    @include('layouts.theme.scripts')
</body>

</html>
