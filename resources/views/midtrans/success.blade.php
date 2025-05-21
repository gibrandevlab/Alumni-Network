<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container mx-auto text-center py-10">
        <h1 class="text-4xl font-bold text-green-500">Payment Successful!</h1>
        <p class="mt-4 text-lg">Thank you for your payment. Your order ID is <strong>{{ $orderId }}</strong>.</p>
        <a href="{{ url('/') }}" class="mt-6 inline-block bg-blue-500 text-white px-4 py-2 rounded">Go to Homepage</a>
    </div>
</body>
</html>
