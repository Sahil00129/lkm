<!DOCTYPE html>
<html lang="en">
<!-- START: Head-->

<head>
    <title>Chabra | {{$title ?? ''}} </title>
    @include('include.header')
</head>
<!-- START: Body-->

<body id="main-container" class="default">

    <!-- START: Pre Loader-->
    <div class="se-pre-con">
        <div class="loader"></div>
    </div>
    <!-- END: Pre Loader-->
    <!-- START: Header-->
    <div id="header-fix" class="header fixed-top">
    @include('include.navbar')
    </div>
    <!-- END: Header-->
    <!-- START: Main Menu-->
    <div class="sidebar">
    @include('include.sidebar')
    </div>
    <!-- END: Main Menu-->
            <!-- START: Main Content-->
            <main>
            @yield('content')

            </main>
        <!-- END: Content-->
        @include('include.footer')

        </body>
    <!-- END: Body-->
</html>