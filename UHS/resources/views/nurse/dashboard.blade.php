<!DOCTYPE html>
<html>
<head>
    <title>Nurse Dashboard</title>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body { font-family: Arial; background:#fff; color:#000; }
        .container { padding:20px; }

        .box {
            border:1px solid #000;
            padding:15px;
            margin-bottom:20px;
        }

        input {
            padding:8px;
            width:250px;
        }

        button {
            padding:8px 12px;
            border:1px solid #000;
            background:#fff;
            cursor:pointer;
        }

        button:hover {
            background:#000;
            color:#fff;
        }

        table {
            width:100%;
            border-collapse:collapse;
        }

        th,td {
            border:1px solid #000;
            padding:10px;
        }

        .topbar {
            display:flex;
            justify-content:space-between;
            align-items:center;
         }
        .prescription-box {
            font-size: 13px;
        }

    </style>
</head>

<body>

<div class="container">

    <!-- TOP BAR -->
    <div class="topbar">
        <h2>Nurse Dashboard</h2>

        <a href="/logout">
            <button>Logout</button>
        </a>
    </div>

    <!-- CAMERA SCANNER -->
    <div class="box">
        <h3>Camera Scan</h3>

        <button onclick="startScanner()">Start Camera Scan</button>

        <div id="reader" style="width:300px; margin-top:10px;"></div>
    </div>

    <!-- MANUAL SEARCH -->
    <div class="box">
        <h3>Search Student</h3>

        <input type="text" id="regno" placeholder="Enter Reg No">
        <button onclick="searchStudent()">Search</button>

        <div id="studentBox"></div>
    </div>

    <!-- PENDING PRESCRIPTIONS -->
    <div class="box">
        <h3>Pending Prescriptions</h3>

        <table>
    <tr>
        <th>Student</th>
        <th>Reg No</th>
        <th>Status</th>
        <th>View</th>
        <th>Action</th>
    </tr>

    @foreach($pending as $visit)
    <tr>

        <td>{{ $visit->student->firstname }}</td>

        <td>{{ $visit->student->regno }}</td>

        <td>{{ $visit->status }}</td>

        <td>
            <button onclick="viewPrescription(
                '{{ $visit->student->firstname }}',
                '{{ $visit->student->regno }}',
                `{{ $visit->medicalRecord->diagnosis ?? '-' }}`,
                `{{ $visit->medicalRecord->prescription ?? '-' }}`,
                `{{ $visit->medicalRecord->notes ?? '-' }}`
            )">
                View
            </button>
        </td>

        <td>
            <a href="/nurse/complete/{{ $visit->id }}">
                <button>Give Medicine</button>
            </a>
        </td>

    </tr>
    @endforeach

</table>
    </div>

</div>

<!-- PRESCRIPTION MODAL -->
<div id="modal" style="
    display:none;
    position:fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background:rgba(0,0,0,0.5);
">

    <div style="
        background:#fff;
        width:400px;
        margin:100px auto;
        padding:20px;
        border:1px solid #000;
    ">

        <h3>Prescription Details</h3>

        <p><strong>Student:</strong> <span id="m_student"></span></p>
        <p><strong>Reg No:</strong> <span id="m_regno"></span></p>
        <p><strong>Diagnosis:</strong><br> <span id="m_diag"></span></p>
        <p><strong>Prescription:</strong><br> <span id="m_pres"></span></p>
        <p><strong>Notes:</strong><br> <span id="m_notes"></span></p>

        <button onclick="closeModal()">Close</button>

    </div>
</div>

<script>

/* ===================== */
/* CAMERA SCANNER */
/* ===================== */

let scanner = new Html5Qrcode("reader");

function startScanner()
{

    Html5Qrcode.getCameras().then(devices => {

        if(devices.length){

            scanner.start(
                devices[0].id,
                { fps: 10, qrbox: 250 },
                (text) => {

                    document.getElementById('regno').value = text;

                    scanner.stop();

                    searchStudent();
                }
            );
        }
    });
}

/* ===================== */
/* MANUAL SEARCH*/
/* ===================== */

function searchStudent()
{
    let regno = document.getElementById('regno').value;

    fetch('/nurse/scan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ regno: regno })
    })
    .then(res => res.json())
    .then(data => {

        if(data.error)
        {
            document.getElementById('studentBox').innerHTML =
                "<p style='color:red'>" + data.error + "</p>";
        }
        else
        {
            document.getElementById('studentBox').innerHTML =
                "<h4>Student Found</h4>" +
                "<p>Name: " + data.student.firstname + "</p>" +
                "<p>Reg No: " + data.student.regno + "</p>" +
                "<a href='/nurse/visit/create/" + data.student.id + "'>" +
                "<button>Create Visit</button></a>";
        }
    });
}

function viewPrescription(name, regno, diagnosis, prescription, notes)
{
    document.getElementById('m_student').innerText = name;
    document.getElementById('m_regno').innerText = regno;
    document.getElementById('m_diag').innerText = diagnosis;
    document.getElementById('m_pres').innerText = prescription;
    document.getElementById('m_notes').innerText = notes;

    document.getElementById('modal').style.display = "block";
}

function closeModal()
{
    document.getElementById('modal').style.display = "none";
}

</script>

</body>
</html>
