<?php

/**
 * Password Reset Utility for Admin Panel
 * 
 * Instructions:
 * 1. Open this file in your browser: http://localhost/restaurant_app_ci3/reset_password.php
 * 2. Choose your desired password
 * 3. Copy the hash generated
 * 4. Update the database with the new hash
 */

$action = isset($_POST['action']) ? $_POST['action'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$new_hash = '';

if ($action == 'generate' && !empty($password)) {
    $new_hash = password_hash($password, PASSWORD_BCRYPT);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
        }

        .box {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .result {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 3px;
            margin-top: 20px;
            font-family: monospace;
            word-break: break-all;
        }

        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 3px;
            margin-bottom: 20px;
        }

        .success {
            background-color: #d4edda;
            border: 1px solid #28a745;
            padding: 15px;
            border-radius: 3px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <h1>🔐 Admin Password Reset Utility</h1>

    <div class="warning">
        <strong>⚠️ IMPORTANT:</strong> Delete this file after you're done for security reasons!
    </div>

    <div class="box">
        <h2>Step 1: Generate Password Hash</h2>
        <form method="POST">
            <label for="password">Enter your desired password:</label>
            <input type="password" name="password" id="password" placeholder="Enter password" required>
            <button type="submit" name="action" value="generate">Generate Hash</button>
        </form>

        <?php if (!empty($new_hash)): ?>
            <div class="success">
                <strong>✅ Hash Generated Successfully!</strong>
                <p>Your new password hash:</p>
                <div class="result">
                    <?php echo htmlspecialchars($new_hash); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="box">
        <h2>Step 2: Update Database</h2>
        <p>Copy the hash above and run this SQL query in phpMyAdmin:</p>
        <div class="result">
            UPDATE admins SET password = '<?php echo htmlspecialchars($new_hash ?: 'YOUR_HASH_HERE'); ?>' WHERE username = 'admin';
        </div>

        <h3>Or use SQL directly:</h3>
        <ol>
            <li>Open phpMyAdmin: <code>http://localhost/phpmyadmin</code></li>
            <li>Select database: <code>restaurant_app</code></li>
            <li>Click on <code>admins</code> table</li>
            <li>Click "Edit" on the admin row</li>
            <li>Replace the password value with the hash from above</li>
            <li>Click "Save"</li>
        </ol>
    </div>

    <div class="box">
        <h2>Step 3: Test Login</h2>
        <p>Visit: <a href="http://localhost/restaurant_app_ci3/admin" target="_blank">http://localhost/restaurant_app_ci3/admin</a></p>
        <p>Login with:</p>
        <ul>
            <li><strong>Username:</strong> admin</li>
            <li><strong>Password:</strong> <?php echo htmlspecialchars($password ?: '(your password)'); ?></li>
        </ul>
    </div>

    <div class="warning">
        <strong>⚠️ SECURITY:</strong> After successfully logging in, DELETE this file immediately!
        <br><br>
        <code>Delete: c:/xampp/htdocs/restaurant_app_ci3/reset_password.php</code>
    </div>

</body>

</html>