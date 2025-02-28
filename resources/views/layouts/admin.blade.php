<!DOCTYPE html>
<html lang="en">
<!-- START: Head-->
@include('inc.header')
<!-- END Head-->

<!-- START: Body-->

<body id="main-container" class="default">
    <!-- START: Pre Loader-->
    <div class="se-pre-con">
        <div class="loader"></div>
    </div>
    <!-- END: Pre Loader-->

    <!-- START: Header-->
    @include('inc.navbar')
    <!-- END: Header-->

    <!-- START: Main Menu-->
    @include('inc.sidebar')
    <!-- END: Main Menu-->

    <!-- START: Main Content-->
    <main>
        <div class="container-fluid site-width">
            <!-- START: Breadcrumbs-->
            @include('inc.breadcrum')
            <!-- END: Breadcrumbs-->

            <!-- START: Card Data-->
            <div id="app" class="pb-5">
                @yield('content')
            </div>

            <!-- END: Card DATA-->
        </div>
    </main>
    <!-- END: Content-->
    <script>
        @auth
          window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
        @else
          window.Permissions = [];
        @endauth
    </script>

    <!-- START: Footer-->
    @extends('inc.footer')
    <!-- END: Footer-->


    <!-- START: Back to top-->
    <a href="#" class="scrollup text-center">
        <i class="icon-arrow-up"></i>
    </a>
    <!-- END: Back to top-->

    @include('inc.scripts')
</body>
<!-- END: Body-->

</html>
