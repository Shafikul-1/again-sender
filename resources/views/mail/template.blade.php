<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .business-card {
            display: flex;
            width: 600px;
            height: 200px;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            border: 10px solid #f16425;
        }

        .left-side {
            flex: 1;
            background-color: #f16425;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .photo-container img {
            width: 100%;
            border-radius: 20px;
        }

        .right-side {
            flex: 2;
            padding: 0px 0px 0px 23px;
            display: flex;
            flex-direction: column;
        }

        .flex {
            display: flex;
            gap: 4;
        }
        .socialLinki{
            margin: 0 2px;
        }
        .link{
            text-decoration: none;
            color: black;
        }
        .link:hover{
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <span> {!! $sending_email_data->mail_body !!}</span>

    <div class="business-card">
        <div class="left-side">
            <div class="photo-container">
                <img src="{{ $senderDefultData['sender_company_logo'] ?? 'https://archive.org/download/placeholder-image/placeholder-image.jpg' }}"
                    alt="company logo">
            </div>
        </div>
        <div class="right-side">
            <div class="details">
                <div class="flex " style="margin-top: 15px;">
                    <h3 style="margin: 0; font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                          {{ $senderDefultData['mail_sender_name'] }} </h3>
                    @if ($senderDefultData['sender_department'])
                        <span style="margin-left: 5px; font-weight: bolder;">||</span>
                        <span style="margin-left: 4px; font-size: 15px; margin-top: 0px; font-family: cursive;">{{ $senderDefultData['sender_department'] }}</span>
                    @endif
                </div>
                @if ($senderDefultData['sender_number'])
                    <div style=" display: flex; margin-top: 15px;">
                        <img src="https://img.icons8.com/?size=64&id=44034&format=png"
                            style="width: 20px; height: 20px; margin: 0;" alt="number">
                        <a href="tel:{{ $senderDefultData['sender_number'] }}" class="link" style=" margin-left: 5px;">+{{ $senderDefultData['sender_number'] }}</a>
                    </div>
                @endif
                    <div style=" display: flex; margin-top: 5px;">
                        <img src="https://img.icons8.com/?size=80&id=68248&format=png"
                            style="width: 20px; height: 20px; margin: 0;" alt="email">
                        <a href="mailto:{{ $senderDefultData['mail_from'] }}" class="link" style=" margin-left: 5px;">{{ $senderDefultData['mail_from'] }}</a>
                    </div>
                @if ($senderDefultData['sender_website'])
                    <div style="display: flex; margin-top: 5px;">
                        <img src="https://img.icons8.com/?size=80&id=8bVNpI807DcA&format=png"
                            style="width: 20px; height: 20px; margin: 0;" alt="website">
                        <a href="{{ $senderDefultData['sender_website'] }}" class="link" style="margin-left: 5px; "> {{ $senderDefultData['sender_website'] }}</a>
                    </div>
                @endif
            </div>
            @if ($other_links)
                <div class="flex" style="margin-top: 15px;">
                    @foreach ($other_links as $links)
                        <a href="{{ $links['yourLink'] }}" class="socialLinki">
                            <img src="{{ $links['iconLink'] }}" alt="{{ $links['yourLink'] }}" width="20px">
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>

</html>
