<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" rel="stylesheet"/>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @stack('styles')
</head>
<body>

<nav class="navbar py-3 navbar-expand-lg navbar-dark bg-black shadow">
    <div class="container">
            <a class="navbar-brand col-md-3 px-0" href="/">
                <img src="{{ asset('img/logo.png') }}" alt="Ticket Icon" class="ticket-icon">
                <div class="d-flex flex-col gap-0">
                    <p style="font-size:20px; font-weight:700;letter-spacing: -0.4px;">Ticketwilli</p>
                    <span class="ticket-text">Die Online-Pudl für Events</span>
                </div>
            </a>
        <div class="search-container col-md-6 d-none">
            <form class="form-inline my-2 my-lg-0 search-form">
                <input class="form-control mr-sm-2" type="search" placeholder="Events durchsuchen..." aria-label="Search">
            </form>
        </div>
        <div class="nav-menu">
            <ul class="navbar-nav d-flex flex-col gap-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('site.events') }}">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('site.events') }}">Über Uns</a>
                </li>
                <li class="nav-item">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Profil
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Action</button>
                            <button class="dropdown-item" type="button">Another action</button>
                            <button class="dropdown-item" type="button">Something else here</button>
                        </div>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/checkout">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<nav class="navbar navbar-dark bg-dark" aria-label="First navbar example">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Never expand</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample01" aria-controls="navbarsExample01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample01">
            <ul class="navbar-nav me-auto mb-2">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Dropdown</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown01">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>
            </ul>
            <form>
                <input class="form-control" type="text" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </div>
</nav>

    <span id="site-app">
        @yield('content')
    </span>

<div class="container">
  <footer class="d-flex flex-wrap justify-content-between align-items-center py-6 border-top">
    <p class="col-md-4 mb-0 text-muted">© 2024 Ticketwilli</p>

    <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <img src="{{ asset('img/logo.png') }}" alt="Ticket Icon" class="ticket-icon">
    </a>

    <ul class="nav col-md-4 justify-content-end">
      <li class="nav-item"><a href=/" class="nav-link px-2 text-muted">Home</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Kontakt</a></li>
    </ul>
  </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ mix('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
