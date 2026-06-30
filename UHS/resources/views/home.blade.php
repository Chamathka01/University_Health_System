<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Health System | Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }
        .navbar-brand fw-bold {
            color: #0f2d52;
        }
        /* Hero Section Styling using high-quality healthcare imagery */
        .hero-section {
            background: linear-gradient(rgba(15, 45, 82, 0.85), rgba(15, 45, 82, 0.85)),
                        url('https://images.unsplash.com/photo-1519494026892-80bbd2d6fd0d?auto=format&fit=crop&q=80&w=1200') center/cover no-repeat;
            padding: 100px 0;
            color: white;
            border-bottom: 5px solid #1a6fc4;
        }
        .premium-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 10px 15px -3px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s;
        }
        .premium-card:hover {
            transform: translateY(-5px);
        }
        .icon-box {
            width: 50px;
            height: 50px;
            background: #e8f1fb;
            color: #1a6fc4;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom py-3">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#" style="color: #0f2d52; font-size: 19px;">
                <i class="fa-solid fa-hospital-user text-primary"></i> University Health System
            </a>
            <div class="ms-auto">
                <a href="/login" class="btn btn-primary px-4 fw-medium" style="background: #1a6fc4; border-radius: 8px; font-size: 15px;">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Sign In to Portal
                </a>
            </div>
        </div>
    </nav>

    <header class="hero-section text-center text-md-start">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="badge mb-3 px-3 py-2 text-uppercase fw-bold" style="background: rgba(255,255,255,0.15); color: #e8f1fb; font-size: 12px; letter-spacing: 0.05em;">
                        Official Campus Medical Network
                    </span>
                    <h1 class="display-5 fw-bold mb-3" style="line-height: 1.2;">Your Health. Our Priority. Seamless Digital Care.</h1>
                    <p class="lead mb-4 style-muted" style="color: #cbd5e1; font-size: 17px;">Welcome to the centralized medical portal for students, faculty, and clinical operators. Access treatment summaries, manage pharmacy records, and handle triage services efficiently.</p>
                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-md-start">
                        <a href="/login" class="btn btn-light btn-lg px-4 fw-bold" style="color: #0f2d52; border-radius: 8px; font-size: 16px;">
                            Access Patient Dashboard
                        </a>
                        <a href="#services" class="btn btn-outline-light btn-lg px-4" style="border-radius: 8px; font-size: 16px;">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="services" class="container py-5 my-4">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #0f172a;">Integrated Clinical Solutions</h2>
            <p class="text-muted" style="font-size: 15px;">A unified care delivery model for campus safety operations.</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card premium-card p-4 h-100">
                    <div class="icon-box"><i class="fa-solid fa-qrcode"></i></div>
                    <h5 class="fw-bold" style="font-size: 16.5px;">Digital Check-in</h5>
                    <p class="text-muted small mb-0">Instant triage workflow scanning via student ID codes or system-generated barcodes.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card premium-card p-4 h-100">
                    <div class="icon-box"><i class="fa-solid fa-notes-medical"></i></div>
                    <h5 class="fw-bold" style="font-size: 16.5px;">E-Prescriptions</h5>
                    <p class="text-muted small mb-0">Real-time prescription syncing straight from the doctor's desk directly to dispensary queues.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card premium-card p-4 h-100">
                    <div class="icon-box"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <h5 class="fw-bold" style="font-size: 16.5px;">Inventory Tracking</h5>
                    <p class="text-muted small mb-0">Batch level control, low-quantity safety alerts, and automatic near-expiry notifications.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-top py-4 mt-5">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} University Health System. All clinical rights reserved.
        </div>
    </footer>

</body>
</html>
