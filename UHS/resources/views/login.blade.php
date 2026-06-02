<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — University Health System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2d52 0%, #1a6fc4 100%);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrap {
            display: flex;
            width: 860px;
            max-width: 95vw;
            min-height: 520px;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.35);
        }

        .login-panel-left {
            background: #0f2d52;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 40px;
            color: white;
        }

        .login-panel-left .logo-icon {
            width: 54px; height: 54px;
            background: #1a6fc4;
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            margin-bottom: 24px;
        }

        .login-panel-left h2 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .login-panel-left p {
            color: #b8cde6;
            font-size: 13.5px;
            line-height: 1.7;
            margin: 0;
        }

        .feature-list { margin-top: 32px; list-style: none; padding: 0; }
        .feature-list li {
            display: flex; align-items: center; gap: 10px;
            color: #b8cde6; font-size: 13px;
            margin-bottom: 12px;
        }
        .feature-list li i { color: #4ade80; font-size: 12px; }

        .login-panel-right {
            background: white;
            width: 360px;
            flex-shrink: 0;
            padding: 48px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-panel-right h4 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .login-panel-right .subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 28px;
        }

        .form-label { font-size: 12.5px; font-weight: 500; color: #374151; margin-bottom: 5px; }

        .input-icon-wrap { position: relative; }
        .input-icon-wrap i.field-icon {
            position: absolute; top: 50%; right: 13px;
            transform: translateY(-50%);
            color: #94a3b8; cursor: pointer; font-size: 14px;
        }

        .form-control {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            height: 44px;
            font-size: 14px;
            padding: 0 38px 0 12px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-control:focus {
            border-color: #1a6fc4;
            box-shadow: 0 0 0 3px rgba(26,111,196,0.12);
        }

        .btn-login {
            background: #1a6fc4;
            color: white;
            border: none;
            border-radius: 8px;
            height: 44px;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            margin-top: 6px;
            transition: background 0.15s;
        }
        .btn-login:hover { background: #155ba0; }

        .forgot-link { font-size: 12.5px; color: #1a6fc4; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }

        .register-link { font-size: 13px; color: #64748b; margin-top: 20px; text-align: center; }
        .register-link a { color: #1a6fc4; font-weight: 500; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }

        .alert { border-radius: 8px; font-size: 13px; border: none; padding: 10px 14px; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        .alert-success { background: #dcfce7; color: #166534; }

        @media (max-width: 640px) {
            .login-panel-left { display: none; }
            .login-panel-right { width: 100%; }
        }
    </style>
</head>
<body>

<div class="login-wrap">

    <div class="login-panel-left">
        <div class="logo-icon"><i class="fa-solid fa-hospital-user"></i></div>
        <h2>University Health System</h2>
        <p>Manage patient visits, consultations, and prescriptions — all in one place.</p>
        <ul class="feature-list">
            <li><i class="fa-solid fa-circle-check"></i> Student & Staff patient records</li>
            <li><i class="fa-solid fa-circle-check"></i> Doctor consultations & PDF reports</li>
            <li><i class="fa-solid fa-circle-check"></i> Barcode-based patient identification</li>
            <li><i class="fa-solid fa-circle-check"></i> Prescription management</li>
        </ul>
    </div>

    <div class="login-panel-right">
        <h4>Welcome back</h4>
        <p class="subtitle">Sign in to your account</p>

        @if ($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('login.check') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-icon-wrap">
                    <input type="text" name="username" class="form-control" placeholder="Enter your username" value="{{ old('username') }}" required>
                    <i class="fa-regular fa-user field-icon"></i>
                </div>
            </div>

            <div class="mb-2">
                <label class="form-label">Password</label>
                <div class="input-icon-wrap">
                    <input type="password" name="password" id="login_password" class="form-control" placeholder="Enter your password" required>
                    <i class="fa-regular fa-eye field-icon" id="toggleIcon" onclick="togglePassword()" style="cursor:pointer;"></i>
                </div>
            </div>

            <div class="text-end mb-3">
                <a href="/forgot-password" class="forgot-link">Forgot password?</a>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <p class="register-link">Don't have an account? <a href="/register">Register here</a></p>
    </div>
</div>

<script>
function togglePassword() {
    const input = document.getElementById('login_password');
    const icon  = document.getElementById('toggleIcon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}
</script>
</body>
</html>
