<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            margin:20px;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        th, td{
            border:1px solid #ccc;
            padding:10px;
        }

        th{
            background:#f2f2f2;
        }

    </style>
</head>
<body>

<h2>My Medical History</h2>

@if(count($visits) == 0)

    <p>No medical records found.</p>

@else

<table>

    <tr>
        <th>Visit Date</th>
        <th>Diagnosis</th>
        <th>Prescription</th>
        <th>Status</th>
    </tr>

    @foreach($visits as $visit)

    <tr>
        <td>{{ $visit->visit_date }}</td>

        <td>
            {{ $visit->medicalRecord->diagnosis ?? '-' }}
        </td>

        <td>
            {{ $visit->medicalRecord->prescription ?? '-' }}
        </td>

        <td>
            {{ $visit->status }}
        </td>

    </tr>
    @endforeach
</table>
@endif

</body>
</html>
