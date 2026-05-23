<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Login Page</title>

    <style>
    body {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #a0a0a0, #7a7a7a);
        font-family: 'Poppins', sans-serif;
        margin: 0;
    }

    .login-card {
        border: none;
        border-radius: 20px;
        padding: 50px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            background-color: #fff;
            width: 100%;
            max-width: 450px;
    }

    .form-control {
        border-radius: 10px;
        height: 50px;
        margin-bottom: 20px;
    }

    .btn-primary {
        border-radius: 10px;
        font-weight: 600;
        height: 50px;
        font-size: 1.1rem;
        margin-top: 10px;
    }

    h3 {
            font-size: 2rem;
    }

    .field-icon {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
}

</style>

</head>
<body>
    <div class="card login-card text-center">

        <h3 class="font-weight-bold mb-2">Welcome Back</h3>
        <p class="text-muted mb-4">Login to continue</p>

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

     <form method="POST" action="{{route('login.check')}}">
        @csrf
        <input type="text" name="username" placeholder="Username" required>

        <div class="position-relative">
        <input type="password" id="login_password" class="form-control" name="password"  placeholder="Password" required>
        <span class="fa fa-eye field-icon" onclick="togglePassword('login_password', this)"></span>
        </div>
    <div class="text-right mb-3">
    <a href="/forgot-password">Forgot Password?</a>
    </div>

    <button type="submit" class="btn btn-primary btn-block" >Login</button>
    </form>

    <div class="mt-4">
            <p class="mb-0">Don't have an account? <a href="/">Register</a></p>
    </div>

    <script>
function togglePassword(fieldId, icon) {
    let input = document.getElementById(fieldId);

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
