<!DOCTYPE html>
<html>
<head>
    <title>Select Payment Method</title>
    <style>
        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }
        .bkash { background-color: #e2136e; }
        .nagad { background-color: #f7931e; }
    </style>
</head>
<body>
<h1>Select Your Payment Method</h1>

<a href="{{ route('tropay.bkash.pay') }}" class="button bkash">Pay with bKash</a>
{{--<a href="{{ route('tropay.nagad.pay') }}" class="button nagad">Pay with Nagad</a>--}}
</body>
</html>
