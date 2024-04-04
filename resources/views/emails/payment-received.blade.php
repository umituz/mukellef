<!DOCTYPE html>
<html>
<head>
    <title>{{ __('Payment Received') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 0 auto;
            max-width: 600px;
        }
        h1 {
            color: #333333;
        }
        p {
            color: #666666;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>{{ __('Hello, :name', ['name' => 'Ümit UZ']) }}</h1>
    <p>{{ __('Your payment has been received. Thank you!') }}</p>
</div>
</body>
</html>
