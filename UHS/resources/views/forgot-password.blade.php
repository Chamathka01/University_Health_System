<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Forgot-password page</title>
</head>
<body>
    <form method="POST" action="/forgot-password">
        @csrf
        <input type="email" name="email" placeholder="Enter your email" required>
        <button type="submit">Send Reset Link</button>
    </form>
</body>
</html>
