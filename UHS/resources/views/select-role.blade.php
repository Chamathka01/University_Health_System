<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Role - University Health System</title>
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
            padding:24px;
        }

        .role-card{
            background:white;
            border-radius:18px;
            padding:40px 44px;
            width:100%;
            max-width:560px;
            box-shadow:0 25px 60px rgba(0,0,0,0.3);
            border:2px solid black;
        }

        .logo{
            width:60px;
            height:60px;
            background:#1a6fc4;
            border-radius:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:white;
            font-size:20px;
            margin-bottom:16px;
        }

        h4{
            font-size:25px;
            font-weight:700;
            color:#0f172a;
            margin-bottom:4px;
        }

        .subtitle{
            font-size:15px;
            color:#64748b;
            margin-bottom:18px;
        }

        .email-box{
            background:#eff6ff;
            border:1px solid #bfdbfe;
            border-radius:10px;
            color:#1e40af;
            font-size:14px;
            font-weight:600;
            padding:10px 12px;
            margin-bottom:22px;
        }

        .role-grid{
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:8px;
            margin-bottom:20px;
        }

        .role-opt{
            border:1px solid black;
            border-radius:10px;
            padding:12px 6px;
            text-align:center;
            cursor:pointer;
            transition:all 0.15s;
        }

        .role-opt:hover,
        .role-opt.selected{
            border-color:#1a6fc4;
            background:#eff6ff;
        }

        .role-opt input{
            display:none;
        }

        .role-opt i{
            display:block;
            font-size:25px;
            margin-bottom:6px;
            color:#64748b;
        }

        .role-opt.selected i,
        .role-opt.selected span{
            color:#1a6fc4;
        }

        .role-opt span{
            font-size:14px;
            font-weight:500;
            color:#374151;
        }

        .form-label{
            font-size:15px;
            font-weight:600;
            color:#374151;
            margin-bottom:4px;
        }

        .btn-save{
            background:#1a6fc4;
            color:white;
            border:none;
            border-radius:9px;
            height:44px;
            font-weight:600;
            font-size:15px;
            width:100%;
            margin-top:14px;
        }

        .btn-save:hover{
            background:#155ba0;
            color:white;
        }

        .alert{
            border-radius:8px;
            font-size:13px;
            border:none;
        }

        .alert-danger{
            background:#fee2e2;
            color:#991b1b;
        }

        @media(max-width:640px){
            .role-grid{
                grid-template-columns:repeat(2,1fr);
            }
        }
    </style>
</head>
<body>
<div class="role-card">
    <div class="logo"><i class="fa-solid fa-user-shield"></i></div>
    <h4>Select your role</h4>
    <p class="subtitle">Your Google account is verified. Choose how you want to enter the system.</p>

    <div class="email-box">
        <i class="fa-brands fa-google me-2"></i>{{ $email }}
    </div>

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('role.store') }}">
        @csrf

        <div class="mb-1">
            <p class="form-label mb-2">I am a...</p>
            <div class="role-grid">
                @foreach([
                    ['student', 'fa-user-graduate', 'Student'],
                    ['staff',   'fa-briefcase',      'Staff'],
                    ['doctor',  'fa-user-doctor',    'Doctor'],
                    ['nurse',   'fa-user-nurse',     'Nurse'],
                ] as [$val, $icon, $label])
                    <label class="role-opt {{ old('role') == $val ? 'selected' : '' }}" onclick="selectRole('{{ $val }}')">
                        <input type="radio" name="role" value="{{ $val }}" {{ old('role') == $val ? 'checked' : '' }}>
                        <i class="fa-solid {{ $icon }}"></i>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn-save">
            <i class="fa-solid fa-circle-check me-2"></i>Continue
        </button>
    </form>
</div>

<script>
function selectRole(role) {
    document.querySelectorAll('.role-opt').forEach(el => el.classList.remove('selected'));
    const radio = document.querySelector(`.role-opt input[value="${role}"]`);
    if (radio) {
        radio.checked = true;
        radio.closest('.role-opt').classList.add('selected');
    }
}

window.onload = () => {
    const role = document.querySelector('input[name="role"]:checked')?.value;
    if (role) selectRole(role);
};
</script>
</body>
</html>
