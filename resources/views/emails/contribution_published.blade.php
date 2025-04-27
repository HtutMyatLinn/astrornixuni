<!DOCTYPE html>
<html>

<head>
    <title>Contribution Published</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .email-wrapper {
            width: 100%;
            background-color: #f4f4f4;
            padding: 40px 0;
        }

        .container {
            width: 600px;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
        }

        .header {
            text-align: center;
            padding-bottom: 30px;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }

        .content {
            background-color: #f9f9f9;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 5px;
            border-left: 5px solid #007bff;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
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
            color: #888;
            margin-top: 30px;
            border-top: 1px solid #eeeeee;
        }

        .footer a {
            color: #004085;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="container">
            <div class="header">
                <h1>Hello, {{ $contribution->user->first_name }} {{ $contribution->user->last_name }}</h1>
                <p>Your contribution titled <strong>{{ $contribution->contribution_title }}</strong> has been
                    successfully published.</p>
            </div>

            <div class="content">
                <p>Thank you for your submission! We appreciate your effort in contributing to the Astrornix community.
                    Your contribution is now live and accessible to everyone.</p>
            </div>

            <!-- Call to Action Button -->
            <div class="cta-button">
                <a href="{{ url('/student/contribution-detail/' . $contribution->contribution_id) }}" target="_blank">View
                    Your
                    Contribution</a>
            </div>

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
