<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful</title>
    <style>
        .payment-status.success {
            text-align: center;
            padding: 100px 20px;
            color: #2e7d32;
        }
        .payment-status.success h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }
        .payment-status.success p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        .btn {
            background-color:#920000;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #1b5e20;
        }
    </style>
</head>
<body>
    <section class="payment-status success">
        <h1>✅ Payment Successful!</h1>
        <p>Thank you! Your payment has been processed successfully.</p>
        <a href="/" class="btn">Back to Home</a>
    </section>
</body>
</html>
