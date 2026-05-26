<!DOCTYPE html>
<html>
<head>
    <title>Consultation</title>
</head>
<body>

<h2>Consultation</h2>

<h3>
    {{ $visit->student->firstname }}
    {{ $visit->student->lastname }}
</h3>

<p>Reg No: {{ $visit->student->regno }}</p>

<hr>

<h3>Previous Medical History</h3>

@if($history->count() == 0)

    <p>No previous records found.</p>

@else

<table border="1" cellpadding="10">

    <tr>
        <th>Visit Date</th>
        <th>Diagnosis</th>
        <th>Prescription</th>
        <th>Status</th>
    </tr>

    @foreach($history as $record)

    <tr>

        <td>{{ $record->visit_date }}</td>

        <td>
            {{ $record->medicalRecord->diagnosis ?? '-' }}
        </td>

        <td>
            {{ $record->medicalRecord->prescription ?? '-' }}
        </td>

        <td>{{ $record->status }}</td>

    </tr>

    @endforeach

</table>

@endif

<hr>

<form method="POST" action="/doctor/save-consultation">

    @csrf

    <input type="hidden"
           name="visit_id"
           value="{{ $visit->id }}">

    <div>
        <label>Diagnosis</label>
        <br>
        <textarea name="diagnosis"
                  rows="4"
                  cols="60"
                  required></textarea>
    </div>

    <br>

    <div>
        <label>Prescription</label>
        <br>
        <textarea name="prescription"
                  rows="4"
                  cols="60"
                  required></textarea>
    </div>

    <br>

    <div>
        <label>Notes</label>
        <br>
        <textarea name="notes"
                  rows="4"
                  cols="60"></textarea>
    </div>

    <br>

    <button type="submit">
        Save Consultation
    </button>

</form>

</body>
</html>
