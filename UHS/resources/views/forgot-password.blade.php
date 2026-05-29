<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="height:100vh; background:#ccc;">

<div class="card p-4" style="width:400px;">
    <h4 class="mb-3 text-center">Forgot Password</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('password.send') }}">
        @csrf
        <input type="email" name="email" class="form-control mb-3" placeholder="Enter your email" required>

        <button class="btn btn-primary btn-block">Send Reset Link</button>
    </form>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
</body>
</html>
