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
    <div
        style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; max-width: 600px; margin: 0 auto; color: #333;">
        <h1
            style="color: #2d3748; font-size: 24px; font-weight: 600; margin-bottom: 25px; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">
            Password Reset Notification
        </h1>

        <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
            Hello <strong>{{ $user->first_name }}</strong>,
        </p>

        <p style="font-size: 16px; line-height: 1.6; margin-bottom: 25px;">
            Your password for ASTRORNIX University has been successfully reset by our Astrornix University support team.
        </p>

        <div
            style="background-color: #f8fafc; border-left: 4px solid #3b82f6; padding: 20px; margin: 25px 0; border-radius: 0 8px 8px 0;">
            <p style="margin: 0 0 10px 0; font-weight: 600; color: #2d3748;">Your temporary credentials:</p>
            <p style="margin: 5px 0;"><strong>Email:</strong> {{ $user->email }}</p>
            <p style="margin: 5px 0;"><strong>New Password:</strong> <span
                    style="color: #3b82f6; font-weight: 600;">{{ $password }}</span></p>
        </div>

        <div
            style="background-color: #fff5f5; border-left: 4px solid #feb2b2; padding: 15px; margin: 25px 0; border-radius: 0 8px 8px 0;">
            <h3 style="color: #9b2c2c; font-size: 16px; margin-top: 0; margin-bottom: 10px;">⚠️ Important Security
                Notice
            </h3>
            <ul style="padding-left: 20px; margin: 0; font-size: 14px;">
                <li style="margin-bottom: 8px;">Change your password immediately after logging in</li>
                <li style="margin-bottom: 8px;">Never share your password with anyone</li>
                <li>Our team will never ask for your password</li>
            </ul>
        </div>

        @component('mail::button', ['url' => route('login'), 'color' => 'primary'])
            Access Your Account
        @endcomponent

        <p style="font-size: 14px; color: #718096; margin-top: 30px; margin-bottom: 5px;">
            If you didn't request this password reset, please contact our Astrornix University support team immediately
            at
            <a href="mailto:astrornixuni27@gmail.com" style="color: #3b82f6; text-decoration: none;">
                astrornixuni27@gmail.com
            </a> or call +123 46 78905.
        </p>
    </div>

</body>

</html>
