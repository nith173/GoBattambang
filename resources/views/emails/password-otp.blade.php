<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your password reset code</title>
</head>

<body style="margin:0; padding:0; background-color:#f1f5f9; font-family: Arial, Helvetica, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9; padding:32px 16px;">
        <tr>
            <td align="center">

                <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="max-width:480px; width:100%; background-color:#ffffff; border-radius:12px; overflow:hidden; border:1px solid #e2e8f0;">

                    {{-- Header --}}
                    <tr>
                        <td style="background-color:#2563eb; padding:24px 32px;">
                            <p style="margin:0; font-size:18px; font-weight:bold; color:#ffffff;">
                                GoBattambang
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px;">

                            <p style="margin:0 0 8px 0; font-size:16px; font-weight:bold; color:#0f172a;">
                                Password Reset Code
                            </p>

                            <p style="margin:0 0 24px 0; font-size:14px; line-height:22px; color:#475569;">
                                We received a request to reset your password. Use the verification
                                code below to continue. If you didn't request this, you can safely
                                ignore this email.
                            </p>

                            {{-- OTP Code --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding:16px; background-color:#f8fafc; border:1px solid #e2e8f0; border-radius:10px;">
                                        <span style="font-size:32px; font-weight:bold; letter-spacing:8px; color:#0f172a;">
                                            {{ $code }}
                                        </span>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:24px 0 0 0; font-size:13px; line-height:20px; color:#64748b;">
                                This code will expire in {{ $expiryMinutes }} minute{{ $expiryMinutes === 1 ? '' : 's' }}.
                                For your security, never share this code with anyone.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 32px; background-color:#f8fafc; border-top:1px solid #e2e8f0;">
                            <p style="margin:0; font-size:12px; color:#94a3b8;">
                                This is an automated message from GoBattambang. Please do not reply
                                to this email.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>