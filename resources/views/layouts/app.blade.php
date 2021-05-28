@include('layouts.header')
<!-- Begin page -->

@include('layouts.topbar')

<div class="wrapper ">
    <!-- Start content -->
    <div class="container-fluid ">
        <h4 class="page-title">{{$title}}</h4>
        @yield('content')
    </div>
</div>
@include('layouts.footer')