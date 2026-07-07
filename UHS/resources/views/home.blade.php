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
            font-size: 16.5px;
            background-color: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* Premium Slider Configuration */
        .carousel-item {
            height: 560px;
            min-height: 430px;
            background: #0f2d52;
        }

        /* Sliding Background Images with Dark Transparent Overlay for Text Contrast */

        .slide-1 {
            background: linear-gradient(to right, rgba(10, 37, 64, 0.85) 30%, rgba(26, 111, 196, 0.4)),
                        url('https://images.unsplash.com/photo-1758691463198-dc663b8a64e4?q=80&w=1032&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover no-repeat;
        }

        .slide-2 {
            background: linear-gradient(to right, rgba(10, 37, 64, 0.85) 20%, rgba(114, 170, 225, 0.4)),
                        url('https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&q=80&w=1400') center/cover no-repeat;
        }


        .slide-3 {
            background: linear-gradient(to right, rgba(10, 37, 64, 0.85) 30%, rgba(26, 111, 196, 0.4)),
                        url('https://plus.unsplash.com/premium_photo-1682130157004-057c137d96d5?q=80&w=1032&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') center/cover no-repeat;
        }

        .carousel-caption {
            top: 26%;
            bottom: auto;
            text-align: left;
            max-width: 700px;
            left: 8%;
        }

        /* Floating Structural Overlay Grid Section */
        .overlapping-features {
            margin-top: -70px;
            position: relative;
            z-index: 10;
        }

        .navbar .container {
            max-width: 100% !important;
            padding-left: 4%;
            padding-right: 4%;
        }

        .premium-card {
            background: white;
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 16px -6px rgba(0, 0, 0, 0.03);
            transition: transform 0.25s, box-shadow 0.25s;
        }
        /*.premium-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 30px -10px rgba(0, 0, 0, 0.1);
        }*/
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

        .carousel-indicators {
            bottom: 62px;
            z-index: 11;
            margin-bottom: 0;
        }

        .carousel-indicators [data-bs-target] {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-left: 6px;
            margin-right: 6px;
        }

        /* 1. Style the naked arrows to be larger and clear */
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
            width: 3.5rem;  /* Makes the arrows larger and easier to see */
            height: 3.5rem;
        }

        /* 2. Position the Left Arrow exactly where your blue arrow points */
        .carousel-control-prev {
            left: 4%;       /* Pulls it inward from the left edge */
            right: auto;
            top: 50%;       /* Centers it vertically */
            transform: translateY(-50%);
            bottom: auto;
            width: auto;
            opacity: 0.7;
        }

        /* 3. Position the Right Arrow exactly where your blue arrow points */
        .carousel-control-next {
            right: 4%;      /* Pulls it inward from the right edge */
            left: auto;
            top: 50%;       /* Centers it vertically */
            transform: translateY(-50%);
            bottom: auto;
            width: auto;
            opacity: 0.7;
        }

        /* Make them brighter when hovered */
        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 1;
        }

        #services {
            margin-bottom: 1rem !important;
        }

        #services .mt-5 {
            margin-top: 1.5rem !important;
        }

        footer {
            margin-top: 0 !important;
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
        }

        .nav-link-home {
            color: #475569;
            font-size: 17px;
            font-weight: 600;
            text-decoration: none;
            margin-right: 22px;
        }

        .nav-link-home:hover {
            color: #1a6fc4;
        }

        .home-section {
            padding: 56px 0;
        }

        .section-kicker {
            color: #1a6fc4;
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .section-title {
            color: #0f172a;
            font-size: 31px;
            font-weight: 700;
            margin: 8px 0 10px;
        }

        .role-panel,
        .process-step {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            height: 100%;
            padding: 24px;
        }

        .role-panel i,
        .process-step i {
            color: #1a6fc4;
            font-size: 26px;
            margin-bottom: 14px;
        }

        .process-step {
            position: relative;
        }

        .step-number {
            position: absolute;
            right: 18px;
            top: 16px;
            color: #cbd5e1;
            font-size: 30px;
            font-weight: 700;
        }

        .carousel-caption .badge {
            font-size: 13px !important;
        }

        .carousel-caption .lead {
            font-size: 20px !important;
            line-height: 1.65;
        }

        .premium-card h5,
        .role-panel h5,
        .process-step h5 {
            font-size: 18px !important;
        }

        .premium-card p,
        .role-panel p,
        .process-step p,
        #services p,
        footer .small {
            font-size: 15.5px !important;
            line-height: 1.6;
        }

        #services h4 {
            font-size: 25px !important;
        }

        .support-band .info-pill div:last-child {
            font-size: 15px !important;
            line-height: 1.5;
        }

        .support-band {
            background: #0f2d52;
            color: #e8f1fb;
            padding: 38px 0;
        }

        .support-band .info-pill {
            border: 1px solid rgba(255,255,255,0.22);
            border-radius: 12px;
            padding: 16px 18px;
            height: 100%;
            background: rgba(255,255,255,0.06);
        }

        @media (max-width: 767px) {
            .carousel-item {
                height: 500px;
            }

            .nav-link-home {
                display: none;
            }

            .navbar-brand {
                font-size: 22px !important;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-white bg-white border-bottom py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="#" style="color: #0f2d52; font-size: 35px;">
                <i class="fa-solid fa-hospital-user text-primary"></i> University Health System
            </a>
            <div class="ms-auto d-flex align-items-center">
                <a href="#services" class="nav-link-home">Services</a>
                <a href="#workflow" class="nav-link-home">Workflow</a>
                <a href="/login" class="btn btn-primary px-4 fw-medium" style="background: #1a6fc4; border-radius: 8px; font-size: 17px;">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Sign In
                </a>
            </div>
        </div>
    </nav>

    <div id="healthcareCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#healthcareCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#healthcareCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#healthcareCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active slide-1">
                <div class="container h-100 position-relative">
                    <div class="carousel-caption d-none d-md-block">
                        <span class="badge mb-3 px-3 py-2 text-uppercase fw-bold" style="background: rgba(255,255,255,0.2); color: #e8f1fb; font-size: 12px; letter-spacing: 0.05em;">
                            Official University Medical System Portal
                        </span>
                        <h1 class="display-4 fw-bold mb-3" style="line-height: 1.2;">Your Health. Our Priority..</h1>
                        <p class="lead mb-4" style="color: #cbd5e1; font-size: 18px;">Welcome to the centralized medical portal for University. Access and manage your health profiles</p>
                    </div>

                </div>
            </div>

            <div class="carousel-item slide-2">
                <div class="container h-100 position-relative">
                    <div class="carousel-caption d-none d-md-block">
                        <span class="badge mb-3 px-3 py-2 text-uppercase fw-bold" style="background: rgba(26,111,196,0.4); color: #e8f1fb; font-size: 12px; letter-spacing: 0.05em;">
                            Clinical Staff Portal
                        </span>
                        <h1 class="display-4 fw-bold mb-3" style="line-height: 1.2;">Faster Care Coordination For Every Visit.</h1>
                        <p class="lead mb-4" style="color: #cbd5e1; font-size: 18px;">Doctors and nurses can manage patient queues, consultations, prescriptions, reports, and daily visit records in one connected system.</p>
                    </div>
                </div>
            </div>

            <div class="carousel-item slide-3">
                <div class="container h-100 position-relative">
                    <div class="carousel-caption d-none d-md-block">
                        <span class="badge mb-3 px-3 py-2 text-uppercase fw-bold" style="background: rgba(219,234,254,0.2); color: #e8f1fb; font-size: 12px; letter-spacing: 0.05em;">
                            Medical Dispensary
                        </span>
                        <h1 class="display-4 fw-bold mb-3" style="line-height: 1.2;">Inventory Management</h1>
                        <p class="lead mb-4" style="color: #cbd5e1; font-size: 18px;">Keep close track of clinical stock lines, real-time safety inventory minimum alerts, and secure digital prescription order collections.</p>
                    </div>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#healthcareCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#healthcareCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <section id="services" class="container overlapping-features mb-5">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card premium-card p-4 h-100">
                    <div class="icon-box"><i class="fa-solid fa-qrcode"></i></div>
                    <h5 class="fw-bold" style="font-size: 16.5px; color: #0f172a;">Digital Check-in</h5>
                    <p class="text-muted small mb-0">Instant triage workflow scanning via patient ID or barcodes.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card premium-card p-4 h-100">
                    <div class="icon-box"><i class="fa-solid fa-notes-medical"></i></div>
                    <h5 class="fw-bold" style="font-size: 16.5px; color: #0f172a;">E-Prescriptions</h5>
                    <p class="text-muted small mb-0">Real-time prescription syncing straight from the doctor's desk directly to dispensary queues.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card premium-card p-4 h-100">
                    <div class="icon-box"><i class="fa-solid fa-boxes-stacked"></i></div>
                    <h5 class="fw-bold" style="font-size: 16.5px; color: #0f172a;">Inventory Tracking</h5>
                    <p class="text-muted small mb-0">Batch level control, low-quantity safety alerts, and automatic near-expiry notifications.</p>
                </div>
            </div>
        </div>
        <div class="mt-5 pt-2 text-center">
            <h4 class="fw-bold tracking-tight m-0" style="color: #0f172a; font-size: 22px;">
                Our Integrated Clinical Solutions
            </h4>
            <p class="text-muted small mt-2">A unified digital care delivery framework engineered for university safety and medical operational workflows.</p>
        </div>
    </section>

    <section id="roles" class="home-section bg-white">
        <div class="container">
            <div class="text-center mb-4">
                <div class="section-kicker">Portal Access</div>
                <h2 class="section-title">One system for everyone</h2>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="role-panel">
                        <i class="fa-solid fa-user-nurse"></i>
                        <h5 class="fw-bold" style="font-size:16px;">Nurses</h5>
                        <p class="text-muted small mb-0">Scan patient IDs, create visits, monitor daily queues, and dispense prescriptions.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="role-panel">
                        <i class="fa-solid fa-user-doctor"></i>
                        <h5 class="fw-bold" style="font-size:16px;">Doctors</h5>
                        <p class="text-muted small mb-0">Review medical history of patients, record diagnosis, consultation, and attach clinical reports.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="role-panel">
                        <i class="fa-solid fa-prescription-bottle-medical"></i>
                        <h5 class="fw-bold" style="font-size:16px;">Stock Management</h5>
                        <p class="text-muted small mb-0">Track stock quantity, low-volume alerts, batch details, and expiry risk from one inventory view.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="workflow" class="home-section">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-4">
                    <div class="section-kicker">Care Workflow</div>
                    <h2 class="section-title">From check-in to completed visit</h2>
                    <p class="text-muted mb-0">The system keeps each patient movement visible so medical staff can act faster and avoid duplicate manual records.</p>
                </div>
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="process-step">
                                <div class="step-number">01</div>
                                <i class="fa-solid fa-qrcode"></i>
                                <h5 class="fw-bold" style="font-size:15px;">Check In</h5>
                                <p class="text-muted small mb-0">Nurse scans or searches the patient ID and creates the visit queue entry.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="process-step">
                                <div class="step-number">02</div>
                                <i class="fa-solid fa-stethoscope"></i>
                                <h5 class="fw-bold" style="font-size:15px;">Consult</h5>
                                <p class="text-muted small mb-0">Doctor records diagnosis, notes, medicine list, quantities, and PDF reports.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="process-step">
                                <div class="step-number">03</div>
                                <i class="fa-solid fa-circle-check"></i>
                                <h5 class="fw-bold" style="font-size:15px;">Complete</h5>
                                <p class="text-muted small mb-0">Nurse dispenses medicine and the completed visit stays in the patient history.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="support-band">
        <div class="container">
            <div class="row g-3 align-items-center">
                <div class="col-lg-4">
                    <h3 class="fw-bold mb-2" style="font-size:24px;">University medical support, organized.</h3>
                    <p class="mb-0" style="color:#cbd5e1;">Use the portal for daily medical operations, patient tracking, prescriptions, inventory, and reports.</p>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-pill">
                        <div class="fw-bold"><i class="fa-solid fa-clock me-2"></i>Daily Visit Log</div>
                        <div style="font-size:13px;color:#cbd5e1;margin-top:4px;">Nurses can see current-day patients and final status.</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-3">
                    <div class="info-pill">
                        <div class="fw-bold"><i class="fa-solid fa-calendar-days me-2"></i>Monthly Review</div>
                        <div style="font-size:13px;color:#cbd5e1;margin-top:4px;">Doctors can review monthly patient operations.</div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2">
                    <a href="/login" class="btn btn-light w-100 fw-semibold" style="border-radius:8px;color:#0f2d52;">Sign In</a>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-white border-top py-4 mt-5">
        <div class="container text-center text-muted small">
            &copy; {{ date('Y') }} University Health System. All clinical rights reserved.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
