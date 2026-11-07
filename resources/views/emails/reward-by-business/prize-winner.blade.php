<!DOCTYPE html>
<html lang="{{ $language ?? 'es' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $content['meta']['title'] }}</title>
</head>
<body style="margin:0;padding:0;background:#f3f5f9;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">
<table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background:#f3f5f9;">
    <tr>
        <td align="center" style="padding:24px 12px;">
            <table role="presentation" cellpadding="0" cellspacing="0" width="100%"
                   style="max-width:580px;background:#ffffff;border-radius:16px;overflow:hidden;">
                <tr>
                    <td align="center" bgcolor="#3558df" style="padding:30px 22px;background:#3558df;">
                        <img src="{{ $logoUrl }}" alt="Yapita" width="112"
                             style="display:block;width:112px;max-width:100%;height:auto;border:0;">
                        <h1 style="margin:18px 0 8px;color:#ffffff;font-size:25px;line-height:32px;">{{ $content['header']['title'] }}</h1>
                        <p style="margin:0;color:#ffffff;font-size:15px;line-height:23px;">{{ $content['header']['subtitle'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:28px 24px;">
                        <p style="margin:0 0 18px;font-size:15px;line-height:24px;">{{ $content['intro']['greeting'] }}
                            <strong>{{ $winnerName }}</strong>. {{ $content['intro']['message'] }}</p>
                        @if(!empty($prizeImage))
                            <img src="{{ $prizeImage }}" alt="{{ $prizeName }}" width="532"
                                 style="display:block;width:100%;max-width:532px;height:auto;border:0;border-radius:12px;">
                        @endif
                        <h2 style="margin:20px 0 8px;font-size:22px;line-height:28px;color:#111827;">{{ $prizeName }}</h2>
                        <p style="margin:0 0 22px;font-size:15px;line-height:24px;color:#596579;white-space:pre-line;">{{ $prizeDescription }}</p>
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                               style="background:#eef2ff;border-radius:12px;">
                            <tr>
                                <td align="center" style="padding:20px 12px;">
                                    <p style="margin:0 0 6px;font-size:12px;font-weight:bold;color:#435cf0;">{{ $content['prize']['code_title'] }}</p>
                                    <p style="margin:0;font-size:23px;font-weight:bold;color:#253fbd;overflow-wrap:anywhere;">{{ $prizeCode }}</p>
                                    <p style="margin:9px 0 0;font-size:12px;line-height:18px;color:#4b5563;">{{ $content['prize']['code_hint'] }}</p>
                                </td>
                            </tr>
                        </table>
                        <h3 style="margin:26px 0 12px;font-size:17px;color:#111827;">{{ $content['winner']['title'] }}</h3>
                        <p style="margin:0 0 6px;font-size:14px;line-height:22px;">
                            <strong>{{ $content['winner']['name_label'] }}:</strong> {{ $winnerName }}</p>
                        <p style="margin:0;font-size:14px;line-height:22px;overflow-wrap:anywhere;">
                            <strong>{{ $content['winner']['email_label'] }}:</strong> {{ $winnerEmail }}</p>
                        <h3 style="margin:28px 0 12px;font-size:17px;color:#111827;">{{ $content['business']['title'] }}</h3>
                        <p style="margin:0 0 6px;font-size:16px;font-weight:bold;">{{ $businessName }}</p>
                        <p style="margin:0 0 16px;font-size:14px;line-height:22px;color:#596579;">{{ $businessAddress }}</p>
                        @if(!empty($businessMapsUrl))
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" bgcolor="#eef2ff" style="border-radius:10px;">
                                        <a href="{{ $businessMapsUrl }}" target="_blank"
                                           style="display:block;padding:14px 16px;font-size:14px;font-weight:bold;color:#3154cc;text-decoration:none;">{{ $content['business']['maps_button'] }}</a>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        @if(!empty($redeemUntil))
                            <p style="margin:18px 0 0;font-size:14px;line-height:22px;">
                                <strong>{{ $content['prize']['deadline_label'] }}:</strong> {{ $redeemUntil }}</p>
                        @endif
                        <h3 style="margin:28px 0 10px;font-size:17px;color:#111827;">{{ $content['contact']['title'] }}</h3>
                        <p style="margin:0 0 16px;font-size:14px;line-height:22px;color:#596579;">{{ $content['contact']['business_description'] }}</p>
                        @if(!empty($businessWhatsappUrl))
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" bgcolor="#168b56" style="border-radius:10px;">
                                        <a href="{{ $businessWhatsappUrl }}" target="_blank"
                                           style="display:block;padding:15px 16px;font-size:15px;font-weight:bold;color:#ffffff;text-decoration:none;">{{ $content['contact']['business_button'] }} {{ $businessName }}</a>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        <p style="margin:22px 0 12px;font-size:14px;line-height:22px;color:#596579;">{{ $content['contact']['yapita_description'] }}</p>
                        @if(!empty($yapitaWhatsappUrl))
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" bgcolor="#3558df" style="border-radius:10px;">
                                        <a href="{{ $yapitaWhatsappUrl }}" target="_blank"
                                           style="display:block;padding:15px 16px;font-size:15px;font-weight:bold;color:#ffffff;text-decoration:none;">{{ $content['contact']['yapita_button'] }}</a>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        <p style="margin:24px 0 0;font-size:13px;line-height:21px;color:#6b7280;">{{ $content['contact']['notice'] }}</p>
                    </td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#eef2ff" style="padding:25px 24px;background:#eef2ff;">
                        <h2 style="margin:0 0 10px;font-size:21px;line-height:28px;color:#253fbd;">{{ $content['community']['title'] }}</h2>
                        <p style="margin:0 0 12px;font-size:15px;line-height:24px;color:#374151;">{{ $content['community']['description'] }}</p>
                        <p style="margin:0 0 18px;font-size:15px;line-height:23px;font-weight:bold;color:#253fbd;">{{ $content['community']['slogan'] }}</p>
                        @if(!empty($communityUrl))
                            <table role="presentation" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" bgcolor="#3558df" style="border-radius:10px;">
                                        <a href="{{ $communityUrl }}" target="_blank"
                                           style="display:block;padding:13px 22px;font-size:14px;font-weight:bold;color:#ffffff;text-decoration:none;">{{ $content['community']['button'] }}</a>
                                    </td>
                                </tr>
                            </table>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td align="center" bgcolor="#f8fafc" style="padding:22px 24px;background:#f8fafc;">
                        <p style="margin:0 0 8px;font-size:14px;line-height:22px;color:#374151;">{{ $content['footer']['message'] }}</p>
                        <p style="margin:0;font-size:12px;color:#9ca3af;">
                            © {{ date('Y') }} {{ $content['footer']['copyright'] }}</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
