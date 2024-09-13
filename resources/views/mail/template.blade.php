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
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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
        .bestRegards{
            font-size: 25px
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Revitalize Your Photos with Professional Editors</h1>
        </div>
        <div class="content">
            <h2>Hello Dear,</h2>
            <span> {!! $sending_email_data->mail_body !!}</span>
            <br> <br> <br>
            <table style="font-family: Arial, sans-serif; color: #333; width: 500px;">
                {{-- <tr>
                  <td style="padding-right: 10px;">
                    <img src="https://raw.githubusercontent.com/shafik-120/office-img/main/nova%20elie.jpg" alt="{{$senderName}}" style="border-radius: 50%; width: 100px; height: 100px;" />
                  </td>
                  <td style="vertical-align: middle;">
                    <h3 style="margin: 0; font-size: 16px; color: #333;"><b>{{$senderName}}</b> | <span style="font-weight: normal; font-size: 14px;">Senior Product Manager</span></h3>
                    <p style="margin: 5px 0 0 0; font-size: 14px;">
                      <img src="https://img.icons8.com/?size=256w&id=k5TOe_wo6JDZ&format=png" alt="Email" style="width: 18px;" />
                      <a href="mailto:{{  $meFrom  }}" style="text-decoration: none; color: #333;">{{ $meFrom }}</a><br />
                      <img src="https://img.icons8.com/?size=256w&id=44034&format=png" alt="Phone" style="width: 18px;" />
                      <a href="tel:+8801404013366" style="text-decoration: none; color: #333;">+88 0140401-3366</a><br />
                      <img src="https://img.icons8.com/?size=256w&id=43620&format=png" alt="Website" style="width: 20px;" />
                      <a href="https://www.photoeditorph.com/portfolio/" style="text-decoration: none; color: #333;">www.photoeditorph.com</a>
                    </p>
                    <p style="margin-top: 10px;">
                        <a href="https://www.facebook.com/Novaellieph1" style="text-decoration: none;">
                          <img src="https://img.icons8.com/?size=256&id=mGGKptNF5YoF&format=png" alt="Facebook" style="width: 25px;" />
                        </a>
                        <a href="https://www.instagram.com/nova_ellie_retoucher1/" style="text-decoration: none; margin-left: 10px;">
                          <img src="https://img.icons8.com/?size=256&id=bh8L0hocH1mA&format=png" alt="Instagram" style="width: 25px;" />
                        </a>
                        <a href="https://wa.me/+8801404013366" style="text-decoration: none; margin-left: 10px;">
                          <img src="https://img.icons8.com/?size=256&id=16713&format=png" alt="Whatsapp" style="width: 25px;" />
                        </a>
                      </p>
                  </td>
                </tr> --}}
              </table>
        </div>

    </div>
</body>
</html>
