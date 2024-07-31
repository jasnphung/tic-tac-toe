<?php
include 'db.php'; // Include database connection

// Handle signup
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $country = $_POST['country'];

    if (!empty($email) && !empty($password) && !empty($country)) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and execute query
        $stmt = $pdo->prepare("INSERT INTO Users (EmailAddress, Password, Country, Role) VALUES (:email, :password, :country, 'Player')");
        if ($stmt->execute(['email' => $email, 'password' => $hashedPassword, 'country' => $country])) {
            $stmtLeaderboard = $pdo->prepare("INSERT INTO Leaderboard (EmailAddress, WinsAsX) VALUES (:email, 0)");
            $stmtLeaderboard->execute(['email' => $email]);
            header('Location: index.php');
            exit();
        } else {
            $error = 'Error signing up. Please try again.';
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
    <link rel="stylesheet" href="styles.css">
    <title>Sign Up</title>
</head>
<body>
    <div class="container">
        <h1 style="margin-left: 24px">Sign Up</h1>
        <?php if (isset($error)) echo "<p>$error</p>"; ?>
        <form method="post">
            <div class="form-container">
                <div class="form-group">
                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" required>
                </div>
                <button type="submit">Sign Up</button>
            </div>
        </form>
        <h2>Already have an account?</h2>
        <a href="index.php" style="color: white">Login</a>
    </div>
</body>
</html>
