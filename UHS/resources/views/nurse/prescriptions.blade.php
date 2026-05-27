<!DOCTYPE html>
<html>
<head>
    <title>Ready Prescriptions</title>

    <style>
        table{
            width:100%;
            border-collapse: collapse;
        }

        th,td{
            border:1px solid #ccc;
            padding:10px;
        }

        th{
            background:#f2f2f2;
        }
    </style>
</head>
<body>

<h2>Prescriptions Ready for Dispensing</h2>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

<table>

<tr>
    <th>Student</th>
    <th>Reg No</th>
    <th>Diagnosis</th>
    <th>Prescription</th>
    <th>Action</th>
</tr>

@foreach($visits as $visit)

<tr>

    <td>
        {{ $visit->student->firstname }}
        {{ $visit->student->lastname }}
    </td>

    <td>
        {{ $visit->student->regno }}
    </td>

    <td>
        {{ $visit->medicalRecord->diagnosis }}
    </td>

    <td>
        {{ $visit->medicalRecord->prescription }}
    </td>

    <td>
        <a href="/nurse/complete/{{ $visit->id }}">
            Dispense Medicine
        </a>
    </td>

</tr>

@endforeach

</table>

</body>
</html>
