<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant App</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SAME CSS STYLE FROM ORIGINAL -->
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background-color: #f4f6f8;
            color: #333;
        }

        header {
            background-color: #e63946;
            padding: 18px;
            color: white;
            text-align: center;
            font-size: 26px;
            font-weight: bold;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto;
        }

        .tagline {
            text-align: center;
            color: #555;
            margin-bottom: 30px;
            font-size: 16px;
        }

        .options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 30px 20px;
            text-align: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .card h2 {
            margin-bottom: 10px;
            color: #222;
        }

        .card p {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            color: white;
            text-decoration: none;
            display: inline-block;
        }

        .btn-customer {
            background-color: #2a9d8f;
        }

        .btn-customer:hover {
            background-color: #21867a;
        }

        .btn-admin {
            background-color: #e63946;
        }

        .btn-admin:hover {
            background-color: #c92f3b;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #777;
            font-size: 13px;
        }

        @media (max-width: 768px) {
            .options {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

<header>
    🍽️ Restaurant App
</header>
   
<div class="container">

    <p class="tagline">
        Quality Food • Fast Service • Happy Customers
    </p>

    <div class="options">
        <!-- Customer -->
        <div class="card">
            <h2>👤 Customer</h2>
            <p>
                Browse menu, place orders, and track your food in real-time.
            </p>
            <a href="<?= base_url('customer') ?>" class="btn btn-customer">
                Order Food
            </a>
        </div>

        <!-- Admin -->
        <div class="card">
            <h2>⚙️ Admin</h2>
            <p>
                Manage menu items, orders, and restaurant operations.
            </p>
            <a href="<?= base_url('admin') ?>" class="btn btn-admin">
                Admin Panel
            </a>
        </div>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Restaurant App. All rights reserved.
    </footer>

</div>

</body>
</html>
