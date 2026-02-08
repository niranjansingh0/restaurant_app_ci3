<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<header>Your Cart 🛒</header>

<div class="container">

<?php if (empty($cart_items)): ?>
    <div class="order-box">
        <p>Your cart is empty.</p>
        <a href="<?= base_url('customer') ?>" class="btn btn-add">Go to Menu</a>
    </div>

<?php else: ?>

    <?php foreach ($cart_items as $item): ?>
        <div class="menu-card">
            <div class="menu-info">
                <h3><?= htmlspecialchars($item['name']) ?></h3>
                <p>₹<?= $item['price'] ?> × <?= $item['quantity'] ?></p>
                <p><strong>Subtotal:</strong> ₹<?= $item['subtotal'] ?></p>
            </div>

            <div>
                <a href="<?= base_url('customer/cart_action?action=add&id=' . $item['id']) ?>" class="btn btn-add">+</a>
                <a href="<?= base_url('customer/cart_action?action=decrease&id=' . $item['id']) ?>" class="btn btn-danger">−</a>
                <br><br>
                <a href="<?= base_url('customer/cart_action?action=remove&id=' . $item['id']) ?>" class="btn btn-danger">
                    Remove
                </a>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Cart Total -->
    <div class="order-box">
        <h3>Total Amount: ₹<?= $total ?></h3>
    </div>

    <!-- Place Order -->
    <form method="post" action="<?= base_url('customer/place_order') ?>">
        <h3>Customer Details</h3>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'name'): ?>
            <p style="color:red;">Please enter your name</p>
        <?php endif; ?>

        <input type="text" name="customer_name" placeholder="Your Name" required>

        <button type="submit" class="btn btn-add" style="width:100%;">
            Place Order
        </button>
    </form>

    <br>
    <a href="<?= base_url('customer/cart_action?action=clear') ?>" class="btn btn-danger">
        Clear Cart
    </a>

<?php endif; ?>

</div>

</body>
</html>
