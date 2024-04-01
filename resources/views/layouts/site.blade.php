<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add custom CSS for layout modifications */
        .navbar-brand {
            margin-right: auto; /* Push 'Ticket booking' to the left */
        }

        .ticket-icon {
            width: 30px; /* Adjust width as needed */
            margin-right: 10px; /* Add spacing between image and text */
        }

        .ticket-text {
            font-size: 14px; /* Adjust font size as needed */
        }

        .search-container {
            text-align: center; /* Center the content */
        }

        .search-form {
            display: inline-block; /* Ensure form is inline */
        }

        .nav-menu {
            margin-left: auto; /* Push 'All Events' to the right */
        }

        .navbar {
            padding-left: 15%; /* Add left indent */
            padding-right: 15%; /* Add right indent */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
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

<div class="container mt-4">
    @yield('content')
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
