<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
        }

        .email-container {
            max-width: 100%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
            background-color: #4CAF50;
            color: white;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }

        .content h2 {
            font-size: 20px;
            color: #4CAF50;
        }

        .content p {
            margin: 10px 0;
        }

        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #777777;
            border-top: 1px solid #eeeeee;
        }

        .bestRegards {
            font-size: 25px
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ $sending_email_data->mail_subject }}</h1>
        </div>

        <div class="content">
            <h2>Hello Dear,</h2>
            <span> {!! $sending_email_data->mail_body !!}</span>
            <br> <br> <br>

            <div class="card"
                style="background-color: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); display: flex; padding: 20px; width: 600px; align-items: center; justify-content: space-between;">
                <div class="profile-pic"
                    style="border-radius: 50%; overflow: hidden; width: 120px; height: 120px; border: 4px solid #87CEFA;">
                    <img src="https://img.mysignature.io/p/3/b/8/3b85d994-3ac5-5255-b9df-8f5b3328829f.png?time=1709046225"
                        alt="Leslie Johns" style="width: 100%; height: auto;">
                </div>
                <div class="info"
                    style="display: flex; flex-direction: column; justify-content: center; margin-left: 20px; flex-grow: 1;">
                    <h2 style="font-size: 22px; color: #333; margin: 0; text-transform: uppercase;">
                        {{ $mail_sender_name }} <span style="font-weight: normal; font-size: 16px; color: #666;"> |
                            Senior Product Manager</span>
                    </h2>
                    <ul class="contact" style="list-style: none; padding: 0; margin: 10px 0;">
                        <li style="display: flex; align-items: center; margin-bottom: 5px;">
                            <a href="mail:{{ $mail_from }}">
                                <img src="https://img.icons8.com/?size=256&id=7rhqrO588QcU&format=png" alt="email"
                                    style="width: 20px; margin-right: 10px;"> {{ $mail_from }}
                            </a>
                        </li>
                        @if ($sender_number)
                            <li style="display: flex; align-items: center; margin-bottom: 5px;">
                                <a href="tel:{{ $sender_number }}">
                                    <img src="https://img.icons8.com/?size=64&id=44034&format=png" alt="phone"
                                        style="width: 20px; margin-right: 10px;"> {{ $sender_number }}
                                </a>
                            </li>
                        @endif
                        @if ($sender_website)
                            <li style="display: flex; align-items: center;">
                                <a href="{{ $sender_website }}" style="text-decoration: none; color: black">
                                    <img src="https://img.icons8.com/?size=48&id=63807&format=png" alt="website"
                                        style="width: 20px; margin-right: 10px;"> {{ $sender_website }}
                                </a>
                            </li>
                        @endif
                    </ul>
                    @if ($other_links)
                        <div class="social-icons" style="margin-top: 10px;">
                            @foreach ($other_links as $links)
                                <a href="{{ $links['yourLink'] }}">
                                    <img src="{{ $links['iconLink'] }}" style="width: 30px; margin-right: 10px;">
                                </a>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>
</body>

</html>
