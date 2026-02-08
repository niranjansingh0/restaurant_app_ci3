<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<header>Restaurant Admin Dashboard</header>
<div class="container">
    <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
        <a href="<?= base_url() ?>" class="btn btn-add">🏠 Home</a>
        <a href="<?= base_url('admin/logout') ?>" class="btn btn-danger">Logout</a>
    </div>

    <!-- Stats Section -->
    <div class="menu-card">
        <div>
            <h3>Total Menu Items</h3>
            <p class="price"><?= $menu_count ?></p>
        </div>
        <div>
            <h3>Total Orders</h3>
            <p class="price"><?= $order_count ?></p>
        </div>
    </div>

    <div class="menu-card">
        <div>
            <h3>Pending Orders</h3>
            <p class="status Pending"><?= $pending_count ?></p>
        </div>
        <div>
            <h3>Accepted Orders</h3>
            <p class="status Accepted"><?= $accepted_count ?></p>
        </div>
        <div>
            <h3>Completed Orders</h3>
            <p class="status Completed"><?= $completed_count ?></p>
        </div>
    </div>

    <!-- Navigation -->
    <div class="menu-card">
        <a href="<?= base_url('admin/add_menu') ?>" class="btn btn-add">➕ Add Menu Item</a>
        <a href="<?= base_url('admin/view_orders') ?>" class="btn btn-add">📦 View Orders</a>
    </div>

    <!-- Recent Orders -->
    <h2 style="margin:20px 0;">Recent Orders</h2>

<div class="card shadow-sm">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Recent Orders</h5>
    </div>

    <div class="card-body">

        <!-- Search Box -->
        <input type="text"
               id="orderSearch"
               class="form-control mb-3"
               placeholder="Search by Order ID, Customer, Status...">

        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="ordersTable">
                <thead class="table-dark">
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Total (₹)</th>
                        <th>Status</th>
                        <th>Time</th>
                    </tr>
                </thead>

                <tbody>
                <?php if (!empty($recent_orders)): ?>
                    <?php foreach ($recent_orders as $order): ?>
                        <tr>
                            <td>#<?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($order['customer_name']) ?></td>
                            <td><?= $order['total_price'] ?></td>
                            <td>
                                <span class="badge 
                                    <?php
                                        if ($order['status'] == 'Pending') echo 'bg-warning';
                                        elseif ($order['status'] == 'Accepted') echo 'bg-primary';
                                        elseif ($order['status'] == 'Completed') echo 'bg-success';
                                    ?>">
                                    <?= $order['status'] ?>
                                </span>
                            </td>
                            <td><?= $order['created_at'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No orders yet.</td>
                    </tr>
                <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>
</div>


</div>

<script src="<?= base_url('assets/js/app.js') ?>"></script>
<script>
document.getElementById("orderSearch").addEventListener("keyup", function () {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll("#ordersTable tbody tr");

    rows.forEach(row => {
        let text = row.innerText.toLowerCase();
        row.style.display = text.includes(filter) ? "" : "none";
    });
});
</script>

</body>
</html>
