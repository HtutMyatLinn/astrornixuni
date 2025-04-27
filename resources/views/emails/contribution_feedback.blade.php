<!DOCTYPE html>
<html>

<head>
    <title>Feedback on Your Contribution</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f4f4f4;
            padding: 40px 0;
        }

        .email-container {
            max-width: 600px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 40px auto;
        }

        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #eeeeee;
        }

        .email-header img {
            max-width: 150px;
        }

        h1 {
            font-size: 24px;
            margin-top: 20px;
            text-align: center;
        }

        p {
            color: #333333;
            font-size: 16px;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .feedback-section {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 5px solid #007bff;
            margin: 20px 0;
            border-radius: 5px;
        }

        .feedback-section p {
            margin: 0;
            font-style: italic;
            color: #555555;
        }

        .cta-button {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }

        .cta-button a {
            background-color: #004085;
            color: #ffffff;
            text-decoration: none;
            font-size: 16px;
            padding: 12px 20px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
        }

        .cta-button a:hover {
            background-color: #003366;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #888888;
            margin-top: 30px;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }

        .footer a {
            color: #004085;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-container">
            <h1>Feedback on Your Contribution</h1>

            <p>Dear <strong>{{ $contribution->user->first_name }} {{ $contribution->user->last_name }}</strong>,</p>

            <p>Your contribution titled <strong>{{ $contribution->contribution_title }}</strong> has received feedback.
                Please review the details below:</p>

            <!-- Feedback Section -->
            <div class="feedback-section">
                <p>“{{ $feedback }}”</p>
            </div>

            <p>We encourage you to review the feedback and apply necessary improvements. If you have any questions, feel
                free to reach out.</p>

            <!-- Call to Action Button -->
            <div class="cta-button">
                <a href="{{ url('/student/contribution-detail/' . $contribution->contribution_id) }}" target="_blank">View
                    Your
                    Contribution</a>
            </div>

            <!-- Footer Section -->
            <div class="footer">
                <p>Best regards,</p>
                <p><strong>Astrornix University Team</strong></p>
                <p>&copy; {{ date('Y') }} Astrornix University. All rights reserved.</p>
                <p><a href="{{ url('/') }}">Visit our website</a></p>
            </div>
        </div>
    </div>
</body>

</html>
