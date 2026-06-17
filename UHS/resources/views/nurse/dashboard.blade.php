@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-stethoscope me-2 text-primary"></i>Nurse Dashboard</h4>
        <div class="breadcrumb-text">Scan patients and manage prescriptions</div>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2" style="border-radius:8px; font-size:12px; background:#dbeafe !important; color:#1d4ed8 !important;">
            <i class="fa-solid fa-circle-dot me-1" style="color:#22c55e;"></i> On Duty
        </span>
    </div>
</div>

<div class="page-body">

    @if(session('success'))
        <div class="alert alert-success mb-4"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="row g-4">

        <!-- LEFT: Patient Scanner -->
        <div class="col-md-5">

            <!-- Camera Scan -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-camera" style="color:#1a6fc4;"></i> Camera Scanner
                </div>
                <div class="card-body text-center">
                    <div id="reader" style="width:100%; max-width:280px; margin:0 auto;"></div>
                    <button class="btn btn-outline-primary btn-sm mt-3 px-4" onclick="startScanner()">
                        <i class="fa-solid fa-qrcode me-1"></i> Start Camera
                    </button>
                    <button class="btn btn-outline-secondary btn-sm mt-3 ms-2 px-4" onclick="stopScanner()" id="stopBtn" style="display:none;">
                        Stop
                    </button>
                </div>
            </div>

            <!-- Manual Search -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-magnifying-glass" style="color:#1a6fc4;"></i> Search Patient
                </div>
                <div class="card-body">
                    <label class="form-label">Student Reg No or Staff ID</label>
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="e.g. 2020/ICT/01 or STAFF/001"
                               onkeydown="if(event.key==='Enter') searchPatient()">
                        <button class="btn btn-primary" onclick="searchPatient()">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>

                    <!-- Patient Found Card -->
                    <div id="patientBox" class="mt-3" style="display:none;">
                        <div class="patient-card">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:46px;height:46px;border-radius:50%;background:#1a6fc4;display:flex;align-items:center;justify-content:center;color:white;font-size:18px;font-weight:700;" id="patientAvatar">K</div>
                                <div>
                                    <div style="font-weight:600;font-size:15px;color:#0f172a;" id="patientName"></div>
                                    <div style="font-size:12px;color:#475569;" id="patientId"></div>
                                </div>
                                <span id="patientRoleBadge" class="badge-status ms-auto" style="font-size:11px;"></span>
                            </div>
                            <div style="font-size:13px;color:#475569;" id="patientInfo"></div>
                            <div class="mt-3">
                                <a id="createVisitBtn" href="#" class="btn btn-success btn-sm w-100">
                                    <i class="fa-solid fa-plus me-1"></i> Create Visit
                                </a>
                            </div>
                        </div>
                    </div>

                    <div id="patientError" class="alert alert-danger mt-3" style="display:none; font-size:13px;"></div>
                </div>
            </div>
        </div>

        <!-- RIGHT: Pending Prescriptions -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-prescription-bottle-medical" style="color:#1a6fc4;"></i> Pending Prescriptions</span>
                    <span class="badge rounded-pill" style="background:#fee2e2;color:#991b1b;font-size:12px;padding:4px 10px;">
                        {{ count($pending) }} pending
                    </span>
                </div>

                @if(count($pending) == 0)
                    <div class="card-body text-center py-5">
                        <i class="fa-solid fa-check-circle fa-2x mb-3" style="color:#22c55e;"></i>
                        <p class="text-muted mb-0">No pending prescriptions</p>
                    </div>
                @else
                <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>ID</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pending as $visit)
                        <tr>
                            <td>
                                <div style="font-weight:500;font-size:13.5px;">
                                    {{ $visit->patient->email ?? 'No Email Provided' }}
                                </div>
                                <div style="font-size:12px;color:#64748b;">{{ ucfirst($visit->patient->role ?? 'N/A') }}</div>
                            </td>
                            <td>
                                <code style="font-size:12px;background:#f1f5f9;padding:2px 7px;border-radius:5px;">
                                    {{ $visit->patient->regno ?? $visit->patient->staff_id ?? 'No ID' }}
                                </code>
                            </td>
                            <td>
                                <span class="badge-status prescription-ready">
                                    <i class="fa-solid fa-circle-dot fa-xs"></i> Ready
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm me-1"
                                    onclick="viewPrescription(
                                        '{{ $visit->patient->firstname }} {{ $visit->patient->lastname }}',
                                        '{{ $visit->patient->display_id }}',
                                        `{{ addslashes($visit->medicalRecord->diagnosis ?? '-') }}`,
                                        `{{ addslashes($visit->medicalRecord->prescription ?? '-') }}`,
                                        `{{ addslashes($visit->medicalRecord->notes ?? '-') }}`,
                                        '{{ $visit->medicalRecord->report_path ? asset("storage/".$visit->medicalRecord->report_path) : "" }}'
                                    )">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <a href="/nurse/complete/{{ $visit->id }}" class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-pills me-1"></i> Dispense
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Prescription Modal (faux-viewport pattern, no fixed) -->
<div id="modalBackdrop" style="display:none; min-height:400px; background:rgba(0,0,0,0.45); position:fixed; top:0;left:0;right:0;bottom:0; z-index:1000; align-items:center; justify-content:center;">
    <div style="background:white;width:460px;max-width:92vw;border-radius:14px;padding:28px;position:relative;">
        <button onclick="closeModal()" style="position:absolute;top:14px;right:16px;background:none;border:none;font-size:18px;color:#94a3b8;cursor:pointer;">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <h5 style="font-size:16px;font-weight:700;margin-bottom:16px;color:#0f172a;">
            <i class="fa-solid fa-file-medical me-2 text-primary"></i>Prescription Details
        </h5>
        <div class="section-divider" style="margin:0 0 14px;"></div>

        <table style="width:100%;font-size:13.5px;">
            <tr><td style="color:#64748b;padding:5px 0;width:120px;">Patient</td><td style="font-weight:500;" id="m_name"></td></tr>
            <tr><td style="color:#64748b;padding:5px 0;">ID</td><td><code id="m_id" style="background:#f1f5f9;padding:2px 7px;border-radius:5px;"></code></td></tr>
            <tr><td style="color:#64748b;padding:5px 0;vertical-align:top;">Diagnosis</td><td id="m_diag" style="white-space:pre-wrap;"></td></tr>
            <tr><td style="color:#64748b;padding:5px 0;vertical-align:top;">Prescription</td><td id="m_pres" style="white-space:pre-wrap;"></td></tr>
            <tr><td style="color:#64748b;padding:5px 0;vertical-align:top;">Notes</td><td id="m_notes" style="white-space:pre-wrap;"></td></tr>
        </table>

        <div id="m_report_wrap" class="mt-3" style="display:none;">
            <a id="m_report_link" href="#" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                <i class="fa-solid fa-file-pdf me-1"></i> Download Blood Report PDF
            </a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let scanner = new Html5Qrcode("reader");
let scannerActive = false;

function startScanner() {
    Html5Qrcode.getCameras().then(devices => {
        if (devices.length) {
            scanner.start(
                devices[0].id,
                { fps: 10, qrbox: 220 },
                (text) => {
                    document.getElementById('searchInput').value = text;
                    scanner.stop().then(() => { scannerActive = false; document.getElementById('stopBtn').style.display='none'; });
                    searchPatient();
                }
            );
            scannerActive = true;
            document.getElementById('stopBtn').style.display = 'inline-block';
        }
    });
}

function stopScanner() {
    if (scannerActive) scanner.stop().then(() => { scannerActive = false; document.getElementById('stopBtn').style.display='none'; });
}

function searchPatient() {
    const val = document.getElementById('searchInput').value.trim();
    if (!val) return;

    document.getElementById('patientBox').style.display = 'none';
    document.getElementById('patientError').style.display = 'none';

    fetch('/nurse/scan', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ regno: val })
    })
    .then(r => r.json())
    .then(data => {
    if (data.error) {
        document.getElementById('patientError').innerText = data.error;
        document.getElementById('patientError').style.display = 'block';
    } else {
        const p = data.patient;

        // Use Email as the Name since Name doesn't exist
        document.getElementById('patientName').innerText  = p.email;
        document.getElementById('patientId').innerText    = p.display_id;

        // Avatar icon will show the first letter of the email
        document.getElementById('patientAvatar').innerText = p.email.charAt(0).toUpperCase();

        // Clear out the info section since we aren't using phone/dept
        document.getElementById('patientInfo').innerHTML = `<i class="fa-solid fa-tag me-1"></i> ID: ${p.display_id}`;

        const badge = document.getElementById('patientRoleBadge');
        badge.innerText = p.role.charAt(0).toUpperCase() + p.role.slice(1);
        badge.className = `badge-status ${p.role}`;

        // Set the link for the "Create Visit" button
        document.getElementById('createVisitBtn').href = `/nurse/visit/create/${p.id}`;

        // Show the box
        document.getElementById('patientBox').style.display = 'block';
    }
});
}

function viewPrescription(name, id, diag, pres, notes, reportUrl) {
    document.getElementById('m_name').innerText  = name;
    document.getElementById('m_id').innerText    = id;
    document.getElementById('m_diag').innerText  = diag;
    document.getElementById('m_pres').innerText  = pres;
    document.getElementById('m_notes').innerText = notes;
    if (reportUrl) {
        document.getElementById('m_report_link').href = reportUrl;
        document.getElementById('m_report_wrap').style.display = 'block';
    } else {
        document.getElementById('m_report_wrap').style.display = 'none';
    }
    document.getElementById('modalBackdrop').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modalBackdrop').style.display = 'none';
}
</script>
@endsection
