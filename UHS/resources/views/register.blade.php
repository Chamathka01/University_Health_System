<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register page</title>
</head>
<body>
    <form>
        <input type="text" name="firstname" placeholder="First Name" required>
         <input type="text" name="lastname" placeholder="Last Name" required>
         <input type="date" name="dob">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password"  placeholder="Password" required>
         <input type="text" name="phone"  placeholder="Phone Number">
         <input type="email" name="email"  placeholder="Email Address">

         <div>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="doctor">Admin</option>
                <option value="nurse">Nurse</option>
                <option value="student">Doctor</option>
            </select>
        </div>

        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>

        <input type="faculty" name="faculty"  placeholder="Faculty" required>
         <input type="department" name="departmnet"  placeholder="Department">
         <input type="regno" name="regno"  placeholder="Registration Number">

        <button type="submit">Register</button>

    </form>

    <div>
           <p> Already have an account? <a href="/login">Login</a>
        </p>

    </div>
</body>
</html>
