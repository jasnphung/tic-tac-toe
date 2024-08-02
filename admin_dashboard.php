<?php
session_start();
include 'db.php'; // Include database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['email'])) {
    header('Location: admin_login.php');
    exit();
}

// Handle user deletion
if (isset($_POST['delete_user'])) {
    $email = $_POST['email'];
    $country = $_POST['country'];
    
    // Prepare and execute the delete query
    $stmt = $pdo->prepare("DELETE FROM Users WHERE EmailAddress = :email AND Country = :country AND Role = 'Player'");
    $stmt->execute(['email' => $email, 'country' => $country]);

    // Redirect to the same page to refresh the user list
    header('Location: admin_dashboard.php');
    exit();
}

// Fetch the users from the database
$stmt = $pdo->query("SELECT * FROM Users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch the leaderboard data from the database
$stmt = $pdo->query("SELECT * FROM Leaderboard");
$leaderboard = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: index.php'); // Redirect to index.php after logout
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="admin_dashboard.css" rel="stylesheet" type="text/css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
        <h1>Welcome Admin</h1>
        
        <!-- Users Table -->
        <h2>Users Table</h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Email Address</th>
                    <th>Password</th>
                    <th>Country</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($user['emailaddress']); ?></td>
                        <td><?php echo htmlspecialchars($user['password']); ?></td>
                        <td><?php echo htmlspecialchars($user['country']); ?></td>
                        <td><?php echo htmlspecialchars($user['role']); ?></td>
                        <td>
                            <?php if ($user['role'] === 'Player'): ?>
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($user['emailaddress']); ?>">
                                    <input type="hidden" name="country" value="<?php echo htmlspecialchars($user['country']); ?>">
                                    <button type="submit" name="delete_user">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

         <!-- Leaderboard Table -->
         <h2>Leaderboard</h2>
        <table>
            <thead>
                <tr>
                    <th>Email Address</th>
                    <th>Wins As X</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard as $entry): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($entry['emailaddress']); ?></td>
                        <td><?php echo htmlspecialchars($entry['winsasx']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        
        <!-- Logout Form -->
        <form method="post" class="logout-form">
            <button type="submit" name="logout">Logout</button>
        </form>

    </div>
</body>
</html>
