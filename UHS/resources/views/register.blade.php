<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register — University Health System</title>
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

            .reg-card{
                background:white;
                border-radius:18px;
                padding:40px 44px;
                width:100%;
                max-width:500px;
                box-shadow:0 25px 60px rgba(0,0,0,0.3);
                border: 2px solid black;
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
                margin-bottom:28px;
            }

            /* Role selector */
            .role-grid{
                display:grid;
                grid-template-columns:repeat(4,1fr);
                gap:8px;
                margin-bottom:20px;

            }

            .role-opt{
                border:1.5px solid #e2e8f0;
                border-radius:10px;
                padding:12px 6px;
                text-align:center;
                cursor:pointer;
                transition:all 0.15s;
                border: 1px solid black;
            }

            .role-opt:hover{
                border-color:#1a6fc4;
                background:#eff6ff;
            }

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

            .role-opt.selected i{
                color:#1a6fc4;
            }

            .role-opt span{
                font-size:14px;
                font-weight:500;
                color:#374151;
            }

            .role-opt.selected span{
                color:#1a6fc4;
            }

            .form-label{
                font-size:15px;
                font-weight:500;
                color:#374151;
                margin-bottom:4px;
            }

            .form-control{
                border:1px solid #e2e8f0;
                border-radius:8px;
                height:44px;
                font-size:14px;
                padding:0 14px;
                transition:border-color 0.15s,box-shadow 0.15s;
                border: 1px solid black;
            }

            .form-control:focus{
                border-color:#1a6fc4;
                box-shadow:0 0 0 3px rgba(26,111,196,0.12);
                outline:none;
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
            }

            .hint{
                font-size:11.5px;
                color:#3b82f6;
                margin-top:3px;
            }

            .btn-register{
                background:#1a6fc4;
                color:white;
                border:none;
                border-radius:9px;
                height:44px;
                font-weight:600;
                font-size:15px;
                width:100%;
                margin-top:14px;
                transition:background 0.15s;
            }

            .btn-register:hover{
                background:#155ba0;
            }

            .login-link{
                font-size:14px;
                color:#64748b;
                margin-top:16px;
                text-align:center;
            }

            .login-link a{
                color:#1a6fc4;
                font-weight:500;
                text-decoration:none;
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

            /* Animate ID field in/out */
            .id-field{
                overflow:hidden;
                transition:max-height 0.25s ease, opacity 0.2s ease;
                max-height:0;
                opacity:0;
            }

            .id-field.visible{
                max-height:80px;
                opacity:1;
            }
    </style>
</head>
<body>
<div class="reg-card">

    <div class="logo"><i class="fa-solid fa-hospital-user"></i></div>
    <h4>Create account</h4>
    <p class="subtitle">Register your role and sign in with Google</p>

    @if($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <!-- 1. Role -->
        <div class="mb-1">
            <p class="form-label mb-2">I am a…</p>
            <div class="role-grid">
                @foreach([
                    ['student', 'fa-user-graduate', 'Student'],
                    ['staff',   'fa-briefcase',      'Staff'],
                    ['doctor',  'fa-user-doctor',    'Doctor'],
                    ['nurse',   'fa-user-nurse',     'Nurse'],
                ] as [$val, $icon, $label])
                <label class="role-opt {{ old('role') == $val ? 'selected' : '' }}"
                       onclick="selectRole('{{ $val }}')">
                    <input type="radio" name="role" value="{{ $val }}"
                           {{ old('role') == $val ? 'checked' : '' }}>
                    <i class="fa-solid {{ $icon }}"></i>
                    <span>{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- 2. Student ID (shown only for student) -->
        <div class="id-field mb-3 {{ old('role') == 'student' ? 'visible' : '' }}" id="regnoField">
            <label class="form-label">Registration Number</label>
            <input type="text" name="regno" class="form-control"
                   placeholder="e.g. 2020/ICT/01"
                   value="{{ old('regno') }}">
            <!--<p class="hint"><i class="fa-solid fa-circle-info me-1"></i>Your university registration number</p>-->
        </div>

        <!-- 3. Staff ID (shown only for staff) -->
        <div class="id-field mb-3 {{ old('role') == 'staff' ? 'visible' : '' }}" id="staffField">
            <label class="form-label">Staff ID</label>
            <input type="text" name="staff_id" class="form-control"
                   placeholder="e.g. STAFF/001"
                   value="{{ old('staff_id') }}">
          <!--  <p class="hint"><i class="fa-solid fa-circle-info me-1"></i>Your university staff ID</p>-->
        </div>

        <!-- 4. Email -->
        <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control"
                   placeholder="name@gmail.com"
                   value="{{ old('email') }}" required>
        </div>

        <p class="hint">
            <i class="fa-solid fa-circle-info me-1"></i>
            Use the same email address when signing in with Google.
        </p>

        <button type="submit" class="btn-register">
            <i class="fa-solid fa-user-plus me-2"></i>Create Account
        </button>
    </form>

    <p class="login-link">Already have an account? <a href="/login">Sign in</a></p>
</div>

<script>
function selectRole(role) {
    // Highlight selected card
    document.querySelectorAll('.role-opt').forEach(el => el.classList.remove('selected'));
    const radio = document.querySelector(`.role-opt input[value="${role}"]`);
    if (radio) { radio.checked = true; radio.closest('.role-opt').classList.add('selected'); }

    // Show / hide ID fields
    document.getElementById('regnoField').classList.toggle('visible', role === 'student');
    document.getElementById('staffField').classList.toggle('visible', role === 'staff');
}

// Re-apply on validation error (old values)
window.onload = () => {
    const role = document.querySelector('input[name="role"]:checked')?.value;
    if (role) selectRole(role);
};
</script>
</body>
</html>
