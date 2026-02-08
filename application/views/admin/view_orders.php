<!DOCTYPE html>
<html>
<head>
    <title>View Orders</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>

<header>Orders Management</header>

<div class="container">

    <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
        <a href="<?= base_url() ?>" class="btn btn-add">🏠 Home</a>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-add">⬅ Dashboard</a>
        <a href="<?= base_url('admin/logout') ?>" class="btn btn-danger">Logout</a>
    </div>

    <!-- STATUS FILTER BUTTONS -->
    <div style="margin-bottom:15px;">
        <a href="<?= base_url('admin/view_orders?status=all') ?>" class="btn btn-add">All</a>
        <a href="<?= base_url('admin/view_orders?status=Pending') ?>" class="btn btn-add">Pending</a>
        <a href="<?= base_url('admin/view_orders?status=Accepted') ?>" class="btn btn-add">Accepted</a>
        <a href="<?= base_url('admin/view_orders?status=Completed') ?>" class="btn btn-add">Completed</a>
    </div>

    <?php if (!empty($orders)): ?>
        <?php foreach ($orders as $order): ?>
            <div class="order-box">
                <p><strong>Order #<?= $order['id'] ?></strong></p>
                <p>Customer: <?= htmlspecialchars($order['customer_name']) ?></p>
                <p>Total: ₹<?= $order['total_price'] ?></p>

                <p>
                    Status:
                    <span class="status <?= $order['status'] ?>">
                        <?= $order['status'] ?>
                    </span>
                </p>

                <!-- Action Buttons -->
                <?php if ($order['status'] === 'Pending'): ?>
                    <a href="<?= base_url('admin/update_order?action=accept&id=' . $order['id'] . '&status=' . $status_filter) ?>"
                       class="btn btn-add">Accept</a>
                <?php endif; ?>

                <?php if ($order['status'] === 'Accepted'): ?>
                    <a href="<?= base_url('admin/update_order?action=complete&id=' . $order['id'] . '&status=' . $status_filter) ?>"
                       class="btn btn-add">Complete</a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No orders found.</p>
    <?php endif; ?>

</div>

</body>
</html>
