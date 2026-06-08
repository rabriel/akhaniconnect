<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Akhani Connect</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f8fa;font-family:Arial,Helvetica,sans-serif;color:#181c32;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color:#f5f8fa;padding:32px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="max-width:640px;background-color:#ffffff;border-radius:16px;overflow:hidden;">
                    <tr>
                        <td style="background:linear-gradient(135deg,#0f172a 0%,#1e293b 100%);padding:32px;text-align:center;">
                            <img src="{{ asset('logo.png') }}" alt="Akhani Connect" style="max-width:180px;height:auto;display:inline-block;margin-bottom:20px;">
                            <div style="font-size:28px;line-height:1.3;font-weight:700;color:#ffffff;">Welcome to {{ $settings['platform_name'] ?? 'Akhani Connect' }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.7;">Hi {{ $user->first_name }},</p>
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.7;">
                                {{ $settings['registration_welcome_message'] ?? 'Welcome to Akhani Connect' }}.
                            </p>
                            <p style="margin:0 0 16px;font-size:16px;line-height:1.7;">
                                Your account has been created with the <strong>{{ $user->role?->name ?? 'User' }}</strong> role. You can now sign in and continue your Akhani Connect journey.
                            </p>
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:24px 0;">
                                <tr>
                                    <td align="center" bgcolor="#009ef7" style="border-radius:8px;">
                                        <a href="{{ url('/login') }}" style="display:inline-block;padding:14px 24px;font-size:15px;font-weight:700;color:#ffffff;text-decoration:none;">
                                            Sign in to your account
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 8px;font-size:15px;line-height:1.7;">
                                If you need help, contact us at
                                <a href="mailto:{{ $settings['support_email'] ?? 'support@akhaniconnect.co.za' }}" style="color:#009ef7;">{{ $settings['support_email'] ?? 'support@akhaniconnect.co.za' }}</a>.
                            </p>
                            <p style="margin:24px 0 0;font-size:15px;line-height:1.7;">Regards,<br>{{ $settings['platform_name'] ?? 'Akhani Connect' }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
