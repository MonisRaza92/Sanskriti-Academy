<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Failed</title>
    <style>

        .payment-status.failed {
            text-align: center;
            padding: 100px 20px;
            color: #c62828;
        }

        .payment-status.failed h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .payment-status.failed p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }

        .btn {
            background-color: #c62828;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #8e0000;
        }
    </style>
</head>

<body>
    <section class="payment-status failed">
        <h1>❌ Payment Failed!</h1>
        <p>Oops! Something went wrong. Your payment could not be completed.</p>
        <a href="?url=" class="btn">Try Again</a>
    </section>
</body>

</html>