@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-user-doctor me-2 text-primary"></i>Doctor Dashboard</h4>
        <div class="breadcrumb-text">Patients waiting for consultation this month</div>
    </div>
    <div class="d-flex gap-2">
        <div class="stat-card" style="padding:10px 16px; background:#f0fdf4; border: 1px solid #bbf7d0;">
            <div class="stat-icon green" style="width:34px;height:34px;font-size:15px; background:#dcfce7; color:#16a34a; display:flex; align-items:center; justify-content:center; border-radius:50%;"><i class="fa-solid fa-users"></i></div>
            <div>
                <div class="stat-value" style="font-size:18px; color:#16a34a;">{{ $monthlyVisitsLog->count() }}</div>
                <div class="stat-label" style="font-size:11px; color:#475569;">Monthly Patients</div>
            </div>
        </div>
        <div class="stat-card" style="padding:10px 16px;">
            <div class="stat-icon blue" style="width:34px;height:34px;font-size:15px;"><i class="fa-solid fa-clock"></i></div>
            <div><div class="stat-value" style="font-size:18px;">{{ $visits->where('status','waiting')->count() }}</div><div class="stat-label">Waiting</div></div>
        </div>
        <div class="stat-card" style="padding:10px 16px;">
            <div class="stat-icon amber" style="width:34px;height:34px;font-size:15px;"><i class="fa-solid fa-spinner"></i></div>
            <div><div class="stat-value" style="font-size:18px;">{{ $visits->where('status','in-progress')->count() }}</div><div class="stat-label">In Progress</div></div>
        </div>
    </div>
</div>

<div class="page-body">
    @if(session('success'))
        <div class="alert alert-success mb-4"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header"><i class="fa-solid fa-list-check" style="color:#1a6fc4;"></i> Patient Queue</div>

        @if(count($visits) == 0)
            <div class="card-body text-center py-5">
                <i class="fa-solid fa-circle-check fa-2x mb-3" style="color:#22c55e;"></i>
                <p class="text-muted mb-0">No patients waiting — all clear!</p>
            </div>
        @else
        <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th>#</th><th>Patient ID</th><th>Email</th><th>Role</th><th>Visit Date</th><th>Status</th><th>Action</th></tr></thead>
            <tbody>
            @foreach($visits as $visit)
            @php $patient = $visit->patient; @endphp
            <tr>
                <td style="color:#94a3b8;font-size:12px;">{{ $visit->id }}</td>
                <td>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div style="width:34px;height:34px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;color:#1d4ed8;font-weight:600;font-size:13px;flex-shrink:0;">
                            {{ strtoupper(substr($patient->display_id ?? 'N', 0, 1)) }}
                        </div>
                        <code style="font-size:12.5px;background:#f1f5f9;padding:2px 8px;border-radius:5px;">{{ $patient->display_id ?? 'N/A' }}</code>
                    </div>
                </td>
                <td style="font-size:12.5px;color:#475569;">{{ $patient->email ?? 'N/A' }}</td>
                <td><span class="badge-status {{ $patient->role ?? '' }}">{{ $patient ? ucfirst($patient->role) : 'N/A' }}</span></td>
                <td style="font-size:13px;color:#475569;">{{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y, h:i A') }}</td>
                <td>
                    @if($visit->status=='waiting')
                        <span class="badge-status waiting"><i class="fa-solid fa-circle-dot fa-xs"></i> Waiting</span>
                    @elseif($visit->status=='in-progress')
                        <span class="badge-status in-progress"><i class="fa-solid fa-circle-dot fa-xs"></i> In Progress</span>
                    @endif
                </td>
                <td>
                    @if($visit->status=='waiting')
                        <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-primary btn-sm">
                            <i class="fa-solid fa-stethoscope me-1"></i>Consult
                        </a>
                    @else
                        <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-warning btn-sm" style="background:#f59e0b;border-color:#f59e0b;color:white;">
                            <i class="fa-solid fa-rotate me-1"></i>Continue
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>

    <div class="card mt-4">
        <div class="card-header bg-light"><i class="fa-solid fa-history" style="color:#16a34a;"></i> Monthly Operations Log (Current Month)</div>
        <div class="card-body p-0">
            @if($monthlyVisitsLog->isEmpty())
                <div class="text-center py-4 text-muted">No patient visits recorded during this calendar month.</div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0" style="vertical-align: middle;">
                        <thead class="table-light">
                            <tr>
                                <th>Date / Time</th>
                                <th>Patient ID</th>
                                <th>Email Address</th>
                                <th>Role</th>
                                <th>Diagnosis</th>
                                <th>Prescription</th>
                                <th>Notes</th>
                                <th>Report</th>
                                <th>Final Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($monthlyVisitsLog as $log)
                                @php $patient = $log->patient; @endphp
                                <tr>
                                    <td style="font-size:13px; color:#475569;">
                                        {{ \Carbon\Carbon::parse($log->visit_date)->format('d M Y') }}
                                        <div style="font-size:11px; color:#94a3b8;">{{ \Carbon\Carbon::parse($log->visit_date)->format('h:i A') }}</div>
                                    </td>
                                    <td><code style="font-size:12px; background:#f1f5f9; padding:2px 6px; border-radius:4px;">{{ $patient->display_id ?? 'N/A' }}</code></td>
                                    <td style="font-size:13px;">{{ $patient->email ?? 'N/A' }}</td>
                                    <td><span class="badge-status {{ $patient->role ?? '' }}">{{ $patient ? ucfirst($patient->role) : 'N/A' }}</span></td>
                                    <td style="font-size:12.5px; color:#475569; white-space:pre-wrap; min-width:180px;">{{ $log->medicalRecord->diagnosis ?? '-' }}</td>
                                    <td style="font-size:12.5px; color:#475569; white-space:pre-wrap; min-width:180px;">{{ $log->medicalRecord->prescription ?? '-' }}</td>
                                    <td style="font-size:12.5px; color:#475569; white-space:pre-wrap; min-width:160px;">{{ $log->medicalRecord->notes ?? '-' }}</td>
                                    <td>
                                        @if($log->medicalRecord && $log->medicalRecord->report_path)
                                            <a href="{{ asset('storage/'.$log->medicalRecord->report_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fa-solid fa-file-pdf me-1"></i>View
                                            </a>
                                        @else
                                            <span style="font-size:12.5px;color:#94a3b8;">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge-status {{ $log->status }}">
                                            {{ ucfirst(str_replace('-', ' ', $log->status)) }}
                                        </span>
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
@endsection
