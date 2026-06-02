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
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f2d52 0%, #1a6fc4 100%);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .register-card {
            background: white;
            border-radius: 18px;
            padding: 40px 44px;
            width: 100%;
            max-width: 620px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
            border: 2px solid black;
        }

        .card-logo {
            width: 46px; height: 46px;
            background: #1a6fc4;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: white; font-size: 20px;
            margin-bottom: 16px;
        }

        h4 { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .subtitle { font-size: 13px; color: #64748b; margin-bottom: 24px; }

        .form-label { font-size: 12.5px; font-weight: 500; color: #374151; margin-bottom: 4px; }
        .form-control, .form-select {
            border: 1px solid black;
            border-radius: 8px;
            height: 42px;
            font-size: 13.5px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #1a6fc4;
            box-shadow: 0 0 0 3px rgba(26,111,196,0.12);
        }
        textarea.form-control { height: auto; }

        .section-title {
            font-size: 11.5px;
            font-weight: 600;
            color: #7b8798;
            text-transform: uppercase;
            letter-spacing: 0.07em;
            margin: 20px 0 12px;
            padding-bottom: 6px;
            border-bottom: 1px solid #f1f5f9;
        }

        .role-selector {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 6px;
        }

        .role-option {
            border: 1.5px solid #e2e8f0;
            border-radius: 9px;
            padding: 10px 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.15s;
            border: 1px solid black;
        }
        .role-option:hover { border-color: #1a6fc4; background: #eff6ff; }
        .role-option.selected { border-color: #1a6fc4; background: #eff6ff; }
        .role-option input[type="radio"] { display: none; }
        .role-option i { display: block; font-size: 20px; margin-bottom: 5px; color: #64748b; }
        .role-option.selected i { color: #1a6fc4; }
        .role-option span { font-size: 12px; font-weight: 500; color: #374151; }
        .role-option.selected span { color: #1a6fc4; }

        .btn-register {
            background: #1a6fc4;
            color: white;
            border: none;
            border-radius: 9px;
            height: 44px;
            font-weight: 600;
            font-size: 14px;
            width: 100%;
            margin-top: 10px;
            transition: background 0.15s;
        }
        .btn-register:hover { background: #155ba0; color: white; }

        .login-link { font-size: 13px; color: #64748b; margin-top: 16px; text-align: center; }
        .login-link a { color: #1a6fc4; font-weight: 500; text-decoration: none; }

        .alert { border-radius: 8px; font-size: 13px; border: none; }
        .alert-danger { background: #fee2e2; color: #991b1b; }

        .autofill-hint {
            font-size: 11.5px;
            color: #3b82f6;
            margin-top: 3px;
        }

        .input-group .form-control { border-radius: 8px !important; }
        .pw-toggle {
            position: absolute; right: 12px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8; cursor: pointer; z-index: 5; font-size: 14px;
        }
        .pw-wrap { position: relative; }
    </style>
</head>
<body>

<div class="register-card">
    <div class="card-logo"><i class="fa-solid fa-hospital-user"></i></div>
    <h4>Create your account</h4>
    <p class="subtitle">Fill in the details below to register</p>

    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register.store') }}">
        @csrf

        <div class="section-title">Select your role</div>
        <div class="role-selector">
            <label class="role-option {{ old('role') == 'student' ? 'selected' : '' }}" onclick="selectRole('student')">
                <input type="radio" name="role" value="student" {{ old('role') == 'student' ? 'checked' : '' }}>
                <i class="fa-solid fa-user-graduate"></i>
                <span>Student</span>
            </label>
            <label class="role-option {{ old('role') == 'staff' ? 'selected' : '' }}" onclick="selectRole('staff')">
                <input type="radio" name="role" value="staff" {{ old('role') == 'staff' ? 'checked' : '' }}>
                <i class="fa-solid fa-briefcase"></i>
                <span>Staff</span>
            </label>
            <label class="role-option {{ old('role') == 'doctor' ? 'selected' : '' }}" onclick="selectRole('doctor')">
                <input type="radio" name="role" value="doctor" {{ old('role') == 'doctor' ? 'checked' : '' }}>
                <i class="fa-solid fa-user-doctor"></i>
                <span>Doctor</span>
            </label>
            <label class="role-option {{ old('role') == 'nurse' ? 'selected' : '' }}" onclick="selectRole('nurse')">
                <input type="radio" name="role" value="nurse" {{ old('role') == 'nurse' ? 'checked' : '' }}>
                <i class="fa-solid fa-user-nurse"></i>
                <span>Nurse</span>
            </label>
        </div>


        <div class="section-title">Personal information</div>
        <div class="row g-2 mb-2">
            <div class="col-6">
                <label class="form-label">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control"
                       placeholder="e.g. Kamal" value="{{ old('firstname') }}"
                       required oninput="autoFillUsername()">
            </div>
            <div class="col-6">
                <label class="form-label">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control"
                       placeholder="e.g. Perera" value="{{ old('lastname') }}"
                       required oninput="autoFillUsername()">
            </div>
        </div>

        <div class="row g-2 mb-2">
            <div class="col-6">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="dob" class="form-control" value="{{ old('dob') }}">
            </div>
            <div class="col-6">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone" class="form-control"
                       placeholder="07XXXXXXXX" value="{{ old('phone') }}">
            </div>
        </div>

        <div class="mb-2">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control"
                   placeholder="you@example.com" value="{{ old('email') }}" required>
        </div>



        <!-- Student Fields -->
        <div id="studentFields" style="display:none;">
            <div class="section-title">Student details</div>
            <div class="mb-2">
                <label class="form-label">Registration Number</label>
                <input type="text" name="regno" id="regno" class="form-control"
                       placeholder="e.g. 2020ICT01" value="{{ old('regno') }}"
                       oninput="autoFillUsername()">
                <p class="autofill-hint"><i class="fa-solid fa-wand-magic-sparkles"></i> Username will auto-fill from your name + reg no</p>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-12">
                    <label class="form-label">Faculty</label>
                    <select name="faculty" class="form-select">
                        <option value="">Select Faculty</option>
                        <option value="appliedscience"       {{ old('faculty')=='appliedscience' ? 'selected' : '' }}>Faculty of Applied Science</option>
                        <option value="technologicalstudies" {{ old('faculty')=='technologicalstudies' ? 'selected' : '' }}>Faculty of Technological Studies</option>
                        <option value="businessstudies"      {{ old('faculty')=='businessstudies' ? 'selected' : '' }}>Faculty of Business Studies</option>
                    </select>
                </div>
            </div>
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-select">
                        <option value="">Select Department</option>
                        <option value="physicalscience" {{ old('department')=='physicalscience' ? 'selected' : '' }}>Physical Science</option>
                        <option value="bioscience"      {{ old('department')=='bioscience' ? 'selected' : '' }}>Bio Science</option>
                        <option value="ict"             {{ old('department')=='ict' ? 'selected' : '' }}>ICT</option>
                    </select>
                </div>
                <div class="col-6">
                    <label class="form-label">Degree Programme</label>
                    <select name="degree" class="form-select">
                        <option value="">Select Degree</option>
                        <option value="it"       {{ old('degree')=='it' ? 'selected' : '' }}>Information Technology</option>
                        <option value="amc"      {{ old('degree')=='amc' ? 'selected' : '' }}>Applied Mathematics & Computing</option>
                        <option value="bio"      {{ old('degree')=='bio' ? 'selected' : '' }}>Environmental Science</option>
                        <option value="ict_degree" {{ old('degree')=='ict_degree' ? 'selected' : '' }}>Information & Communication Technology</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Staff Fields -->
        <div id="staffFields" style="display:none;">
            <div class="section-title">Staff details</div>
            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="form-label">Staff ID</label>
                    <input type="text" name="staff_id" id="staff_id" class="form-control"
                           placeholder="e.g. STAFF001" value="{{ old('staff_id') }}"
                           oninput="autoFillUsername()">
                    <p class="autofill-hint"><i class="fa-solid fa-wand-magic-sparkles"></i> Username will auto-fill</p>
                </div>
                <div class="col-6">
                    <label class="form-label">Department</label>
                    <select name="staff_department" class="form-select">
                        <option value="">Select Department</option>
                        <option value="Administration"   {{ old('staff_department')=='Administration' ? 'selected' : '' }}>Administration</option>
                        <option value="IT"               {{ old('staff_department')=='IT' ? 'selected' : '' }}>IT / Computing</option>
                        <option value="Library"          {{ old('staff_department')=='Library' ? 'selected' : '' }}>Library</option>
                        <option value="Finance"          {{ old('staff_department')=='Finance' ? 'selected' : '' }}>Finance</option>
                        <option value="Security"         {{ old('staff_department')=='Security' ? 'selected' : '' }}>Security</option>
                        <option value="Maintenance"      {{ old('staff_department')=='Maintenance' ? 'selected' : '' }}>Maintenance</option>
                        <option value="Academic"         {{ old('staff_department')=='Academic' ? 'selected' : '' }}>Academic Staff</option>
                        <option value="Other"            {{ old('staff_department')=='Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="section-title">Account credentials</div>

        <div class="mb-2">
            <label class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control"
                   placeholder="Auto-filled or type manually" value="{{ old('username') }}" required>
        </div>

        <div class="row g-2">
            <div class="col-6">
                <label class="form-label">Password</label>
                <div class="pw-wrap">
                    <input type="password" name="password" id="pw1" class="form-control" placeholder="Min. 8 characters" required>
                    <i class="fa-regular fa-eye pw-toggle" onclick="togglePw('pw1', this)"></i>
                </div>
            </div>
            <div class="col-6">
                <label class="form-label">Confirm Password</label>
                <div class="pw-wrap">
                    <input type="password" name="password_confirmation" id="pw2" class="form-control" placeholder="Repeat password" required>
                    <i class="fa-regular fa-eye pw-toggle" onclick="togglePw('pw2', this)"></i>
                </div>
            </div>
        </div>

        <button type="submit" class="btn-register mt-3">
            <i class="fa-solid fa-user-plus me-2"></i> Create Account
        </button>
    </form>

    <p class="login-link">Already have an account? <a href="/login">Sign in</a></p>
</div>

<script>
// Role selection UI
function selectRole(role) {
    document.querySelectorAll('.role-option').forEach(el => el.classList.remove('selected'));
    const selected = document.querySelector(`.role-option input[value="${role}"]`);
    if (selected) {
        selected.checked = true;
        selected.closest('.role-option').classList.add('selected');
    }
    document.getElementById('studentFields').style.display = (role === 'student') ? 'block' : 'none';
    document.getElementById('staffFields').style.display   = (role === 'staff')   ? 'block' : 'none';
    autoFillUsername();
}

// Auto-fill username
function autoFillUsername() {
    const firstname = document.getElementById('firstname').value.trim().toLowerCase();
    const lastname  = document.getElementById('lastname').value.trim().toLowerCase();
    const regno     = document.getElementById('regno')?.value.trim()    || '';
    const staffId   = document.getElementById('staff_id')?.value.trim() || '';
    const role      = document.querySelector('input[name="role"]:checked')?.value || '';

    let id = '';
    if (role === 'student' && regno)  id = regno.toLowerCase();
    if (role === 'staff'   && staffId) id = staffId.toLowerCase();

    if (firstname) {
        const base = id ? (firstname + '_' + id) : (firstname + (lastname ? '_' + lastname.charAt(0) : ''));
        document.getElementById('username').value = base.replace(/[^a-z0-9_]/g, '');
    }
}

//  Password toggle
function togglePw(fieldId, icon) {
    const input = document.getElementById(fieldId);
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

// Handles validation errors returning old values
window.onload = function() {
    const role = document.querySelector('input[name="role"]:checked')?.value || '';
    if (role) selectRole(role);
};
</script>
</body>
</html>
