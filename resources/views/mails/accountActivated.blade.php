<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dayim Account Activated</title>
</head>
<body>
    <h1>Hello, {{ $user->name }}</h1>
    <p>Your account has been successfully activated. You can now log in and start using your account.</p>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>CNIC:</strong> {{ $user->cnic }}</p>
    <p>To log in, please click <a href="https://portal.dayimmarketing.com/">here</a>.</p>
    <p>Thank you for choosing Dayim Marketing.</p>
</body>
</html>