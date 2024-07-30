<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE EmailAddress = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password and role
        if ($user && password_verify($password, $user['password']) && $user['role'] === 'Admin') {
            $_SESSION['email'] = $email;
            header('Location: admin_dashboard.php');
            exit();
        } else {
            $error = 'Invalid login credentials or not an admin.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="style.css" rel="stylesheet" type="text/css"> -->
    <title>Admin Login</title>
</head>
<body>
    <div class="container">
        <h1>Admin Login</h1>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form method="post">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
