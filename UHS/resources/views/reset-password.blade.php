<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="d-flex justify-content-center align-items-center" style="height:100vh; background:#ccc;">

<div class="card p-4" style="width:400px;">
    <h4 class="text-center mb-3">Reset Password</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('password.reset') }}">
        @csrf

        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
        <input type="text" name="code" class="form-control mb-2" placeholder="Reset Code" required>

        <!-- Password -->
        <div class="input-group mb-2">
            <input type="password" id="password" name="password" class="form-control" placeholder="New Password" required>
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePassword('password', this)" style="cursor:pointer;">
                    <i class="fa fa-eye"></i>
                </span>
            </div>
        </div>

        <!-- Confirm Password -->
        <div class="input-group mb-3">
            <input type="password" id="confirm_password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePassword('confirm_password', this)" style="cursor:pointer;">
                    <i class="fa fa-eye"></i>
                </span>
            </div>
        </div>


        <button class="btn btn-primary btn-block">Reset Password</button>
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
