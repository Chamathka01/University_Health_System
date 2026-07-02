@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-stethoscope me-2 text-primary"></i>Consultation</h4>
        <div class="breadcrumb-text">
            <a href="/doctor/dashboard" style="color:#1a6fc4;text-decoration:none;">Dashboard</a>
            <i class="fa-solid fa-chevron-right fa-xs mx-1" style="color:#94a3b8;"></i> Consult Patient
        </div>
    </div>
</div>

<div class="page-body">
<div class="row g-4">

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header"><i class="fa-solid fa-user" style="color:#1a6fc4;"></i> Patient Info</div>
            <div class="card-body text-center">
                <div style="width:60px;height:60px;border-radius:50%;background:#dbeafe;display:flex;align-items:center;justify-content:center;color:#1d4ed8;font-size:22px;font-weight:700;margin:0 auto 10px;">
                    {{ strtoupper(substr($visit->patient->display_id, 0, 1)) }}
                </div>
                <div style="font-weight:600;font-size:15px;">{{ $visit->patient->display_id }}</div>
                <div style="font-size:12px;color:#64748b;margin:4px 0;">{{ $visit->patient->email }}</div>
                <span class="badge-status {{ $visit->patient->role }}">{{ ucfirst($visit->patient->role) }}</span>

                <div class="section-divider"></div>

                <table style="width:100%;font-size:13px;text-align:left;">
                    <tr>
                        <td style="color:#64748b;padding:5px 0;width:80px;">Visit</td>
                        <td>{{ \Carbon\Carbon::parse($visit->visit_date)->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <td style="color:#64748b;padding:5px 0;">Status</td>
                        <td><span class="badge-status in-progress">In Progress</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><i class="fa-solid fa-clock-rotate-left" style="color:#1a6fc4;"></i> Visit History</div>
            @if($history->count() == 0)
                <div class="card-body text-center py-4" style="font-size:13px;color:#94a3b8;">No previous visits</div>
            @else
            <div style="max-height:300px;overflow-y:auto;">
                @foreach($history as $h)
                <div style="padding:12px 16px;border-bottom:1px solid #f1f5f9;">
                    <div style="font-size:11.5px;color:#64748b;margin-bottom:3px;">
                        {{ \Carbon\Carbon::parse($h->visit_date)->format('d M Y') }}
                        <span class="badge-status completed ms-1" style="font-size:10px;">Done</span>
                    </div>
                    @if($h->medicalRecord)
                        <div style="font-size:12.5px;font-weight:500;">{{ Str::limit($h->medicalRecord->diagnosis, 60) }}</div>
                        <div style="font-size:12px;color:#475569;">{{ Str::limit($h->medicalRecord->prescription, 80) }}</div>
                        @if($h->medicalRecord->report_path)
                            <a href="{{ asset('storage/'.$h->medicalRecord->report_path) }}" target="_blank" style="font-size:11.5px;color:#1a6fc4;">
                                <i class="fa-solid fa-file-pdf"></i> Report
                            </a>
                        @endif
                    @endif
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><i class="fa-solid fa-file-medical" style="color:#1a6fc4;"></i> New Consultation</div>
            <div class="card-body">
                <form method="POST" action="/doctor/save-consultation" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="visit_id" value="{{ $visit->id }}">

                    <div class="mb-3">
                        <label class="form-label">Diagnosis <span style="color:#ef4444;">*</span></label>
                        <textarea name="diagnosis" class="form-control" rows="4"
                                  placeholder="Describe the patient's condition, symptoms and findings..."
                                  required>{{ old('diagnosis') }}</textarea>
                    </div>

                    @php
                        $oldMedicineIds = old('medicine_id', ['']);
                        $oldQuantities = old('quantity_given', ['']);
                    @endphp

                    <div class="mb-3">
                        <label class="form-label">Prescription / Medicine Selection <span style="color:#ef4444;">*</span></label>
                        <div id="medicineRows">
                            @foreach($oldMedicineIds as $index => $oldMedicineId)
                            <div class="medicine-row row g-2 mb-2 align-items-start">
                                <div class="col-md-7">
                                    <select name="medicine_id[]" class="form-select searchable-medicine" required>
                                        <option value="" disabled {{ $oldMedicineId ? '' : 'selected' }}>-- Select Stock Medicine --</option>
                                        @foreach($availableMedicines as $med)
                                            <option value="{{ $med->id }}" {{ (string) $oldMedicineId === (string) $med->id ? 'selected' : '' }}>
                                                {{ $med->name }} (Available: {{ $med->stock_quantity }} units)
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="quantity_given[]" class="form-control"
                                           placeholder="Quantity" min="1" value="{{ $oldQuantities[$index] ?? '' }}" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-outline-danger w-100 remove-medicine-row" title="Remove medicine">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <button type="button" id="addMedicineRow" class="btn btn-outline-primary btn-sm mt-1">
                            <i class="fa-solid fa-plus me-1"></i>Add Another Medicine
                        </button>
                    </div>

                    <template id="medicineRowTemplate">
                        <div class="medicine-row row g-2 mb-2 align-items-start">
                            <div class="col-md-7">
                                <select name="medicine_id[]" class="form-select searchable-medicine" required>
                                    <option value="" disabled selected>-- Select Stock Medicine --</option>
                                    @foreach($availableMedicines as $med)
                                        <option value="{{ $med->id }}">
                                            {{ $med->name }} (Available: {{ $med->stock_quantity }} units)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="number" name="quantity_given[]" class="form-control"
                                       placeholder="Quantity" min="1" required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-outline-danger w-100 remove-medicine-row" title="Remove medicine">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>

                    <div class="mb-3">
                        <label class="form-label">Additional Notes</label>
                        <textarea name="notes" class="form-control" rows="3"
                                  placeholder="Optional: follow-up, dosage guidelines, diet, rest...">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mb-4" style="background:#fafafa;border:1px dashed #cbd5e1;border-radius:10px;padding:16px;">
                        <label class="form-label">
                            <i class="fa-solid fa-file-pdf me-1" style="color:#ef4444;"></i>
                            Upload Blood / Lab Report (PDF, max 5 MB)
                        </label>
                        <input type="file" name="report" class="form-control" accept=".pdf">
                        <div style="font-size:12px;color:#64748b;margin-top:6px;">
                            Attach the lab report if available
                        </div>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger mb-3">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Save Consultation
                        </button>
                        <a href="/doctor/dashboard" class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        function initializeMedicineSelect(selector) {
            $(selector).select2({
                theme: 'bootstrap-5',
                placeholder: '-- Type to search medicine --',
                allowClear: false,
                width: '100%'
            });
        }

        function updateRemoveButtons() {
            const rowCount = $('.medicine-row').length;
            $('.remove-medicine-row').prop('disabled', rowCount === 1);
        }

        initializeMedicineSelect('.searchable-medicine');
        updateRemoveButtons();

        $('#addMedicineRow').on('click', function() {
            const row = $($('#medicineRowTemplate').html());
            $('#medicineRows').append(row);
            initializeMedicineSelect(row.find('.searchable-medicine'));
            updateRemoveButtons();
        });

        $('#medicineRows').on('click', '.remove-medicine-row', function() {
            if ($('.medicine-row').length === 1) {
                return;
            }

            $(this).closest('.medicine-row').find('.searchable-medicine').select2('destroy');
            $(this).closest('.medicine-row').remove();
            updateRemoveButtons();
        });
    });
</script>

@endsection
