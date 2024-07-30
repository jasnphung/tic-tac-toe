<?php
session_start();
include 'db.php'; // Include database connection

// Handle login
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT * FROM Users WHERE emailaddress = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debug: Print user data for verification
        echo '<pre>';
        print_r($user);
        echo '</pre>';

        // Verify password and role
        if ($user) {

            if($user['role'] === 'Admin'){
            // Assuming passwords are stored in plain text (not recommended for production)
                if ($password === $user['password']) {
                    $_SESSION['email'] = $email;
                    header('Location: admin_dashboard.php');
                    exit();
                } else {
                    $error = 'Invalid password.';
                }
            }
            else {
                $_SESSION['email'] = $email;
                header('Location: player_dashboard.php');
            }
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
    <title>Login</title>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form method="post">
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <h2>Don't have an account?</h2>
        <a href="player_signup.php">Sign Up</a>
    </div>
</body>
</html>
