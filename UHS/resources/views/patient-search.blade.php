@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-magnifying-glass me-2 text-primary"></i>Patient Search</h4>
        <div class="breadcrumb-text">Search student or staff records using registration number or NIC</div>
    </div>
</div>

<div class="page-body">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fa-solid fa-id-card" style="color:#1a6fc4;"></i> Search Patient
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('patients.search') }}" class="row g-2 align-items-end">
                <div class="col-md-9">
                    <label class="form-label">Registration Number or NIC</label>
                    <input type="text" name="q" class="form-control" value="{{ $query }}" placeholder="Example: 2020/ICT/57 or 200023451293" autofocus>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-search me-1"></i> Search
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($query !== '' && ! $patient)
        <div class="alert alert-danger">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>No patient found for "{{ $query }}".
        </div>
    @endif

    @if($patient)
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon blue"><i class="fa-solid fa-user"></i></div>
                    <div>
                        <div class="stat-value" style="font-size:20px;">{{ $patient->name }}</div>
                        <div class="stat-label">{{ ucfirst($patient->role) }}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon green"><i class="fa-solid fa-barcode"></i></div>
                    <div>
                        <div class="stat-value" style="font-size:20px;">{{ $patient->display_id }}</div>
                        <div class="stat-label">Patient ID</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon amber"><i class="fa-solid fa-calendar-check"></i></div>
                    <div>
                        <div class="stat-value" style="font-size:20px;">{{ $patient->visits->count() }}</div>
                        <div class="stat-label">Total Visits</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fa-solid fa-address-card" style="color:#1a6fc4;"></i> Patient Details
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <div style="font-size:12px;color:#64748b;">NIC</div>
                        <div style="font-weight:600;">{{ $patient->nic }}</div>
                    </div>
                    <div class="col-md-3">
                        <div style="font-size:12px;color:#64748b;">Registration Number</div>
                        <div style="font-weight:600;">{{ $patient->reg_no ?? '-' }}</div>
                    </div>
                    <div class="col-md-2">
                        <div style="font-size:12px;color:#64748b;">Gender</div>
                        <div style="font-weight:600;">{{ $patient->gender ?? '-' }}</div>
                    </div>
                    <div class="col-md-2">
                        <div style="font-size:12px;color:#64748b;">City</div>
                        <div style="font-weight:600;">{{ $patient->city ?? '-' }}</div>
                    </div>
                    <div class="col-md-2">
                        <div style="font-size:12px;color:#64748b;">Enrollment Date</div>
                        <div style="font-weight:600;">{{ $patient->enrollment_date ? $patient->enrollment_date->format('d M Y') : '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-notes-medical" style="color:#16a34a;"></i> Visit & Prescription History
            </div>

            @if($patient->visits->isEmpty())
                <div class="card-body text-center py-5 text-muted">No visits recorded for this patient.</div>
            @else
                <div class="table-responsive">
                    <table class="table mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>Date / Time</th>
                                <th>Doctor</th>
                                <th>Nurse</th>
                                <th>Diagnosis</th>
                                <th>Prescription Details</th>
                                <th>Notes</th>
                                <th>Report</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($patient->visits as $visit)
                                @php $record = $visit->medicalRecord; @endphp
                                <tr>
                                    <td style="font-size:13px;color:#475569;vertical-align:top;min-width:110px;">
                                        {{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }}
                                        <div style="font-size:11px;color:#94a3b8;">{{ \Carbon\Carbon::parse($visit->visit_date)->format('h:i A') }}</div>
                                    </td>
                                    <td style="font-size:13px;vertical-align:top;">{{ $visit->doctor->email ?? '-' }}</td>
                                    <td style="font-size:13px;vertical-align:top;">{{ $visit->nurse->email ?? '-' }}</td>
                                    <td style="font-size:12.5px;color:#475569;min-width:220px;vertical-align:top;">
                                        @if($record && $record->icd10_code)
                                            <div style="margin-bottom:6px;line-height:1.5;">
                                                <code style="background:#eff6ff;color:#1d4ed8;padding:2px 6px;border-radius:4px;">{{ $record->icd10_code }}</code>
                                                <span style="color:#64748b;display:block;margin-top:3px;">{{ $record->icd10_description }}</span>
                                            </div>
                                        @endif
                                        <div style="white-space:pre-wrap;line-height:1.5;">{{ $record->diagnosis ?? '-' }}</div>
                                    </td>
                                    <td style="font-size:12.5px;color:#475569;min-width:260px;vertical-align:top;">
                                        @if($record && $record->prescriptionItems->isNotEmpty())
                                            @foreach($record->prescriptionItems as $item)
                                                <div style="padding-bottom:8px;margin-bottom:8px;border-bottom:1px solid #f1f5f9;">
                                                    <div style="font-weight:600;color:#0f172a;">{{ $item->medicine->name ?? 'Medicine removed' }}</div>
                                                    <div style="line-height:1.5;">
                                                        {{ $item->quantity_per_dose }} per meal,
                                                        {{ $item->frequency }},
                                                        {{ $item->meal_timing }},
                                                        {{ $item->duration_days }} days
                                                    </div>
                                                    <div style="font-size:11.5px;color:#64748b;">Total issued: {{ $item->quantity_given }} units</div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div style="white-space:pre-wrap;line-height:1.5;">{{ $record->prescription ?? '-' }}</div>
                                        @endif
                                    </td>
                                    <td style="font-size:12.5px;color:#475569;white-space:pre-wrap;min-width:160px;vertical-align:top;line-height:1.5;">{{ $record->notes ?? '-' }}</td>
                                    <td style="vertical-align:top;">
                                        @if($record && $record->report_path)
                                            <a href="{{ asset('storage/'.$record->report_path) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                <i class="fa-solid fa-file-pdf me-1"></i>View
                                            </a>
                                        @else
                                            <span style="font-size:12.5px;color:#94a3b8;">-</span>
                                        @endif
                                    </td>
                                    <td style="vertical-align:top;">
                                        <span class="badge-status {{ $visit->status }}">
                                            {{ ucfirst(str_replace('-', ' ', $visit->status)) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    @endif
</div>
@endsection
