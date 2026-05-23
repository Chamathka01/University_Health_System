<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <title>Register page</title>

    <style>
    body {
        min-height: 100vh;
        background: linear-gradient(135deg, #a0a0a0, #7a7a7a);
        font-family: 'Poppins', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

    .register-card {
        border: none;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        background-color: #fff;
        width: 100%;
        max-width: 550px;
    }

    .form-control {
        border-radius: 10px;
        height: 45px;
    }
    textarea.form-control {
            height: auto;
     }

    .btn-primary {
        border-radius: 10px;
        font-weight: 600;
        height: 45px;
        margin-top: 10px;
    }

    .field-icon {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
}
</style>
</head>
<body>
    <div class="card register-card">
        <div class="text-center">
        <h3 class="font-weight-bold mb-2">Register</h3>
        <p class="text-muted mb-4">Create your account</p>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form method="POST" action="{{ route('register.store') }}">
        @csrf
        <input type="text" name="firstname" placeholder="First Name" required>
         <input type="text" name="lastname" placeholder="Last Name" required>
         <input type="date" name="dob">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password"  placeholder="Password" required>
        <input type="password" id="password_confirmation" name="password_confirmation">
         <input type="text" name="phone"  placeholder="Phone Number">
         <input type="email" name="email"  placeholder="Email Address">

         <div>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="doctor">Doctor</option>
                <option value="nurse">Nurse</option>
                <option value="student">Student</option>
            </select>
        </div>

        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>


        <div>
            <select name="faculty" required>
                <option value="">Faculty</option>
                <option value="appliedscience">Applied Science</option>
                <option value="technologicalstudies">Technological Studies</option>
                <option value="businessstudies">Business Studies</option>
            </select>
        </div>

        <div>
            <select name="department" required>
                <option value="">Department</option>
                <option value="physicalscience">Physical Science</option>
                <option value="bioscience">Bio Science</option>
                <option value="ict">ICT</option>
            </select>
        </div>

        <div>
            <select name="degree" required>
                <option value="">Degree</option>
                <option value="it">Information Technology</option>
                <option value="amc">Applied Mathematics and computing</option>
                <option value="bio">Environmental Science</option>
                <option value="bio">Information and Communication Technology</option>
            </select>
        </div>


         <input type="text" class="form-control" name="regno"  placeholder="Registration Number" required>

        <button type="submit" class="btn btn-primary btn-block" >Register </button>

    </form>

    <div>
           <div class="text-center mt-3">
           <p> Already have an account? <a href="/login">Login</a>
        </p>
    </div>
    </div>

    <script>
function togglePassword(fieldId, icon) {
    let input = document.getElementById(fieldId);

    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>
