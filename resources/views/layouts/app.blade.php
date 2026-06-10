<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'E-Monitoring Pajak Air Tanah')</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />
</head>

<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo-section" style="margin: auto; text-align: center; margin-bottom: 5px;">
                    <h2 style="font-size: 20px">E-MONITORING<br>PAJAK AIR TANAH</h2>
                </div>
            </div>

            <nav class="sidebar-menu">
                <a href="{{ route('dashboard') }}"
                    class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-menu="dashboard">
                    <span>DASHBOARD</span>
                </a>
                <a href="{{ route('wajib-pajak.index') }}"
                    class="menu-item {{ request()->routeIs('wajib-pajak.*') ? 'active' : '' }}" data-menu="wajib-pajak">
                    <span>WAJIB PAJAK AIR TANAH</span>
                </a>
                <a href="{{ route('pengawasan.index') }}"
                    class="menu-item {{ request()->routeIs('pengawasan.*') ? 'active' : '' }}" data-menu="pengawasan">
                    <span>PENGAWASAN PAJAK AIR TANAH</span>
                </a>
                <a href="{{ route('status-pengawasan.index') }}"
                    class="menu-item {{ request()->routeIs('status-pengawasan.*') ? 'active' : '' }}"
                    data-menu="status-pengawasan">
                    <span>STATUS PENGAWASAN PAJAK AIR TANAH</span>
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="{{ route('logout') }}" class="logout-btn">
                    Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('script/script.js') }}"></script>
</body>

</html>
