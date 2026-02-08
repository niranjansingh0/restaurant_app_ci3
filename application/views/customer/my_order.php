<!DOCTYPE html>
<html>
<head>
    <title>Order Status</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<header>Order Status 📦</header>

<div class="container">
    <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
        <a href="<?= base_url() ?>" class="btn btn-add">🏠 Home</a>
    </div>

    <div class="order-box">
        <h3>Order #<?= $order['id'] ?></h3>
        <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
        <p><strong>Total:</strong> ₹<?= $order['total_price'] ?></p>

        <p>
            <strong>Status:</strong>
            <span class="status <?= $order['status'] ?>">
                <?= $order['status'] ?>
            </span>
        </p>

        <?php if ($order['status'] == 'Completed'): ?>
            <p style="color:green; font-weight:bold;">
                ✅ Your order is confirmed and completed!
            </p>
        <?php else: ?>
            <p style="color:orange;">
                ⏳ Your order is being processed.
            </p>
        <?php endif; ?>
    </div>

    <a href="<?= base_url('customer') ?>" class="btn btn-add">Back to Menu</a>

</div>

</body>
</html>
