@extends('layouts.app')

@section('content')
<div class="page-header">
    <div>
        <h4><i class="fa-solid fa-user-plus me-2 text-primary"></i>Create User</h4>
        <div class="breadcrumb-text">Register medical staff Google email and assign role</div>
    </div>
</div>

<div class="page-body">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <i class="fa-solid fa-id-card" style="color:#1a6fc4;"></i> User Details
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success mb-3">
                            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('nurse.users.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Google Email Address</label>
                            <input type="email" name="email" class="form-control"
                                   placeholder="name@gmail.com" value="{{ old('email') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select" required>
                                <option value="" disabled selected>Select role</option>
                                <option value="nurse" {{ old('role') == 'nurse' ? 'selected' : '' }}>Nurse</option>
                                <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-floppy-disk me-2"></i>Create User
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
