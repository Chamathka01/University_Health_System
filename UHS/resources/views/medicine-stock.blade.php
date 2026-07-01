@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h4>Medicine Stock Management</h4>
        <div class="breadcrumb-text">Inventory Logistics / Live Database List Tracker</div>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMedicineModal">
        <i class="fa-solid fa-plus me-2"></i>Register New Stock Batch
    </button>
</div>

<div class="page-body">
    @if(session('success'))
        <div class="alert alert-success mb-4 d-flex align-items-center">
            <i class="fa-solid fa-circle-check me-2"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @php
        $nearExpiryCount = $medicines->filter(function($item) {
            $expiry = \Carbon\Carbon::parse($item->expiry_date);
            return !$expiry->isPast() && \Carbon\Carbon::now()->diffInDays($expiry) <= 30;
        })->count();

        $expiredCount = $medicines->filter(function($item) {
            return \Carbon\Carbon::parse($item->expiry_date)->isPast();
        })->count();
    @endphp

    @if($expiredCount > 0 || $nearExpiryCount > 0)
        <div class="alert alert-warning border-start border-warning border-4 mb-4 shadow-sm p-3 bg-white">
            <h5 class="alert-heading fw-bold text-dark mb-1">
                <i class="fa-solid fa-circle-exclamation me-2 text-warning"></i>Attention: Inventory Risks Detected
            </h5>
            <p class="mb-0 text-secondary" style="font-size: 13.5px;">
                Currently, there are <strong class="text-danger">{{ $expiredCount }} batches completely expired</strong> and
                <strong class="text-warning text-dark">{{ $nearExpiryCount }} batches expiring within the next 30 days</strong>.
                Please inspect highlighted rows below to ensure safe clinical distributions.
            </p>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-white fw-bold">
            <i class="fa-solid fa-boxes-stacked me-2 text-primary"></i>Current Dispensary List
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th>Medicine Name</th>
                        <th>Batch Code</th>
                        <th>Expiry Date</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 180px;">Current Quantity</th>
                        <th class="text-center">Modify Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medicines as $item)
                    @php
                            $expiryDate = \Carbon\Carbon::parse($item->expiry_date);
                            $daysRemaining = \Carbon\Carbon::now()->diffInDays($expiryDate, false);
                        @endphp
                        <tr>
                            <td class="fw-semibold text-dark">{{ $item->name }}</td>
                            <td><code class="text-secondary small fw-bold">{{ $item->batch_number }}</code></td>
                            <td>
                                @if($expiryDate->isPast())
                                    <span class="text-danger fw-bold" title="Expired!">
                                        <i class="fa-solid fa-triangle-exclamation me-1"></i>{{ $item->expiry_date }}
                                    </span>
                                @elseif($daysRemaining <= 30)
                                    <span class="text-warning fw-bold" title="Expires in {{ $daysRemaining }} days!">
                                        <i class="fa-solid fa-hourglass-half me-1"></i>{{ $item->expiry_date }}
                                    </span>
                                @else
                                    <span class="text-success">
                                        {{ $item->expiry_date }}
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($expiryDate->isPast())
                                    <span class="badge bg-danger text-white px-2 py-1" style="font-size: 11px; font-weight: 600;">EXPIRED</span>
                                @elseif($daysRemaining <= 30)
                                    <span class="badge bg-warning text-dark px-2 py-1" style="font-size: 11px; font-weight: 600;">Expiring Soon</span>
                                @elseif($item->stock_quantity <= 0)
                                    <span class="badge bg-danger text-white px-2 py-1" style="font-size: 11px; font-weight: 600;">Out of Stock</span>
                                @elseif($item->stock_quantity <= $item->min_required_alert)
                                    <span class="badge bg-info text-dark px-2 py-1" style="font-size: 11px; font-weight: 600;">Low Volume Alert</span>
                                @else
                                    <span class="badge bg-success text-white px-2 py-1" style="font-size: 11px; font-weight: 600;">Optimal Supply</span>
                                @endif
                            </td>

                            <td class="text-center fw-bold fs-5">{{ $item->stock_quantity }} units</td>
                            <td class="text-center">
                                <form action="/medicine-stock/update/{{ $item->id }}" method="POST" class="d-inline-flex gap-2 align-items-center justify-content-center">
                                    @csrf
                                    <input type="number" name="stock_quantity" class="form-control form-control-sm text-center" style="width: 80px;" value="{{ $item->stock_quantity }}" min="0" required>
                                    <button type="submit" class="btn btn-sm btn-outline-primary py-1 px-2" title="Save update">
                                        <i class="fa-solid fa-floppy-disk"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fa-solid fa-capsules d-block fs-1 mb-2 text-light"></i>
                                No prescription medicine batches found currently resting inside inventory registers.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="addMedicineModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: 2px solid #000000; overflow:hidden;">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold text-dark"><i class="fa-solid fa-prescription-bottle-medical me-2 text-primary"></i>Register Supply</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('stock.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">Medicine Generic Title Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Paracetamol 500mg" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">Batch Lot Control Number</label>
                        <input type="text" name="batch_number" class="form-control" placeholder="e.g. BATCH-2026-X9" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-bold">Initial Item Volume</label>
                            <input type="number" name="stock_quantity" class="form-control" placeholder="100" min="0" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-dark fw-bold">Low Alert Limit</label>
                            <input type="number" name="min_required_alert" class="form-control" value="15" min="0" required>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label text-dark fw-bold">Manufacturer Expiry Deadline</label>
                        <input type="date" name="expiry_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary text-white btn-sm px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm px-4">Commit Inventory to Logs</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
