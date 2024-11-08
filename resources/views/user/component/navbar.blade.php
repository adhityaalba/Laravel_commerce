<nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #526f55;">
    <div class="container">
        <a class="navbar-brand" href="{{ route('Home') }}">Gri-Bit</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end gap-2" id="navbarSupportedContent">
            <ul class="navbar-nav gap-2">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="{{ route('Home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('Home') }}">Shop</a>
                </li>
            </ul>

            <div class="d-flex gap-4 align-items-center">
                @auth
                    <!-- Dropdown Profil -->
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="navbarDropdown"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user-circle"></i> Profile
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href='{{ route('transactions') }}'>Transaction</a></li>
                            <li><a class="dropdown-item" href='#'>Update Profile</a></li>
                        </ul>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">Logout</button>
                    </form>

                    @if (!in_array(Route::currentRouteName(), ['cart.index', 'transactions', 'payment']))
                        <div class="notif position-relative">
                            <a href="{{ route('cart.index') }}" class="fs-6 icon-nav">
                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>
                            <div class="circle">{{ \App\Http\Controllers\CartController::countItems() }}</div>
                        </div>
                    @endif
                @else
                    <a href="{{ route('register') }}" class="btn btn-warning" style="background-color: #f08e43;">
                        Login | Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
