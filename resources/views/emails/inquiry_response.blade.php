<!DOCTYPE html>
<html>

<head>
    <title>Response to Your Inquiry</title>
</head>

<body>
    <h1>Dear {{ $userName }},</h1>

    <p>Thank you for contacting us. Here is our response to your inquiry:</p>

    <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #dee2e6; margin: 15px 0;">
        <p><strong>Your original message:</strong></p>
        <p>{{ $originalInquiry }}</p>
    </div>

    <div style="background-color: #e8f4fd; padding: 15px; border-left: 4px solid #4dabf7; margin: 15px 0;">
        <p><strong>Our response:</strong></p>
        <p>{{ $responseContent }}</p>
    </div>

    <p>If you have any further questions, please don't hesitate to contact us again.</p>

    <p>Best regards,<br>
        Astrornix University Support Team</p>
</body>

</html>
