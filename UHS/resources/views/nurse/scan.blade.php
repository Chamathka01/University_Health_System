<!DOCTYPE html>
<html>
<head>
    <title>Scan Student Barcode</title>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding: 20px;
        }

        #reader {
            width: 300px;
            margin: auto;
        }

        .result {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>

<h2>Scan Student ID</h2>

<div id="reader"></div>

<div class="result" id="result"></div>

<script>

function onScanSuccess(decodedText, decodedResult)
{
    // decodedText = barcode value (regno)

    document.getElementById("result").innerHTML =
        "Scanned: " + decodedText;

    // redirect to Laravel route
    window.location.href =
        "/nurse/student/" + decodedText;
}

let html5QrcodeScanner =
    new Html5QrcodeScanner(
        "reader",
        { fps: 10, qrbox: 250 }
    );

html5QrcodeScanner.render(onScanSuccess);

</script>

<hr>

<h3>Search by Registration Number</h3>

<form method="POST" action="/nurse/search-student">

    @csrf

    <input type="text"
           name="regno"
           placeholder="Enter Registration Number"
           required>

    <button type="submit">
        Search
    </button>

</form>

</body>
</html>
