<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Aktywacja konta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Aktywacja konta</h1>

    <p>Witaj {{ $user->first_name }} {{ $user->last_name }},</p>

    <p>Dziękujemy za rejestrację. Aby aktywować swoje konto, kliknij poniższy link:</p>

    <p>
        <a href="{!! $activationUrl !!}" class="button">Aktywuj konto</a>
    </p>

    <p>Lub skopiuj i wklej poniższy link do przeglądarki:</p>

    <p>{!! $activationUrl !!}</p>

    <p>Link wygaśnie w ciągu 24 godzin.</p>

    <p>Jeśli nie zakładałeś konta, prosimy zignorować tę wiadomość.</p>

    <div class="footer">
        <p>Wiadomość wygenerowana automatycznie, prosimy na nią nie odpowiadać.</p>
    </div>
</div>
</body>
</html>
