<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    {{-- Body --}}
    <style>
        .welcome-title {
            color: #2d3748;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .details-box {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 20px 0;
            border-radius: 0 8px 8px 0;
        }

        .detail-item {
            margin-bottom: 10px;
            font-size: 16px;
        }

        .highlight {
            color: #3b82f6;
            font-weight: 600;
        }
    </style>

    <div class="welcome-title">
        Welcome to Astrornix University, <span class="highlight">{{ $user->first_name }}</span>! 👋
    </div>

    <p style="font-size: 16px; line-height: 1.6; color: #4a5568;">
        We're thrilled to have you on board! Here's everything you need to get started with your new account.
    </p>

    <div class="details-box">
        <div class="detail-item">
            <strong>Account Details:</strong>
        </div>
        <div class="detail-item">
            <strong>Username:</strong> <span class="highlight">{{ $user->username }}</span>
        </div>
        <div class="detail-item">
            <strong>Full Name:</strong> {{ $user->first_name }} {{ $user->last_name }}
        </div>
        <div class="detail-item">
            <strong>Email:</strong> {{ $user->email }}
        </div>
    </div>

    <p style="font-size: 16px; line-height: 1.6; color: #4a5568; margin-bottom: 30px;">
        You can now access all our services and features. Get started by visiting our platform:
    </p>

    @component('mail::button', ['url' => url('/'), 'color' => 'primary'])
        Get Started
    @endcomponent

    <p style="font-size: 14px; line-height: 1.6; color: #718096; margin-top: 30px;">
        If you didn't create this account, please <a href="{{ url('/contact') }}" style="color: #3b82f6;">contact our
            Astrornix University support team</a> immediately.
    </p>
</body>

</html>
