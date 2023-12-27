    <aside class="main-sidebar main-sidebar-custom sidebar-light-primary elevation-4">
        <a href="/assets/dist/img/index3.html" class="brand-link">
            <img src="/assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">E-Learning</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/assets/dist/img/{{ (session('lvl') == 'Admin') ? 'computer-user-icon-16379.png' : ($user['jk'] == 'Laki-Laki' ? 'profile-icon-png-893.png' : 'profile-icon-png-912.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ (session('lvl') == 'Admin') ? strtoupper(session('username')) : $user['nama'] }}</a>
                </div>
            </div>

            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item mb-2">
                        <a href="./" class="nav-link {{ Request::is('/') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item mb-2" <?= (session('lvl') != 'Admin') ? 'style="display: none"' : '' ?>>
                        <a href="/ruang" class="nav-link {{ Request::is('ruang*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users-class"></i>
                            <p>Data Kelas</p>
                        </a>
                    </li>
                    <li class="nav-item mb-2" <?= (session('lvl') != 'Admin') ? 'style="display: none"' : '' ?>>
                        <a href="/siswa" class="nav-link {{ Request::is('siswa*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Siswa</p>
                        </a>
                    </li>
                    <li class="nav-item mb-2" <?= (session('lvl') != 'Admin') ? 'style="display: none"' : '' ?>>
                        <a href="/guru" class="nav-link {{ Request::is('guru*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>Data Guru</p>
                        </a>
                    </li>
                    <li class="nav-item mb-2" <?= (session('lvl') == 'Siswa' || session('lvl') == 'Guru') ? 'style="display: none"' : '' ?>>
                        <a href="/matpel" class="nav-link {{ Request::is('matpel*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>Data Mapel</p>
                        </a>
                    </li>
                    <li class="nav-item" <?= (session('lvl') == 'Admin') ? 'style="display: none"' : '' ?>>
                        <a href="/bahanajar" class="nav-link {{ Request::is('bahanajar*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-books"></i>
                            <p>Materi Belajar</p>
                        </a>
                    </li>
                    <li class="nav-item" <?= (session('lvl') == 'Admin') ? 'style="display: none"' : '' ?>>
                        <a href="/forum-diskusi" class="nav-link {{ Request::is('forum-diskusi*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-comments"></i>
                            <p>Forum Diskusi</p>
                        </a>
                    </li>
                    <li class="nav-item" <?= (session('lvl') != 'Admin') ? '' : 'style="display: none"' ?>>
                        <a href="/akun" class="nav-link {{ Request::is('akun*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>Pengaturan Akun</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="sidebar-custom">
            <!-- <a href="#" class="btn btn-link"><i class="fas fa-cogs"></i></a> -->
            <button class="btn btn-danger btn-flat btn-block rounded-3" onclick="window.location='/auth/logout'">Keluar</button>
        </div>
    </aside>