<!DOCTYPE html>
<html>
<head>
    <title>Student Profile</title>

    <style>
        body {
            font-family: Arial;
            padding: 20px;
        }

        .card {
            border: 1px solid #ccc;
            padding: 15px;
            margin-bottom: 15px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>Student Profile</h2>

<div class="card">
    <p><b>Name:</b> {{ $student->firstname }} {{ $student->lastname }}</p>
    <p><b>Reg No:</b> {{ $student->regno }}</p>
    <p><b>Email:</b> {{ $student->email }}</p>
    <p><b>Phone:</b> {{ $student->phone }}</p>
</div>

<h3>Previous Visits</h3>

@foreach($visits as $visit)
    <div class="card">
        <p><b>Date:</b> {{ $visit->created_at }}</p>
        <p><b>Status:</b> {{ $visit->status }}</p>
    </div>
@endforeach

@if(count($visits) == 0)
    <p>No previous visits found.</p>
@endif

<a href="/nurse/visit/create/{{ $student->id }}"
   style="padding:10px;background:green;color:white;text-decoration:none;">
   Create Visit
</a>

</body>
</html>
