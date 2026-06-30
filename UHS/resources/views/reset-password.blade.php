<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        .auth-card {
            background: #ffffff;
            color: #000000;
            border: 2px solid #000000;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 16px -6px rgba(0, 0, 0, 0.03);
            width: 100%;
            max-width: 500px;
            padding: 2.5rem !important;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .auth-card h4 {
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #000000;
        }

        /* Styling form controls to match the minimal black/white theme */
        .auth-card .form-control {
            border: 1px solid #000000;
            padding: 1.25rem 0.75rem;
            border-radius: 6px;
            color: #000000;
        }

        .auth-card .form-control:focus {
            border-color: #000000;
            box-shadow: none;
        }

        .auth-card .input-group-text {
            background-color: transparent;
            border: 1px solid #ced4da;
            border-left: none;
            color: #6c757;
            border-color: #000000;
        }

        .auth-card .input-group-append .form-control:focus + .input-group-append .input-group-text {
            border-color: #000000;
        }

        /* solid primary button */
        .btn-custom {
            background:#1a6fc4;
            color:white;
            font-weight: 600;
            padding: 0.6rem;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .btn-custom:hover {
            background:#155ba0;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

<div class="auth-card">
    <h4 class="text-center mb-4">Reset Password</h4>

    @if(session('success'))
        <div class="alert alert-success small mb-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger small mb-3">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('password.reset') }}">
        @csrf

        <div class="form-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email Address" required>
        </div>

        <div class="form-group mb-3">
            <input type="text" name="code" class="form-control" placeholder="Reset Code" required>
        </div>

        <div class="input-group mb-3">
            <input type="password" id="password" name="password" class="form-control" style="border-right: none;" placeholder="New Password" required>
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePassword('password', this)" style="cursor:pointer;">
                    <i class="fa fa-eye"></i>
                </span>
            </div>
        </div>

        <div class="input-group mb-4">
            <input type="password" id="confirm_password" name="password_confirmation" class="form-control" style="border-right: none;" placeholder="Confirm Password" required>
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePassword('confirm_password', this)" style="cursor:pointer;">
                    <i class="fa fa-eye"></i>
                </span>
            </div>
        </div>

        <button type="submit" class="btn btn-custom btn-block">Reset Password</button>
    </form>
</div>

<script>
function togglePassword(fieldId, element) {
    let input = document.getElementById(fieldId);
    let icon = element.querySelector('i');

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>
