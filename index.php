<?php
// Include the logic for policy check and admin login
require_once 'logic.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Haven Insurance</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.3); }
        h1, h3 { text-align: center; }
        form { margin-bottom: 20px; }
        input, button { padding: 10px; margin: 5px; width: calc(100% - 12px); }
        button { background-color: #007BFF; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .success { color: green; }
        .error { color: red; }
        .policy-details { margin-top: 20px; }
        .policy-details p { margin: 5px 0; }
    </style>
</head>
<body>

<div class="container">
    <!-- Check Policy Form (Public Section) -->
    <h1>Haven Insurance</h1>
    <form method="POST">
        <h3>Check Your Policy</h3>
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="postcode" placeholder="Postcode" required>
        <button type="submit" name="check_policy">Check Policy</button>
    </form>

    <?php if ($policy_found): ?>
        <!-- Policy Found Section -->
        <div class="policy-details">
            <h3>Policy Found</h3>
            <p><strong>Name:</strong> <?= htmlspecialchars($policy['name']) ?></p>
            <p><strong>Postcode:</strong> <?= htmlspecialchars($policy['postcode']) ?></p>
            <p><strong>Vehicle:</strong> <?= htmlspecialchars($policy['vehicle']) ?></p>
            <p><strong>Start Date:</strong> <?= htmlspecialchars($policy['start_date']) ?></p>
            <p><strong>End Date:</strong> <?= htmlspecialchars($policy['end_date']) ?></p>
            <p><a href="<?= htmlspecialchars($policy['document_url']) ?>" target="_blank">View Policy Document</a></p>
        </div>
    <?php elseif ($policy_error): ?>
        <!-- Error Message if no policy found -->
        <p class="error"><?= htmlspecialchars($policy_error) ?></p>
    <?php endif; ?>

    <!-- Admin Login Form -->
    <h2>Admin Login</h2>
    <form method="POST">
        <input type="text" name="username" placeholder="Admin Username" required>
        <input type="password" name="password" placeholder="Admin Password" required>
        <button type="submit" name="admin_login">Login</button>
        <?php if ($login_error) echo "<p class='error'>$login_error</p>"; ?>
    </form>

    <?php if (isset($_GET['admin_dashboard']) && isset($_SESSION['admin_logged_in'])): ?>
        <h1>Admin Dashboard</h1>
        <form method="POST" enctype="multipart/form-data">
            <h3>Add New Policy</h3>
            <input type="text" name="name" placeholder="Customer Name" required>
            <input type="text" name="postcode" placeholder="Postcode" required>
            <input type="text" name="vehicle" placeholder="Vehicle" required>
            <input type="date" name="start_date" placeholder="Start Date" required>
            <input type="date" name="end_date" placeholder="End Date" required>
            <input type="file" name="document" required>
            <button type="submit" name="add_policy">Add Policy</button>
        </form>

        <h3>Existing Policies</h3>
        <table>
            <tr>
                <th>Name</th>
                <th>Postcode</th>
                <th>Vehicle</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Document</th>
            </tr>
            <?php
            $result = $conn->query("SELECT * FROM policies");
            while ($row = $result->fetch_assoc()):
            ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['postcode']) ?></td>
                <td><?= htmlspecialchars($row['vehicle']) ?></td>
                <td><?= htmlspecialchars($row['start_date']) ?></td>
                <td><?= htmlspecialchars($row['end_date']) ?></td>
                <td><a href="<?= htmlspecialchars($row['document_url']) ?>" target="_blank">View</a></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

</div>

</body>
</html>
