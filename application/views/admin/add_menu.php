<!DOCTYPE html>
<html>
<head>
    <title>Add Menu Item</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>

<header>Add Menu Item</header>

<div class="container" style="max-width:500px;">

    <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
        <a href="<?= base_url() ?>" class="btn btn-add">🏠 Home</a>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-add">⬅ Dashboard</a>
        <a href="<?= base_url('admin/logout') ?>" class="btn btn-danger">Logout</a>
    </div>

    <?php if (!empty($success)): ?>
        <div class="order-box" style="border-left-color:green;">
            <?= $success ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
        <div class="order-box" style="border-left-color:#e63946;">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <h3 style="margin-bottom:15px;">New Menu Item</h3>

        <input type="text" name="name" placeholder="Item Name" required>

        <input type="number" name="price" placeholder="Price" step="0.01" required>

        <textarea name="description" placeholder="Item Description"></textarea>

        <button type="submit" name="add" class="btn btn-add" style="width:100%;">
            Add Item
        </button>
    </form>

</div>

</body>
</html>
