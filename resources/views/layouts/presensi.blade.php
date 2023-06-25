<!doctype html>
<html lang="en">

@include('layouts.head')

<body style="background-color:#e9ecef;">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    

    <!-- App Capsule -->
    <div id="appCapsule">
        @yield('header')
        @yield('content')
    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
@include('layouts.bottomnav')
    <!-- * App Bottom Menu -->

@include('layouts.script')

</body>

</html>