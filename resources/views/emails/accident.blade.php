<!DOCTYPE html>
<html>
<head>
    <title>Critical Building Tilt Notification</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f2f2f2;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px !important;
            border: 1px solid black !important;
            background-color: #fff5f5 !important;
            border-radius: 10px !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #e74c3c;
        }
        p {
            color: #333;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Critical Building Tilt Notification</h1>

    <p>Dear Employee, {{ $firstName }} {{ $lastName }}</p>

    <p>We would like to inform you about a critical tilt on the construction named <strong>{{ $constructionName }}</strong>, which was detected on {{ $date }}.</p>

    <p>This message represents a security alert regarding a serious issue that requires immediate intervention and action.</p>

    <p>Please take the necessary steps to ensure safety and prevent further risks.</p>

    <p>Best regards,</p>
    <p>{{ config('app.name') }}</p>
</div>
</body>
</html>
