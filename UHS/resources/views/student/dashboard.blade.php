@extends('layouts.app')

@section('content')

<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-notes-medical me-2 text-primary"></i>My Health Records</h4>
        <div class="breadcrumb-text">View your previous health records</div>
    </div>
</div>

<div class="page-body">

<div class="row g-4">

    <!-- Visit Records -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-clock-rotate-left" style="color:#1a6fc4;"></i>
                Visit History
            </div>

            @if(count($visits) == 0)
                <div class="card-body text-center py-5">
                    <i class="fa-solid fa-clipboard-list fa-2x mb-3" style="color:#cbd5e1;"></i>
                    <p class="text-muted mb-1">No medical records yet.</p>
                    <p style="font-size:13px;color:#94a3b8;">
                        Visit the Health Center to get your first record.
                    </p>
                </div>
            @else
            <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Visit Date</th>
                        <th>Diagnosis</th>
                        <th>Prescription</th>
                        <th>Report</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($visits as $visit)
                    <tr>
                        <td style="font-size:13px;white-space:nowrap;">
                            {{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }}
                            <div style="font-size:11px;color:#94a3b8;">
                                {{ \Carbon\Carbon::parse($visit->visit_date)->format('h:i A') }}
                            </div>
                        </td>

                        <td style="font-size:13px;max-width:180px;">
                            {{ $visit->medicalRecord->diagnosis ?? '—' }}
                        </td>

                        <td style="font-size:13px;max-width:180px;">
                            {{ $visit->medicalRecord->prescription ?? '—' }}
                        </td>

                        <td>
                            @if($visit->medicalRecord && $visit->medicalRecord->report_path)
                                <a href="{{ asset('storage/'.$visit->medicalRecord->report_path) }}"
                                   target="_blank"
                                   class="btn btn-outline-primary btn-sm">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                            @else
                                <span style="color:#cbd5e1;">—</span>
                            @endif
                        </td>

                        <td>
                            @php $s = $visit->status; @endphp
                            <span class="badge-status {{ $s }}">
                                {{ ucfirst(str_replace('-', ' ', $s)) }}
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
