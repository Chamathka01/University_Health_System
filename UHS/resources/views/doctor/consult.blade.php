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
