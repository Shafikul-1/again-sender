<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        a:hover {
            text-decoration: underline !important;
        }
    </style>
</head>
<body>

    <span> {!! $sending_email_data->mail_body !!}</span>



        <table width="600" cellpadding="0" cellspacing="0" border="0" style="border: 10px solid #f16425; border-radius: 20px; width: 600px; background-color: white;">
            <tr>
                <td width="200" style="background-color: #f16425; text-align: center; padding: 20px;">
                    <img src="{{ $senderDefultData['sender_company_logo'] ?? 'https://archive.org/download/placeholder-image/placeholder-image.jpg' }}" width="150" style="border-radius: 20px;" alt="company logo">
                </td>
                <td width="400" style="padding: 20px;">
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif; font-size: 18px; font-weight: bold; color: black;">
                                {{ $senderDefultData['mail_sender_name'] }}
                            </td> ||
                            @if ($senderDefultData['sender_department'])
                            <td style="padding-left: 10px; font-family: cursive; font-size: 15px;">
                                {{ $senderDefultData['sender_department'] }}
                            </td>
                            @endif
                        </tr>
                        <tr>
                            @if ($senderDefultData['sender_number'])
                                <td colspan="2" style="padding-top: 15px;">
                                    <img src="https://img.icons8.com/?size=64&id=44034&format=png" width="20" style="vertical-align: middle;" alt="number">
                                    <a href="tel:{{ $senderDefultData['sender_number'] }}" style="text-decoration: none; color: black; margin-left: 5px;">+{{ $senderDefultData['sender_number'] }}</a>
                                </td>
                            @endif
                        </tr>
                        <tr>
                            @if ($senderDefultData['mail_from'])
                            <td colspan="2" style="padding-top: 5px;">
                                <img src="https://img.icons8.com/?size=80&id=68248&format=png" width="20" style="vertical-align: middle;" alt="email">
                                <a href="mailto:{{ $senderDefultData['mail_from'] }}" style="text-decoration: none; color: black; margin-left: 5px;">{{ $senderDefultData['mail_from'] }}</a>
                            </td>
                            @endif
                        </tr>
                        <tr>
                            @if ($senderDefultData['sender_website'])
                            <td colspan="2" style="padding-top: 5px;">
                                <img src="https://img.icons8.com/?size=80&id=8bVNpI807DcA&format=png" width="20" style="vertical-align: middle;" alt="website">
                                <a href="{{ $senderDefultData['sender_website'] }}" style="text-decoration: none; color: black; margin-left: 5px;">{{ $senderDefultData['sender_website'] }}</a>
                            </td>
                            @endif
                        </tr>
                        <tr>
                            @if ($other_links)
                            <td colspan="2" style="padding-top: 15px;">
                                @foreach ($other_links as $links)
                                    <a href="{{ $links['yourLink'] }}" style="margin-right: 5px;">
                                        <img src="{{ $links['iconLink'] }}" width="20" alt="{{ $links['yourLink'] }}">
                                    </a>
                                @endforeach
                            </td>
                            @endif
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
