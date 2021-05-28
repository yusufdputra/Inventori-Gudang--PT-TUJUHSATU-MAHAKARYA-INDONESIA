<!-- Top Bar End -->
<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <a href="#" class="logo">
                <span class="logo-small"><i class="mdi mdi-radar"></i></span>
                <span class="logo-large"><i class="mdi mdi-radar"></i> Inventori GUDANG</span>
                </a>
                <!-- Image Logo -->
                <!-- <a href="#" class="logo">
                    <img src="{{asset('adminto/images/logo-sm.png')}}" alt="" height="26" class="logo-small">
                    <img src="{{asset('adminto/images/logo.png')}}" alt="" height="24" class="logo-large">
                </a> -->
            </div>
            <!-- End Logo container-->

            <div class="menu-extras topbar-custom">

                <ul class="list-unstyled topbar-right-menu float-right mb-0">

                    <li class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{asset('adminto/images/users/avatar-1.jpg')}}" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ti-user m-r-5"></i> {{ Auth::user()->nama }}
                            </a>


                            <!-- item-->
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                <i class="ti-power-off m-r-5"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>

                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->

    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li class="has-submenu">
                        <a href="{{('/')}}" class="waves-effect"><i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span> </a>
                    </li>

                    @role('admin')

                    <li class="has-submenu">
                        <a href="javascript:void(0);" class="waves-effect"><i class=" mdi mdi-account-multiple"></i> <span> Management User </span></a>
                        <ul class="submenu">
                            <li><a href="{{route ('user.index', 'pimpinan')}}">Pimpinan</a></li>
                            <li><a href="{{route ('user.index', 'pegawai')}}">Pegawai</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="{{route ('kategori.index')}}" class="waves-effect"><i class="mdi mdi-bulletin-board"></i> <span> Kategori </span> </a>
                    </li>

                    @endrole


                    @role('admin|pegawai|pimpinan')

                    <li class="has-submenu">
                        <a href="{{route ('barang.index')}}" class="waves-effect"><i class="mdi mdi-package-variant-closed"></i> <span> Barang </span> </a>
                    </li>

                    <li class="has-submenu">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-cube-send"></i> <span> Transaksi Barang</span></a>
                        <ul class="submenu">
                            <li><a href="{{route ('peminjaman.index')}}">Peminjaman</a></li>
                            <li><a href="{{route ('pengembalian.index')}}">Pengembalian</a></li>
                        </ul>
                    </li>

                    <li class="has-submenu">
                        <a href="{{route ('restok.index')}}" class="waves-effect"><i class="mdi mdi-basket-fill"></i> <span> Restok </span> </a>
                    </li>

                    @endrole

                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
<!-- End Navigation Bar-->

<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                2021 © PT TUJUHSATU MAHAKARYA INDONESIA
            </div>
        </div>
    </div>
</footer>