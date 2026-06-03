<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Health System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root{
            --primary:#1a6fc4;
            --primary-dark:#155ba0;
            --primary-light:#e8f1fb;
            --sidebar-bg:#0f2d52;
            --sidebar-text:#b8cde6;
            --sidebar-active:#1a6fc4;
            --sidebar-hover:#1a3a5c;
            --gray-50:#f8fafc;
            --gray-100:#f1f5f9;
            --gray-200:#e2e8f0;
            --gray-600:#475569;
            --radius:10px;
        }

        *{
            box-sizing:border-box;
            margin:0;
            padding:0;
        }

        body{
            font-family:'Inter',sans-serif;
            background:var(--gray-100);
            color:#1e293b;
            display:flex;
            min-height:100vh;
        }

        /* SIDEBAR */
        .sidebar{
            width:240px;
            background:var(--sidebar-bg);
            display:flex;
            flex-direction:column;
            min-height:100vh;
            position:fixed;
            left:0;
            top:0;
            bottom:0;
            z-index:100;
        }

        .sidebar-brand{
            padding:22px 20px 18px;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }

        .sidebar-brand .logo-icon{
            width:38px;
            height:38px;
            background:var(--primary);
            border-radius:10px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            color:white;
            font-size:18px;
            margin-bottom:10px;
        }

        .sidebar-brand h6{
            color:white;
            font-size:13px;
            font-weight:600;
            line-height:1.3;
            margin:0;
        }

        .sidebar-brand p{
            color:var(--sidebar-text);
            font-size:11px;
            margin:2px 0 0;
        }

        .sidebar-nav{
            padding:16px 12px;
            flex:1;
        }

        .nav-label{
            color:rgba(184,205,230,0.5);
            font-size:10px;
            font-weight:600;
            letter-spacing:0.1em;
            text-transform:uppercase;
            padding:0 8px;
            margin:16px 0 6px;
        }

        .sidebar-nav a{
            display:flex;
            align-items:center;
            gap:10px;
            padding:9px 12px;
            border-radius:8px;
            color:var(--sidebar-text);
            text-decoration:none;
            font-size:13.5px;
            margin-bottom:2px;
            transition:all 0.15s;
        }

        .sidebar-nav a:hover{
            background:var(--sidebar-hover);
            color:white;
        }

        .sidebar-nav a.active{
            background:var(--sidebar-active);
            color:white;
            font-weight:500;
        }

        .sidebar-nav a i{
            width:18px;
            text-align:center;
            font-size:14px;
        }

        .sidebar-user{
            padding:14px 16px;
            border-top:1px solid rgba(255,255,255,0.08);
            display:flex;
            align-items:center;
            gap:10px;
        }

        .user-avatar{
            width:34px;
            height:34px;
            border-radius:50%;
            background:var(--primary);
            display:flex;
            align-items:center;
            justify-content:center;
            color:white;
            font-size:13px;
            font-weight:600;
            flex-shrink:0;
        }

        .user-info{
            flex:1;
            min-width:0;
        }

        .user-info .uid{
            color:white;
            font-size:12px;
            font-weight:500;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .user-info .role{
            color:var(--sidebar-text);
            font-size:11px;
            text-transform:capitalize;
        }

        .sidebar-user a.logout{
            color:var(--sidebar-text);
            font-size:14px;
            text-decoration:none;
        }

        .sidebar-user a.logout:hover{
            color:#f87171;
        }

        /* MAIN */
        .main-content{
            margin-left:240px;
            flex:1;
            min-height:100vh;
        }

        .page-header{
            background:white;
            padding:18px 28px;
            border-bottom:1px solid var(--gray-200);
            display:flex;
            align-items:center;
            justify-content:space-between;
        }

        .page-header h4{
            font-size:17px;
            font-weight:600;
            color:#0f172a;
            margin:0;
        }

        .page-header .breadcrumb-text{
            font-size:12px;
            color:var(--gray-600);
            margin:2px 0 0;
        }

        .page-body{
            padding:24px 28px;
        }

        /* CARDS */
        .card{
            border:1px solid var(--gray-200);
            border-radius:var(--radius);
            background:white;
            box-shadow:0 1px 3px rgba(0,0,0,0.04);
            border: 1px solid black;
            border-radius: 18px;
            overflow: hidden;
        }

        .card-header{
            background:white;
            border-bottom:1px solid var(--gray-200);
            padding:14px 20px;
            font-size:14px;
            font-weight:600;
            border-radius:var(--radius) var(--radius) 0 0 !important;
            display:flex;
            align-items:center;
            gap:8px;
        }

        .card-body{
            padding:20px;
        }

        /* STAT CARDS */
        .stat-card{
            background:white;
            border:1px solid var(--gray-200);
            border-radius:var(--radius);
            padding:18px 20px;
            display:flex;
            align-items:center;
            gap:16px;
            border: 1px solid black;
            border-radius: 18px;
            overflow: hidden;
        }

        .stat-icon{
            width:46px;
            height:46px;
            border-radius:10px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:20px;
            flex-shrink:0;
        }

        .stat-icon.blue{
            background:#dbeafe;
            color:#1d4ed8;
        }

        .stat-icon.green{
            background:#dcfce7;
            color:#15803d;
        }

        .stat-icon.amber{
            background:#fef3c7;
            color:#b45309;
        }

        .stat-icon.red{
            background:#fee2e2;
            color:#b91c1c;
        }

        .stat-value{
            font-size:24px;
            font-weight:700;
            color:#0f172a;
            line-height:1;
        }

        .stat-label{
            font-size:12px;
            color:var(--gray-600);
            margin-top:3px;
        }

        /* TABLE */
        .table{
            font-size:13.5px;
        }

        .table thead th{
            background:var(--gray-50);
            font-weight:600;
            font-size:12px;
            text-transform:uppercase;
            letter-spacing:0.04em;
            color:var(--gray-600);
            border-bottom:1px solid var(--gray-200);
            padding:10px 14px;
        }

        .table tbody td{
            padding:12px 14px;
            vertical-align:middle;
            border-color:var(--gray-200);
        }

        .table tbody tr:hover{
            background:var(--gray-50);
        }

        /* BADGES */
        .badge-status{
            display:inline-flex;
            align-items:center;
            gap:5px;
            padding:4px 10px;
            border-radius:20px;
            font-size:11.5px;
            font-weight:500;
        }

        .badge-status.waiting{
            background:#fef3c7;
            color:#92400e;
        }

        .badge-status.in-progress{
            background:#dbeafe;
            color:#1e40af;
        }

        .badge-status.prescription-ready{
            background:#ede9fe;
            color:#5b21b6;
        }

        .badge-status.completed{
            background:#dcfce7;
            color:#166534;
        }

        .badge-status.student{
            background:#e0f2fe;
            color:#0c4a6e;
        }

        .badge-status.staff{
            background:#fce7f3;
            color:#831843;
        }

        /* FORMS */
        .form-control,
        .form-select{
            border:1px solid var(--gray-200);
            border-radius:8px;
            padding:9px 12px;
            font-size:14px;
            transition:border-color 0.15s,box-shadow 0.15s;
        }

        .form-control:focus,
        .form-select:focus{
            border-color:var(--primary);
            box-shadow:0 0 0 3px rgba(26,111,196,0.12);
            outline:none;
        }

        .form-label{
            font-size:13px;
            font-weight:500;
            color:#374151;
            margin-bottom:5px;
        }

        /* BUTTONS */
        .btn-primary{
            background:var(--primary);
            border-color:var(--primary);
            font-weight:500;
            border-radius:8px;
            font-size:14px;
        }

        .btn-primary:hover{
            background:var(--primary-dark);
            border-color:var(--primary-dark);
        }

        .btn-outline-primary{
            color:var(--primary);
            border-color:var(--primary);
            border-radius:8px;
            font-size:13.5px;
            font-weight:500;
        }

        .btn-outline-primary:hover{
            background:var(--primary);
            color:white;
        }

        .btn-success{
            background:#1b9c65;
            border-color:#1b9c65;
            border-radius:8px;
            font-size:13.5px;
        }

        .btn-sm{
            padding:5px 12px;
            font-size:12.5px;
        }

        /* ALERTS */
        .alert{
            border-radius:8px;
            font-size:13.5px;
            border:none;
        }

        .alert-success{
            background:#dcfce7;
            color:#166534;
        }

        .alert-danger{
            background:#fee2e2;
            color:#991b1b;
        }

        .section-divider{
            height:1px;
            background:var(--gray-200);
            margin:20px 0;
        }

        .patient-card{
            background:var(--primary-light);
            border:1px solid #bfdbfe;
            border-radius:var(--radius);
            padding:16px 18px;
        }

        .barcode-wrapper{
            background:white;
            border:1px solid var(--gray-200);
            border-radius:var(--radius);
            padding:20px;
            text-align:center;
        }
    </style>
</head>
<body>

@php $user = session('user'); @endphp

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-icon"><i class="fa-solid fa-hospital-user"></i></div>
        <h6>University Health System</h6>
        <p>Patient Management</p>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Navigation</div>
        @if($user && $user['role'] == 'nurse')
            <a href="/nurse/dashboard" class="{{ request()->is('nurse/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
        @endif
        @if($user && $user['role'] == 'doctor')
            <a href="/doctor/dashboard" class="{{ request()->is('doctor/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
        @endif
        @if($user && in_array($user['role'], ['student','staff']))
            <a href="/patient/dashboard" class="{{ request()->is('patient/dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-notes-medical"></i> My Records
            </a>
        @endif
    </nav>
    @if($user)
    <div class="sidebar-user">
        <div class="user-avatar">{{ strtoupper(substr($user['email'], 0, 1)) }}</div>
        <div class="user-info">
            <div class="uid">{{ $user['display_id'] ?? $user['email'] }}</div>
            <div class="role">{{ $user['role'] }}</div>
        </div>
        <a href="/logout" class="logout" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></a>
    </div>
    @endif
</aside>

<main class="main-content">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
