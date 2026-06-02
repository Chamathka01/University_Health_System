@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-user-doctor me-2 text-primary"></i>Doctor Dashboard</h4>
        <div class="breadcrumb-text">Patients waiting for consultation</div>
    </div>
    <div class="d-flex gap-2">
        <div class="stat-card" style="padding:10px 16px;">
            <div class="stat-icon blue" style="width:34px;height:34px;font-size:15px;"><i class="fa-solid fa-clock"></i></div>
            <div>
                <div class="stat-value" style="font-size:18px;">{{ $visits->where('status','waiting')->count() }}</div>
                <div class="stat-label">Waiting</div>
            </div>
        </div>
        <div class="stat-card" style="padding:10px 16px;">
            <div class="stat-icon amber" style="width:34px;height:34px;font-size:15px;"><i class="fa-solid fa-spinner"></i></div>
            <div>
                <div class="stat-value" style="font-size:18px;">{{ $visits->where('status','in-progress')->count() }}</div>
                <div class="stat-label">In Progress</div>
            </div>
        </div>
    </div>
</div>

<div class="page-body">

    @if(session('success'))
        <div class="alert alert-success mb-4"><i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="fa-solid fa-list-check" style="color:#1a6fc4;"></i> Patient Queue
        </div>

        @if(count($visits) == 0)
            <div class="card-body text-center py-5">
                <i class="fa-solid fa-circle-check fa-2x mb-3" style="color:#22c55e;"></i>
                <p class="text-muted mb-0">No patients waiting — you're all caught up!</p>
            </div>
        @else
        <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient</th>
                    <th>ID / Reg No</th>
                    <th>Role</th>
                    <th>Visit Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visits as $visit)
                <tr>
                    <td style="color:#94a3b8;font-size:12px;">{{ $visit->id }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px;">
                            <div style="width:34px;height:34px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;color:#1d4ed8;font-weight:600;font-size:13px;flex-shrink:0;">
                                {{ strtoupper(substr($visit->student->firstname, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight:500;font-size:13.5px;">{{ $visit->student->firstname }} {{ $visit->student->lastname }}</div>
                                <div style="font-size:11.5px;color:#64748b;">{{ $visit->student->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <code style="font-size:12px;background:#f1f5f9;padding:2px 8px;border-radius:5px;">
                            {{ $visit->student->display_id }}
                        </code>
                    </td>
                    <td>
                        <span class="badge-status {{ $visit->student->role }}">
                            {{ ucfirst($visit->student->role) }}
                        </span>
                    </td>
                    <td style="font-size:13px;color:#475569;">
                        {{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y, h:i A') }}
                    </td>
                    <td>
                        @if($visit->status == 'waiting')
                            <span class="badge-status waiting"><i class="fa-solid fa-circle-dot fa-xs"></i> Waiting</span>
                        @elseif($visit->status == 'in-progress')
                            <span class="badge-status in-progress"><i class="fa-solid fa-circle-dot fa-xs"></i> In Progress</span>
                        @else
                            <span class="badge-status">{{ $visit->status }}</span>
                        @endif
                    </td>
                    <td>
                        @if($visit->status == 'waiting')
                            <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-primary btn-sm">
                                <i class="fa-solid fa-stethoscope me-1"></i> Consult
                            </a>
                        @elseif($visit->status == 'in-progress')
                            <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-warning btn-sm" style="background:#f59e0b;border-color:#f59e0b;color:white;">
                                <i class="fa-solid fa-rotate me-1"></i> Continue
                            </a>
                        @else
                            <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fa-solid fa-eye me-1"></i> View
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
</div>

@endsection
