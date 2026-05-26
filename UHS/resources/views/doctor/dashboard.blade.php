@extends('layouts.app')

@section('content')

<h4>Doctor Dashboard</h4>

<table class="table table-bordered">

    <thead>
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Reg No</th>
            <th>Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        @foreach($visits as $visit)
        <tr>
            <td>{{ $visit->id }}</td>
            <td>{{ $visit->student->firstname }} {{ $visit->student->lastname }}</td>
            <td>{{ $visit->student->regno }}</td>
            <td>{{ $visit->visit_date }}</td>

            <td>
                <!--Patient created by nurse, not yet seen by doctor-->
                @if($visit->status == 'waiting')
                    <span style="color: #b58900; font-weight: bold;">Waiting</span>

                <!--Doctor is currently consulting the patient-->
                @elseif($visit->status == 'in-progress')
                    <span style="color: #0066cc; font-weight: bold;">In Progress</span>

                <!--Doctor completed prescription, waiting for nurse-->
                @elseif($visit->status == 'prescription-ready')
                    <span style="color: #6f42c1; font-weight: bold;">Prescription Ready</span>

                <!--Nurse has finished giving medicine to patient-->
                @elseif($visit->status == 'completed')
                    <span style="color: #198754; font-weight: bold;">Completed</span>

                <!--Unknown status fallback-->
                @else
                    <span style="color: #6c757d;">{{ $visit->status }}</span>
                @endif
            </td>


            <td>
                @if($visit->status == 'waiting')
                    <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-sm btn-dark">
                        Consult  <!--Doctor starts consultation-->
                    </a>

                @elseif($visit->status == 'in-progress')
                    <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-sm btn-primary">
                        Continue <!--Doctor continues consultation-->
                    </a>

                @elseif($visit->status == 'prescription-ready')
                    <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-sm btn-secondary">
                        View Prescription <!--Doctor or nurse checks prescription details-->
                    </a>

                @elseif($visit->status == 'completed')
                    <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-sm btn-success">
                        View Record <!--Final completed medical record-->
                    </a>

                @else
                    <a href="/doctor/consult/{{ $visit->id }}" class="btn btn-sm btn-dark">
                        Open <!--Default fallback action-->
                    </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>

</table>

@endsection
