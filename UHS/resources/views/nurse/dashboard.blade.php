@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-stethoscope me-2 text-primary"></i>Nurse Dashboard</h4>
        <div class="breadcrumb-text">Scan patients and manage prescriptions for today</div>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge fw-semibold px-3 py-2" style="border-radius:8px; font-size:12px; background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0;">
            <i class="fa-solid fa-users me-1"></i> Today's Patients: {{ $todaysVisits->count() }}
        </span>
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

        <div class="col-md-5">

            <div class="card mb-4">
                <div class="card-header">
                    <i class="fa-solid fa-camera" style="color:#1a6fc4;"></i> Barcode Scanner
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
                                    <i class="fa-solid fa-circle-dot fa-xs"></i> Prescription Ready
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

    <div class="row mt-4" id="todaysPatientsSection">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-calendar-day text-success me-2"></i>Today's Total Registered Patients Log</span>
                    <span class="badge bg-success text-white px-2 py-1 rounded">{{ $todaysVisits->count() }} Records</span>
                </div>
                <div class="card-body p-0">
                    @if($todaysVisits->isEmpty())
                        <div class="text-center py-4 text-muted">No patients checked in yet today.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Time</th>
                                        <th>Patient ID</th>
                                        <th>Email Address</th>
                                        <th>Type</th>
                                        <th>Diagnosis</th>
                                        <th>Prescription</th>
                                        <th>Notes</th>
                                        <th>Report</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todaysVisits as $v)
                                        <tr>
                                            <td style="font-size:13px; color:#475569;">{{ \Carbon\Carbon::parse($v->visit_date)->format('h:i A') }}</td>
                                            <td><code style="font-size:12px; background:#f1f5f9; padding:2px 6px; border-radius:4px;">{{ $v->patient->regno ?? $v->patient->staff_id ?? 'N/A' }}</code></td>
                                            <td style="font-size:13px;">{{ $v->patient->email ?? '—' }}</td>
                                            <td><span class="badge-status {{ $v->patient->role ?? '' }}">{{ ucfirst($v->patient->role ?? 'N/A') }}</span></td>
                                            <td style="font-size:12.5px; color:#475569; white-space:pre-wrap; min-width:180px;">{{ $v->medicalRecord->diagnosis ?? '-' }}</td>
                                            <td style="font-size:12.5px; color:#475569; white-space:pre-wrap; min-width:180px;">{{ $v->medicalRecord->prescription ?? '-' }}</td>
                                            <td style="font-size:12.5px; color:#475569; white-space:pre-wrap; min-width:160px;">{{ $v->medicalRecord->notes ?? '-' }}</td>
                                            <td>
                                                @if($v->medicalRecord && $v->medicalRecord->report_path)
                                                    <a href="{{ asset('storage/'.$v->medicalRecord->report_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                        <i class="fa-solid fa-file-pdf me-1"></i>View
                                                    </a>
                                                @else
                                                    <span style="font-size:12.5px;color:#94a3b8;">-</span>
                                                @endif
                                            </td>
                                            <td>
    @if($v->status == 'waiting')
        <span class="badge bg-secondary-subtle text-secondary px-2 py-1" style="border-radius: 6px; font-size: 12px; background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;">
            <i class="fa-solid fa-clock me-1 text-muted"></i> Waiting in Queue
        </span>
    @elseif($v->status == 'in-progress')
        <span class="badge bg-warning-subtle text-warning px-2 py-1" style="border-radius: 6px; font-size: 12px; background: #fffbeb; color: #b45309; border: 1px solid #fde68a;">
            <i class="fa-solid fa-spinner fa-spin me-1 text-warning"></i> In Progress
        </span>
    @elseif($v->status == 'prescription-ready' || $v->status == 'ready')
        <span class="badge bg-info-subtle text-info px-2 py-1" style="border-radius: 6px; font-size: 12px; background: #ecfeff; color: #0e7490; border: 1px solid #a5f3fc;">
            <i class="fa-solid fa-notes-medical me-1 text-info"></i> Prescription Ready
        </span>
    @else
        <span class="badge bg-success-subtle text-success px-2 py-1" style="border-radius: 6px; font-size: 12px; background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0;">
            <i class="fa-solid fa-circle-check me-1 text-success"></i> Completed
        </span>
    @endif
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

</div>

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
                <i class="fa-solid fa-file-pdf me-1"></i> Download Report PDF
            </a>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let scanner = new Html5Qrcode("reader", {
    formatsToSupport: [
        Html5QrcodeSupportedFormats.QR_CODE,
        Html5QrcodeSupportedFormats.CODE_128,
        Html5QrcodeSupportedFormats.CODE_39,
        Html5QrcodeSupportedFormats.EAN_13,
        Html5QrcodeSupportedFormats.EAN_8,
        Html5QrcodeSupportedFormats.UPC_A,
        Html5QrcodeSupportedFormats.UPC_E,
        Html5QrcodeSupportedFormats.ITF
    ]
});
let scannerActive = false;

function startScanner() {
    Html5Qrcode.getCameras().then(devices => {
        if (devices.length) {
            scanner.start(
                devices[0].id,
                {
                    fps: 15, qrbox: { width: 250, height: 150 }
                },
                (text) => {
                    document.getElementById('searchInput').value = text;
                    scanner.stop().then(() => { scannerActive = false; document.getElementById('stopBtn').style.display='none'; });
                    searchPatient();
                }
                ).catch(err => {
                console.error("Scanner failed to start: ", err);
            });
            scannerActive = true;
            document.getElementById('stopBtn').style.display = 'inline-block';
        }
    }).catch(err => {
        console.error("No camera devices found: ", err);
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

        document.getElementById('patientName').innerText  = p.email;
        document.getElementById('patientId').innerText    = p.display_id;
        document.getElementById('patientAvatar').innerText = p.email.charAt(0).toUpperCase();
        document.getElementById('patientInfo').innerHTML = `<i class="fa-solid fa-tag me-1"></i> ID: ${p.display_id}`;

        const badge = document.getElementById('patientRoleBadge');
        badge.innerText = p.role.charAt(0).toUpperCase() + p.role.slice(1);
        badge.className = `badge-status ${p.role}`;

        document.getElementById('createVisitBtn').href = `/nurse/visit/create/${p.id}`;
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
