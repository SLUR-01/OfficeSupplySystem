<!DOCTYPE html>
<html>
<head>
    <title>Withdrawal Ready Notification</title>
</head>
<body>
    <h2>Hello {{ $name }},</h2>
    <p>Your request for <strong>{{ $quantity }} {{ $item }}</strong> from the <strong>{{ $department }}</strong> department is now <strong>ready for pickup</strong>.</p>
    <p>Please proceed to the withdrawal section at your earliest convenience.</p>
    <p>You can log in to your account using the link below:</p>
    
    <p><a href="{{ $login_url }}" 
          style="background-color: #3498db; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
          Login to Request Supply
       </a>
    </p>

    <p>Thank you!</p>
</body>
</html>
