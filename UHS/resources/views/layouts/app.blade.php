<!DOCTYPE html>
<html>
<head>
    <title>University Health Center</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #ffffff;
            color: #000;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background: #000;
        }

        .navbar-brand, .navbar a {
            color: #fff !important;
        }

        .navbar a {
            margin-left: 15px;
            text-decoration: none;
        }

        .table {
            color: #000;
        }

        .table thead {
            background: #f2f2f2;
        }

        .btn-black {
            background: #000;
            color: #fff;
            border: 1px solid #000;
        }

        .btn-black:hover {
            background: #fff;
            color: #000;
            border: 1px solid #000;
        }

        .card {
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

<nav class="navbar px-3">

    <span class="navbar-brand">
        University Health System
    </span>

    <div>

        @php
            $user = session('user');
        @endphp

        @if($user)

            @if($user['role'] == 'nurse')
                <a href="/nurse/scan">Scan</a>
                <a href="/nurse/prescriptions">Prescriptions</a>
            @endif

            @if($user['role'] == 'doctor')
                <a href="/doctor/dashboard">Dashboard</a>
            @endif

            @if($user['role'] == 'student')
                <a href="/student/dashboard">My Records</a>
            @endif

            <a href="/logout">Logout</a>

        @endif

    </div>

</nav>

<div class="container mt-3">
    @yield('content')
</div>

</body>
</html>
