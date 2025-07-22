<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="/">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">St</a>
        </div>
        @if (Auth::user()->role == 'admin')
            <ul class="sidebar-menu">
                <li class="menu-header">Dashboard</li>
                <li class="nav-item dropdown {{ $menu == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"><i
                            class="fas fa-fire"></i><span>Dashboard</span></a>
                    {{-- <ul class="dropdown-menu">
                    <li class="{{ Request::is('dashboard/general') ? 'active' : '' }}"><a class="nav-link"
                            href="{{ route('dashboard.general') }}">General Dashboard</a></li>
                </ul> --}}
                </li>

                <li class="menu-header">Master</li>
                <li class="nav-item dropdown {{ $menu == 'karyawan' ? 'active' : '' }}">
                    <a href="{{ route('admin.karyawan.index') }}" class="nav-link"><i class="fas fa-users"></i>
                        <span>Karyawan</span></a>
                </li>
                <li class="nav-item dropdown {{ $menu == 'shift' ? 'active' : '' }}">
                    <a href="{{ route('admin.shift.index') }}" class="nav-link"><i class="fas fa-calendar-alt"></i>
                        <span>Shift</span></a>
                </li>
                {{-- <li class="nav-item dropdown {{ $menu == 'presensi' ? 'active' : '' }}">
                    <a href="{{ route('admin.presensi.index') }}" class="nav-link"><i class="fas fa-clock"></i>
                        <span>Presensi</span></a>
                </li> --}}
                <li class="nav-item dropdown {{ $menu == 'cuti' ? 'active' : '' }}">
                    <a href="{{ route('admin.cuti.index') }}" class="nav-link"><i class="fas fa-plane-departure"></i>
                        <span>Cuti</span></a>
                </li>
                <li class="nav-item dropdown {{ $menu == 'gaji' ? 'active' : '' }}">
                    <a href="{{ route('admin.gaji.index') }}" class="nav-link"><i class="fas fa-money-bill-wave"></i>
                        <span>Gaji</span></a>
                </li>
                {{-- <li class="nav-item dropdown {{ $menu == 'kinerja' ? 'active' : '' }}">
                    <a href="{{ route('admin.kinerja.index') }}" class="nav-link"><i class="fas fa-chart-line"></i>
                        <span>Kinerja</span></a>
                </li> --}}
                <li class="menu-header">Pengaturan</li>
                <li class="nav-item dropdown {{ $menu == 'rulegaji' ? 'active' : '' }}">
                    <a href="{{ route('admin.rule-gaji.index') }}" class="nav-link"><i class="fas fa-cogs"></i>
                        <span>Rule Gaji</span></a>
                </li>
                <li class="nav-item dropdown {{ $menu == 'ruleshift' ? 'active' : '' }}">
                    <a href="{{ route('admin.rule-shift.index') }}" class="nav-link"><i
                            class="fas fa-balance-scale"></i>
                        <span>Rule Shift</span></a>
                </li>
            </ul>
        @elseif (Auth::user()->role == 'karyawan')
            <ul class="sidebar-menu">
                <li class="menu-header">Menu Karyawan</li>
                <li class="nav-item {{ $menu == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}" class="nav-link"><i
                            class="fas fa-fire"></i><span>Dashboard</span></a>
                </li>
                <li class="nav-item {{ $menu == 'shift' ? 'active' : '' }}">
                    <a href="{{ route('user.shift') }}" class="nav-link"><i class="fas fa-calendar-alt"></i><span>Shift
                            Saya</span></a>
                </li>
                <li class="nav-item {{ $menu == 'cuti' ? 'active' : '' }}">
                    <a href="{{ route('user.cuti') }}" class="nav-link"><i
                            class="fas fa-plane-departure"></i><span>Cuti Saya</span></a>
                </li>
                <li class="nav-item {{ $menu == 'gaji' ? 'active' : '' }}">
                    <a href="{{ route('user.gaji') }}" class="nav-link"><i
                            class="fas fa-money-bill-wave"></i><span>Gaji Saya</span></a>
                </li>
            </ul>
        @endif

        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ route('logout') }}" class="btn btn-danger btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Logout
            </a>
        </div>
    </aside>
</div>
