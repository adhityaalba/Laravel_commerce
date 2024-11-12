<!-- resources/views/admin/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Navbar atas -->
    <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: rgb(248, 93, 93)">
        <div class="container">
            <button class="navbar-toggler me-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('Home') }}">Commerce</a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('admin') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row min-vh-100">
            <!-- Sidebar for desktop -->
            <div class="col-auto px-0 d-none d-lg-block">
                <div class="sidebar bg-danger text-white p-3" style="width: 250px; position: fixed; top: 56px; height: calc(100vh - 56px); overflow-y: auto;">
                    <h4 class="text-center">Admin Menu</h4>
                    <a href="{{ route('admin.transactions') }}" class="d-block text-white mb-2"><i class="fas fa-money-check-alt me-2"></i> Transaksi</a>
                    <a href="{{ route('admin.products') }}" class="d-block text-white mb-2"><i class="fas fa-box me-2"></i> Produk</a>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col ps-lg-4" style="margin-left: 250px;">
                <div class="page-header pt-3">
                    <h2>@yield('title')</h2>
                </div>
                <hr>
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
