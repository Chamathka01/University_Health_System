<!DOCTYPE html>
<html>
<head>
    <title>University Health System</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <a class="navbar-brand" href="#">UHS System</a>

    <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
</nav>

<div class="container">
    @yield('content')
</div>

</body>
</html>
