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
        body{
            min-height:100vh;
            background:linear-gradient(135deg,#0f2d52 0%,#1a6fc4 100%);
            font-family:'Inter',sans-serif;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .login-wrap{
            display:flex;
            width:820px;
            max-width:95vw;
            border-radius:18px;
            border: 2px solid black;
            overflow:hidden;
            box-shadow:0 25px 60px rgba(0,0,0,0.35);
        }

        .panel-left{
            background:#0f2d52;
            flex:1;
            display:flex;
            flex-direction:column;
            justify-content:center;
            padding:48px 40px;
            color:white;
            border-top-right-radius: 0;
            border-bottom-right-radius: 0px;
            border-top-left-radius: 18;
            border-bottom-left-radius: 18;
            overflow: hidden;

        }

        .panel-left .logo{
            width:60px;
            height:60px;
            background:#1a6fc4;
            border-radius:14px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:24px;
            margin-bottom:24px;
        }

        .panel-left h2{
            font-size:30px;
            font-weight:700;
            margin-bottom:10px;
        }

        .panel-left p{
            color:#b8cde6;
            font-size:13px;
            line-height:1.7;
            margin:0;
        }

        .features{
            margin-top:32px;
            list-style:none;
            padding:0;
        }

        .features li{
            display:flex;
            align-items:center;
            gap:10px;
            color:#b8cde6;
            font-size:13px;
            margin-bottom:12px;
        }

        .features li i{
            color:#4ade80;
            font-size:12px;
        }

        .panel-right{
            background:white;
            flex:1;
            flex-shrink:0;
            padding:48px 36px;
            display:flex;
            flex-direction:column;
            justify-content:center;
            border-top-right-radius: 18px;
            border-bottom-right-radius: 18px;
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
            overflow: hidden;
        }

        .panel-right h4{
            font-size:25px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:4px;
        }

        .subtitle{
            font-size:14px;
            color:#64748b;
            margin-bottom:28px;
        }

        .form-label{
            font-size:15px;
            font-weight:500;
            color:#374151;
            margin-bottom:5px;
        }

        .pw-wrap{
            position:relative;
        }

        .pw-wrap .form-control{
            padding-right:40px;
        }

        .pw-toggle{
            position:absolute;
            right:12px;
            top:50%;
            transform:translateY(-50%);
            color:#94a3b8;
            cursor:pointer;
            font-size:14px;
            z-index:5;
        }

        .form-control{
            border:1px solid #e2e8f0;
            border-radius:8px;
            height:44px;
            font-size:14px;
            padding:0 12px;
            transition:border-color 0.15s,box-shadow 0.15s;
            border: 1px solid black;
        }

        .form-control:focus{
            border-color:#1a6fc4;
            box-shadow:0 0 0 3px rgba(26,111,196,0.12);
        }

        .btn-login{
            background:#1a6fc4;
            color:white;
            border:none;
            border-radius:8px;
            height:44px;
            font-weight:600;
            font-size:15px;
            width:100%;
            margin-top:6px;
            transition:background 0.15s;
        }

        .btn-login:hover{
            background:#155ba0;
            color:white;
        }

        .forgot-link{
            font-size:13px;
            color:#1a6fc4;
            text-decoration:none;
        }

        .forgot-link:hover{
            text-decoration:underline;
        }

        .reg-link{
            font-size:13px;
            color:#64748b;
            margin-top:20px;
            text-align:center;
        }

        .reg-link a{
            color:#1a6fc4;
            font-weight:500;
            text-decoration:none;
        }

        .alert{
            border-radius:8px;
            font-size:13px;
            border:none;
            padding:10px 14px;
        }

        .alert-danger{
            background:#fee2e2;
            color:#991b1b;
        }

        .alert-success{
            background:#dcfce7;
            color:#166534;
        }

        @media(max-width:640px){
            .panel-left{
                display:none;
            }
            .panel-right{
                width:100%;
            }
        }
    </style>
</head>
<body>
<div class="login-wrap">

    <!-- Left branding -->
    <div class="panel-left">
        <div class="logo"><i class="fa-solid fa-hospital-user"></i></div>
        <h2>University Health System</h2>
        <p>Manage patient visits, consultations, and prescriptions </p>
        <ul class="features">
            <li><i class="fa-solid fa-circle-check"></i> Student & Staff patient records</li>
            <li><i class="fa-solid fa-circle-check"></i> Doctor consultations & PDF reports</li>
            <li><i class="fa-solid fa-circle-check"></i> Barcode patient identification</li>
            <li><i class="fa-solid fa-circle-check"></i> Prescription management</li>
        </ul>
    </div>

    <!-- Right login form -->
    <div class="panel-right">
        <h4>Welcome back</h4>
        <p class="subtitle">Sign in with Google, then choose your system role</p>

        @if(session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mb-3">{{ $errors->first() }}</div>
        @endif

        <a href="{{ route('login.google') }}" class="btn-login d-flex align-items-center justify-content-center text-decoration-none">
            <i class="fa-brands fa-google me-2"></i>Sign in with Google
        </a>

        <p class="reg-link">No password registration needed. Your role is selected after Google sign in.</p>
    </div>
</div>
</body>
</html>
