@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-stethoscope me-2 text-primary"></i>Nurse Dashboard</h4>
        <div class="breadcrumb-text">Scan patients · manage prescriptions</div>
    </div>
    <span style="background:#dcfce7;color:#166534;padding:6px 14px;border-radius:8px;font-size:12px;font-weight:600;">
        <i class="fa-solid fa-circle-dot me-1" style="color:#22c55e;font-size:9px;"></i>On Duty
    </span>
</div>

<div class="page-body">
    @if(session('success'))
        <div class="alert alert-success mb-4"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        <!-- Scanner panel -->
        <div class="col-md-5">

            <div class="card mb-4">
                <div class="card-header"><i class="fa-solid fa-camera" style="color:#1a6fc4;"></i> Camera Scanner</div>
                <div class="card-body text-center">
                    <div id="reader" style="width:100%;max-width:280px;margin:0 auto;"></div>
                    <button class="btn btn-outline-primary btn-sm mt-3 px-4" onclick="startScanner()">
                        <i class="fa-solid fa-qrcode me-1"></i>Start Camera
                    </button>
                    <button class="btn btn-outline-secondary btn-sm mt-3 ms-2 px-3" onclick="stopScanner()" id="stopBtn" style="display:none;">Stop</button>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><i class="fa-solid fa-magnifying-glass" style="color:#1a6fc4;"></i> Search Patient</div>
                <div class="card-body">
                    <label class="form-label">Reg No or Staff ID</label>
                    <div class="input-group">
                        <input type="text" id="searchInput" class="form-control"
                               placeholder="e.g. 2020ICT01 or STAFF001"
                               onkeydown="if(event.key==='Enter') searchPatient()">
                        <button class="btn btn-primary" onclick="searchPatient()">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>

                    <!-- Patient found -->
                    <div id="patientBox" class="mt-3" style="display:none;">
                        <div class="patient-card">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div style="width:44px;height:44px;border-radius:50%;background:#1a6fc4;display:flex;align-items:center;justify-content:center;color:white;font-size:17px;font-weight:700;" id="pAvatar"></div>
                                <div>
                                    <div style="font-weight:600;font-size:14.5px;" id="pId"></div>
                                    <div style="font-size:12px;color:#475569;" id="pEmail"></div>
                                </div>
                                <span id="pRoleBadge" class="badge-status ms-auto"></span>
                            </div>
                            <a id="createVisitBtn" href="#" class="btn btn-success btn-sm w-100">
                                <i class="fa-solid fa-plus me-1"></i>Create Visit
                            </a>
                        </div>
                    </div>
                    <div id="patientError" class="alert alert-danger mt-3" style="display:none;font-size:13px;"></div>
                </div>
            </div>
        </div>

        <!-- Pending prescriptions -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="fa-solid fa-prescription-bottle-medical" style="color:#1a6fc4;"></i> Pending Prescriptions</span>
                    <span style="background:#fee2e2;color:#991b1b;padding:3px 10px;border-radius:20px;font-size:12px;font-weight:500;">
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
                    <thead><tr><th>Patient ID</th><th>Role</th><th>Status</th><th>Actions</th></tr></thead>
                    <tbody>
                    @foreach($pending as $visit)
                    <tr>
                        <td>
                            <code style="background:#f1f5f9;padding:2px 8px;border-radius:5px;font-size:12px;">
                                {{ $visit->patient->display_id }}
                            </code>
                            <div style="font-size:11.5px;color:#64748b;margin-top:2px;">{{ $visit->patient->email }}</div>
                        </td>
                        <td><span class="badge-status {{ $visit->patient->role }}">{{ ucfirst($visit->patient->role) }}</span></td>
                        <td><span class="badge-status prescription-ready"><i class="fa-solid fa-circle-dot fa-xs"></i> Ready</span></td>
                        <td>
                            <button class="btn btn-outline-primary btn-sm me-1"
                                onclick="viewPrescription(
                                    '{{ $visit->patient->display_id }}',
                                    `{{ addslashes($visit->medicalRecord->diagnosis ?? '-') }}`,
                                    `{{ addslashes($visit->medicalRecord->prescription ?? '-') }}`,
                                    `{{ addslashes($visit->medicalRecord->notes ?? '-') }}`,
                                    '{{ $visit->medicalRecord->report_path ? asset("storage/".$visit->medicalRecord->report_path) : "" }}'
                                )">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <a href="/nurse/complete/{{ $visit->id }}" class="btn btn-success btn-sm">
                                <i class="fa-solid fa-pills me-1"></i>Dispense
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

<!-- Prescription modal -->
<div id="modalBg" style="display:none;position:fixed;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.45);z-index:1000;align-items:center;justify-content:center;">
    <div style="background:white;width:460px;max-width:92vw;border-radius:14px;padding:28px;position:relative;">
        <button onclick="closeModal()" style="position:absolute;top:14px;right:16px;background:none;border:none;font-size:18px;color:#94a3b8;cursor:pointer;"><i class="fa-solid fa-xmark"></i></button>
        <h5 style="font-size:16px;font-weight:700;margin-bottom:16px;color:#0f172a;">
            <i class="fa-solid fa-file-medical me-2 text-primary"></i>Prescription Details
        </h5>
        <table style="width:100%;font-size:13.5px;">
            <tr><td style="color:#64748b;padding:5px 0;width:110px;">Patient ID</td><td><code id="m_id" style="background:#f1f5f9;padding:2px 7px;border-radius:5px;"></code></td></tr>
            <tr><td style="color:#64748b;padding:5px 0;vertical-align:top;">Diagnosis</td><td id="m_diag" style="white-space:pre-wrap;"></td></tr>
            <tr><td style="color:#64748b;padding:5px 0;vertical-align:top;">Prescription</td><td id="m_pres" style="white-space:pre-wrap;"></td></tr>
            <tr><td style="color:#64748b;padding:5px 0;vertical-align:top;">Notes</td><td id="m_notes" style="white-space:pre-wrap;"></td></tr>
        </table>
        <div id="m_report_wrap" class="mt-3" style="display:none;">
            <a id="m_report_link" href="#" target="_blank" class="btn btn-outline-primary btn-sm w-100">
                <i class="fa-solid fa-file-pdf me-1"></i>Download Blood Report PDF
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
let scanner = new Html5Qrcode("reader"), active = false;

function startScanner(){
    Html5Qrcode.getCameras().then(cams=>{
        if(cams.length){
            scanner.start(cams[0].id,{fps:10,qrbox:220},(text)=>{
                document.getElementById('searchInput').value=text;
                scanner.stop().then(()=>{active=false;document.getElementById('stopBtn').style.display='none';});
                searchPatient();
            });
            active=true; document.getElementById('stopBtn').style.display='inline-block';
        }
    });
}
function stopScanner(){ if(active) scanner.stop().then(()=>{active=false;document.getElementById('stopBtn').style.display='none';}); }

function searchPatient(){
    const val=document.getElementById('searchInput').value.trim();
    if(!val) return;
    document.getElementById('patientBox').style.display='none';
    document.getElementById('patientError').style.display='none';

    fetch('/nurse/scan',{
        method:'POST',
        headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},
        body:JSON.stringify({regno:val})
    })
    .then(r=>r.json())
    .then(data=>{
        if(data.error){
            document.getElementById('patientError').innerText=data.error;
            document.getElementById('patientError').style.display='block';
        } else {
            const p=data.patient;
            document.getElementById('pId').innerText=p.display_id;
            document.getElementById('pEmail').innerText=p.email;
            document.getElementById('pAvatar').innerText=p.display_id.charAt(0).toUpperCase();
            const badge=document.getElementById('pRoleBadge');
            badge.innerText=p.role.charAt(0).toUpperCase()+p.role.slice(1);
            badge.className='badge-status '+p.role;
            document.getElementById('createVisitBtn').href='/nurse/visit/create/'+p.id;
            document.getElementById('patientBox').style.display='block';
        }
    });
}

function viewPrescription(id,diag,pres,notes,reportUrl){
    document.getElementById('m_id').innerText=id;
    document.getElementById('m_diag').innerText=diag;
    document.getElementById('m_pres').innerText=pres;
    document.getElementById('m_notes').innerText=notes;
    if(reportUrl){ document.getElementById('m_report_link').href=reportUrl; document.getElementById('m_report_wrap').style.display='block'; }
    else { document.getElementById('m_report_wrap').style.display='none'; }
    document.getElementById('modalBg').style.display='flex';
}
function closeModal(){ document.getElementById('modalBg').style.display='none'; }
</script>
@endsection
