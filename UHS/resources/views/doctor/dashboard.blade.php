<!DOCTYPE html>
<html>
<head>
    <title>Doctor Dashboard</title>

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

<h2>Waiting Patients</h2>

<table>

    <tr>
        <th>Visit ID</th>
        <th>Student Name</th>
        <th>Reg No</th>
        <th>Visit Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>

    @foreach($visits as $visit)

    <tr>
        <td>{{ $visit->id }}</td>

        <td>
            {{ $visit->student->firstname }}
            {{ $visit->student->lastname }}
        </td>

        <td>{{ $visit->student->regno }}</td>

        <td>{{ $visit->visit_date }}</td>

        <td>{{ $visit->status }}</td>

        <td>
            <a href="/doctor/consult/{{ $visit->id }}">
                Consult
            </a>
        </td>

    </tr>

    @endforeach

</table>

</body>
</html>
