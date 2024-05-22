<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Us Submission</title>
</head>

<body>
    <h2>New Contact Us Submission</h2>
    <p>Name: {{ $formData['name'] }}</p>
    <p>Email: {{ $formData['email'] }}</p>
    <p>Contact No: {{ $formData['contact'] }}</p>
    <p>Message: {{ $formData['message'] }}</p>
    @if (isset($formData['inventory_number']))
        <p>Inventory Number: {{ $formData['inventory_number'] }}</p>
    @endif

    @if (isset($formData['inventory_name']))
        <p>Inventory Name: {{ $formData['inventory_name'] }}</p>
    @endif

    @if (isset($formData['floor']))
        <p>Floor: {{ $formData['floor'] }}</p>
    @endif
</body>

</html>
