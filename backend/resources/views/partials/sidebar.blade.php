<nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
    <div class="scrollbar-inner">
        <!-- Brand -->
        <div class="sidenav-header  align-items-center">
            <a class="navbar-brand" href="/">
                <h1 class="fw-900">E-Voting </h1>
            </a>
        </div>
        <div class="navbar-inner">
            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Nav items -->
                <ul class="navbar-nav">


                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="ni ni-tv-2 text-primary"></i>
                            <span class="nav-link-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('pemilihan') ? 'active' : '' }}"
                            href="{{ route('pemilihan') }}">
                            <i class="ni ni-circle-08 text-info"></i>
                            <span class="nav-link-text">Pemilihan</span>
                        </a>
                    </li>
                    @if (Auth::user()->role == 'Admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('kandidat') ? 'active' : '' }}"
                                href="{{ route('kandidat') }}">
                                <i class="ni ni-diamond text-success"></i>
                                <span class="nav-link-text">Kandidat</span>
                            </a>
                        </li>
                    @endif
                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}"
                            href="{{ route('dashboard') }}">
                            <i class="ni ni-controller text-warning"></i>
                            <span class="nav-link-text">Peserta</span>
                        </a>
                    </li> --}}


                </ul>
                <!-- Divider -->


            </div>
        </div>
    </div>
</nav>
