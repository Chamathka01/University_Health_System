@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-notes-medical me-2 text-primary"></i>My Health Records</h4>
        <div class="breadcrumb-text">Your visit history and prescriptions</div>
    </div>
</div>

<div class="page-body">
<div class="row g-4">

    <!-- Health ID card with barcode -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><i class="fa-solid fa-id-card" style="color:#1a6fc4;"></i> My Health ID</div>
            <div class="card-body text-center">

                <!-- Avatar -->
                <div style="width:60px;height:60px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;color:#1d4ed8;font-size:22px;font-weight:700;margin:0 auto 12px;">
                    {{ strtoupper(substr($user['display_id'] ?? $user['email'], 0, 1)) }}
                </div>

                <div style="font-weight:600;font-size:15px;color:#0f172a;">
                    {{ $user['display_id'] ?? 'N/A' }}
                </div>
                <div style="font-size:12px;color:#64748b;margin:3px 0 8px;">{{ $user['email'] }}</div>
                <span class="badge-status {{ $user['role'] }}">{{ ucfirst($user['role']) }}</span>

                <!-- Barcode -->
                <div class="barcode-wrapper mt-3">
                    <svg id="barcode"></svg>
                    <div style="font-size:11px;color:#64748b;margin-top:6px;">
                        Show to the nurse at the Health Center
                    </div>
                </div>

                <!-- Visit stats -->
                <div class="row g-2 mt-3">
                    <div class="col-6">
                        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px;">
                            <div style="font-size:22px;font-weight:700;color:#0f172a;">{{ $visits->count() }}</div>
                            <div style="font-size:11.5px;color:#64748b;">Total Visits</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div style="background:#f8fafc;border:1px solid #e2e8f0;border-radius:10px;padding:12px;">
                            <div style="font-size:22px;font-weight:700;color:#22c55e;">{{ $visits->where('status','completed')->count() }}</div>
                            <div style="font-size:11.5px;color:#64748b;">Completed</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Visit records -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-clock-rotate-left" style="color:#1a6fc4;"></i> Visit History</div>

            @if(count($visits) == 0)
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-clipboard-list fa-2x mb-3" style="color:#cbd5e1;"></i>
                    <p class="text-muted mb-1">No visits yet.</p>
                    <p style="font-size:13px;color:#94a3b8;">Go to the Health Center and ask the nurse to scan your barcode.</p>
                </div>
            @else
            <div class="table-responsive">
            <table class="table mb-0">
                <thead><tr><th>Date</th><th>Diagnosis</th><th>Prescription</th><th>Report</th><th>Status</th></tr></thead>
                <tbody>
                @foreach($visits as $visit)
                <tr>
                    <td style="white-space:nowrap;font-size:13px;color:#475569;">
                        {{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }}
                        <div style="font-size:11px;color:#94a3b8;">{{ \Carbon\Carbon::parse($visit->visit_date)->format('h:i A') }}</div>
                    </td>
                    <td style="font-size:13px;max-width:160px;">{{ $visit->medicalRecord->diagnosis ?? '—' }}</td>
                    <td style="font-size:13px;max-width:160px;">{{ $visit->medicalRecord->prescription ?? '—' }}</td>
                    <td>
                        @if($visit->medicalRecord && $visit->medicalRecord->report_path)
                            <a href="{{ asset('storage/'.$visit->medicalRecord->report_path) }}"
                               target="_blank" class="btn btn-outline-primary btn-sm" title="Download PDF">
                                <i class="fa-solid fa-file-pdf"></i>
                            </a>
                        @else
                            <span style="color:#cbd5e1;">—</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge-status {{ $visit->status }}">
                            <i class="fa-solid fa-circle-dot fa-xs"></i>
                            {{ ucfirst(str_replace('-',' ',$visit->status)) }}
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
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
    // Barcode value = regno for students, staff_id for staff
    const barcodeValue = "{{ $user['regno'] ?? $user['staff_id'] ?? $user['id'] }}";
    JsBarcode("#barcode", barcodeValue, {
        format:       "CODE128",
        width:        2,
        height:       60,
        displayValue: true,
        fontSize:     13,
        margin:       6,
        lineColor:    "#0f172a"
    });
</script>
@endsection
