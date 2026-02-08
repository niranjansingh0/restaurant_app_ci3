<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <style>
        .error-message {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 12px 20px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>Restaurant Admin Login</header>

<div class="container" style="max-width:400px;">
    <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
        <a href="<?= base_url() ?>" class="btn btn-add">🏠 Home</a>
    </div>
    
    <?php if (!empty($error)): ?>
        <div class="error-message">
            ❌ <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('admin/login') ?>">
        <h3 style="margin-bottom:15px;">Login</h3>

        <input type="text" name="username" placeholder="Username" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="login" value="1" class="btn btn-add" style="width:100%;">Login</button>
    </form>
</div>
</body>
</html>
