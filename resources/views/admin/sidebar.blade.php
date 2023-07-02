
<nav class="sidebar">
    <header>
        <div class="image-text">
            <span class="image">
                <!--<img src="logo.png" alt="">-->
            </span>

            <div class="text logo-text">
                <span class="name">PT AldengJaya</span>
                <span class="profession">Tugas UAS</span>
            </div>
            
        </div>
        <i class='d-none bx bx-chevron-right toggle'></i>
    </header>

    <div class="menu-bar">
        
        <div class="menu" >
            <li class="search-box d-none">
                <i class='bx bx-search icon'></i>
                <input type="text" placeholder="Search...">
            </li>

            <ul class="menu-links">
                <li class="nav-link {{ request()->is('admin') ? 'aktif' : '' }}">
                    <a href="/admin" >
                        <i class='bx bx-home-alt icon' ></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-link {{ request()->is('admin/karyawan*') ? 'aktif' : '' }}" >
                    <a href="/admin/karyawan">
                        <i class='bx bx-bar-chart-alt-2 icon' ></i>
                        <span class="text nav-text">Karyawan</span>
                    </a>
                </li>
                
                <li class="nav-link {{ Request::is('home/jabatans') ? 'aktif' : '' }}" >
                    <a href="/home/jabatans">
                        <i class='bx bx-bar-chart-alt-2 icon' ></i>
                        <span class="text nav-text">Jabatan</span>
                    </a>
                </li>


            </ul>
        </div>

        <div class="bottom-content">
            {{-- <li class="">
                <a href="#">
                    <i class='bx bx-log-out icon' ></i>
                    <span class="text nav-text">Logout</span>
                </a>
            </li> --}}

            <li class="mode">
                <div class="sun-moon">
                    <i class='bx bx-moon icon moon'></i>
                    <i class='bx bx-sun icon sun'></i>
                </div>
                <span class="mode-text text">Dark mode</span>

                <div class="toggle-switch">
                    <span class="switch"></span>
                </div>
            </li>
            
        </div>
    </div>

</nav>





