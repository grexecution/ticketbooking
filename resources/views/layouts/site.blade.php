<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/cjs/seatmap.canvas.css')}}" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer type="text/javascript" src="{{ asset('dist/cjs/seatmap.canvas.js') }}"></script>
    <link href="https://use.fontawesome.com/releases/v6.4.2/css/all.css" rel="stylesheet"/>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="navbar-brand">
            <img src="{{ asset('img/logo.png') }}" alt="Ticket Icon" class="ticket-icon"> <!-- Add your image path here -->
            <div>
                Ticket booking <br>
                <span class="ticket-text">Just sell tickets</span>
            </div>
        </div>
        <div class="search-container">
            <form class="form-inline my-2 my-lg-0 search-form"> <!-- Center the search input -->
                <input class="form-control mr-sm-2" type="search" placeholder="Search for events..." aria-label="Search">
            </form>
        </div>
        <div class="nav-menu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('site.events') }}">All Events</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@stack('scripts')
</body>
</html>
