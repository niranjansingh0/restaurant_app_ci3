<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/chabot.css') ?>">
</head>
<body data-base-url="<?= base_url() ?>">

<header>
    Restaurant Menu 🍽️
    <div style="font-size:14px; margin-top:5px;">
        Cart Items: <?= $cart_count ?>
    </div>
</header>

<div class="container">
    <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
        <a href="<?= base_url() ?>" class="btn btn-add">🏠 Home</a>
    </div>

    <?php if (isset($_GET['added'])): ?>
        <div class="order-box" style="border-left-color:green;">
            ✅ Item added to cart
        </div>
    <?php endif; ?>

    <?php if (!empty($menu_items)): ?>
        <?php foreach ($menu_items as $item): ?>
            <div class="menu-card">
                <div class="menu-info">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p><?= htmlspecialchars($item['description']) ?></p>
                </div>

                <div style="text-align:right;">
                    <div class="price">₹<?= $item['price'] ?></div><br>
                    <a href="<?= base_url('customer/cart/' . $item['id']) ?>" class="btn btn-add">
                        Add to Cart
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No items available right now.</p>
    <?php endif; ?>

    <!-- Cart Button -->
    <div style="margin-top:20px; text-align:center;">
        <a href="<?= base_url('customer/view_cart') ?>" class="btn btn-add">
            🛒 View Cart
        </a>
    </div>

</div>

<script src="<?= base_url('assets/js/chatbot.js') ?>"></script>
<?php include(FCPATH . 'assets/chatbot.html'); ?>

</body>
</html>
