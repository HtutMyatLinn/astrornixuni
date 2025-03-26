<!DOCTYPE html>
<html>

<head>
    <title>Contribution Rejected</title>
    <style>
        body {
            font-family: Arial, sans-serif;
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

        h1 {
            color: #333;
            font-size: 28px;
            text-align: center;
            margin-bottom: 10px;
        }

        p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }

        .footer a {
            color: #007bff;
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
            <h1>Sorry, your contribution has been rejected</h1>

            <p>Dear {{ $contribution->user->first_name }} {{ $contribution->user->last_name }},</p>

            <p>We regret to inform you that your contribution titled
                <strong>{{ $contribution->contribution_title }}</strong> has been rejected.
            </p>

            <p>If you wish to know more details about the feedback or how to improve your submission, please feel free
                to contact us.</p>
            <a href="mailto:astrornixuni27@gmail.com" style="color: #3b82f6; text-decoration: none;">
                astrornixuni27@gmail.com
            </a> or call +123 46 78905.

            <div class="footer">
                <p>Best regards,</p>
                <p><strong>Astrornix University Team</strong></p>
                <p>&copy; {{ date('Y') }} Astrornix University. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>

</html>
