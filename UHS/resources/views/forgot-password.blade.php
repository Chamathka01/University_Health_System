<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Health System | Forgot Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 16px -6px rgba(0, 0, 0, 0.03);
            width: 100%;
            max-width: 500px;
            padding: 2.25rem !important;
            aspect-ratio: 1 / 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-width: 2px;
            border-color:#000000;

        }

        .brand-icon-box {
            width: 50px;
            height: 50px;
            background: #e8f1fb;
            color: #1a6fc4;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin: 0 auto 1rem auto;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 16px;
            border: 1px solid #cbd5e1;
            background-color: #f8fafc;
        }

        .form-control:focus {
            box-shadow: 0 0 0 4px rgba(26, 111, 196, 0.15);
            border-color: #1a6fc4;
            background-color: #ffffff;
        }

        .btn-submit {
            background: #1a6fc4;
            border: none;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            font-size: 14px;
            font-weight: 500;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background:#155ba0;
        }

        .back-link {
            font-size: 14px;
            color: #64748b;
            text-decoration: none;
            transition: color 0.2s;
        }

        .back-link:hover {
            color: #1a6fc4;
        }
    </style>
</head>
<body>

<div class="auth-card">
    <div class="brand-icon-box">
        <i class="fa-solid fa-hospital-user"></i>
    </div>

    <h4 class="fw-bold text-center mb-1" style="color: #0f2d52; font-size: 25px;">Forgot Password?</h4>
    <p class="text-muted text-center mb-4" style="font-size: 13px; #0f2d52;">Enter your medical network email address below to receive a secure recovery link.</p>

    @if(session('success'))
        <div class="alert alert-success d-flex align-items-center p-3 mb-3" style="font-size: 13px; border-radius: 8px;">
            <i class="fa-solid fa-circle-check me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger d-flex align-items-center p-3 mb-3" style="font-size: 13px; border-radius: 8px;">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('password.send') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label text-secondary small fw-medium mb-1">Email Address</label>
            <input type="email" name="email" class="form-control" placeholder="name@gmail.com" required autocomplete="email" autofocus>
        </div>

        <button type="submit" class="btn btn-primary w-100 btn-submit mb-3">
            <i class="fa-solid fa-paper-plane me-2 small"></i>Send Reset Link
        </button>
    </form>

    <div class="text-center">
        <a href="/login" class="back-link fw-medium">
            <i class="fa-solid fa-arrow-left-long me-2 small"></i>Back to Sign In
        </a>
    </div>
</div>

</body>
</html>
