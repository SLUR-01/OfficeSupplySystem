<!DOCTYPE html>
<html>
<head>
    <title>New Request Notification</title>
</head>
<body>
    <p>Hello Admin,</p>
    <p>A new request has been submitted with the following details:</p>
    <ul>
        <li><strong>Requester Name:</strong> {{ $requestData['requester_name'] }}</li>
        <li><strong>Department:</strong> {{ $requestData['department'] }}</li>
        <li><strong>Item Name:</strong> {{ $requestData['item_name'] }} ({{ $requestData['variant_value'] }})</li>

        <li><strong>Quantity:</strong> {{ $requestData['quantity'] }}</li>
        <li><strong>Date & Time:</strong> {{ $requestData['datetime'] }}</li>
    </ul>
    <p><a href="{{ url('192.168.17.82') }}">Click here to log in</a> and review the request.</p>
    <p>Thank you.</p>
</body>
</html>
