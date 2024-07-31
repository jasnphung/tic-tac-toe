<?php

session_start();
include 'db.php'; // Include database connection
require "models/Game.php";

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}

$email = $_SESSION['email'];

// Fetch user information
$stmt = $pdo->prepare("SELECT * FROM Users WHERE emailaddress = :email");
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    header('Location: index.php');
    exit();
}

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // Redirect to login page if not logged in
    header('Location: admin_login.php');
    exit();
}

use Tic\Game;

$_SESSION["games"] = []; //stores a list of games that have been played
$_SESSION["game"] = new Game();
$_SESSION["scores"] = ['X' => 0, 'O' => 0];
// Initialize messages
$error_message = '';
$success_message = '';

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'updateProfile') {
        $new_password = $_POST['new_password'];
        $new_country = $_POST['new_country'];

        if (empty($new_password) && empty($new_country)) {
            $error_message = 'The fields can\'t be left empty. Try again.';
        } else {
            try {
                $update_fields = [];
                $params = ['email' => $email];

                if (!empty($new_password)) {
                    $update_fields[] = "password = :new_password";
                    $params['new_password'] = $new_password;
                }

                if (!empty($new_country)) {
                    $update_fields[] = "country = :new_country";
                    $params['new_country'] = $new_country;
                }

                if (!empty($update_fields)) {
                    $stmt = $pdo->prepare("UPDATE Users SET " . implode(', ', $update_fields) . " WHERE emailaddress = :email");
                    $stmt->execute($params);
                    $success_message = 'Profile updated successfully!';
                    // Refresh user details
                    $stmt = $pdo->prepare("SELECT * FROM Users WHERE emailaddress = :email");
                    $stmt->execute(['email' => $email]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                }
            } catch (Exception $e) {
                $error_message = 'Error updating profile: ' . $e->getMessage();
            }
        }
    } elseif (isset($_POST['newGame'])) {
        // Check if the "New Game" button is pressed
        // Update the leaderboard
        updateLeaderboard($pdo, $email, $_POST['playerXScore']);
    }
}

// Fetch top 10 leaderboard
function getTop10Users($pdo)
{
    $stmt = $pdo->query("SELECT emailaddress, winsasx FROM Leaderboard ORDER BY winsasx DESC LIMIT 10");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$top10Users = getTop10Users($pdo);
// print_r($top10Users); // Debugging statement

// Function to update the leaderboard
function updateLeaderboard($pdo, $email, $playerXScore)
{
    // Fetch the current highest score for the player
    $stmt = $pdo->prepare("SELECT winsasx FROM Leaderboard WHERE emailaddress = :email");
    $stmt->execute(['email' => $email]);
    $currentScore = $stmt->fetchColumn();

    // Check if the new score is higher
    if ($playerXScore > $currentScore) {
        try {
            // Update the leaderboard with the new score
            $stmt = $pdo->prepare("UPDATE Leaderboard SET winsasx = :playerXScore WHERE emailaddress = :email");
            $stmt->execute(['playerXScore' => $playerXScore, 'email' => $email]);
        } catch (Exception $e) {
            // Handle potential errors
            echo 'Error updating leaderboard: ' . $e->getMessage();
        }
    }
}

// Check if the "New Game" button is pressed
if (isset($_POST['newGame'])) {
    // Update the leaderboard
    updateLeaderboard($pdo, $email, $_POST['playerXScore']);
}

$stmt = $pdo->prepare("SELECT winsasx FROM Leaderboard WHERE emailaddress = :email");
$stmt->execute(['email' => $email]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$highestScore = $result['winsasx'] ?? 0;
// Ensure highestScore is a string or numeric value
$highestScore = json_encode($highestScore); // Convert array to string for debugging


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe Game</title>

    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="modal.css">
    <link rel="stylesheet" href="animation.css">
    <link rel="stylesheet" href="popup.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- Include jQuery -->
</head>

<body>
    <div id="fallingElementsContainer"></div>
    <h1>Tic Tac Toe</h1>
    <h2>Welcome, <?php echo htmlspecialchars($user['emailaddress']); ?>!</h2>
    <div class="button-row">
        <button onclick="location.href='index.php'" class="logoutButton">Logout</button>
        <button id="updateProfileButton" class="logoutButton">Update Profile</button>
    </div>

    <button id="rulesButton" class="ruleButton">How to play</button>
    <!-- <button id="modeButton" class="tooltip">
    <span class="button-text">Player vs Computer</span>
    <span class="tooltiptext">Click to change the mode</span>
</button> -->
    <!-- <h2>Player vs Computer</h2> -->

    <div class="leaderboardContainer">
        <div id="top10leaderboard" class="leaderboard">
            <div class="title">Top 10 Leaderboard</div>
            <?php foreach ($top10Users as $index => $user) : ?>
                <div class="player-score">
                    <span class="player"><?php echo ($index + 1) . ':'; ?></span>
                    <span id="top<?php echo ($index + 1); ?>scoreUser" class="score"><?php echo htmlspecialchars($user['emailaddress']); ?></span> <!-- Adjusted key -->
                    <span id="top<?php echo ($index + 1); ?>score" class="score"><?php echo htmlspecialchars($user['winsasx']); ?></span> <!-- Adjusted key -->
                </div>
            <?php endforeach; ?>
            <div>
                <p>(Listed by whoever had the most number of wins as player x in 1 game)</p>
            </div>
        </div>

        <div class="gameArea">
            <button id="toggleMode" class="tooltip">
                <span class="button-text"></span> <!-- Button text live updates -->
                <span class="tooltiptext">Click to change the mode</span>
            </button>
            <h2 id="message"></h2>
            <div id="gameBoard" class="game-board"></div>
        </div>

        <div id="leaderboard" class="leaderboard">
            <div class="title">Current score</div>
            <div class="player-score">
                <span class="player">Player X:</span>
                <span id="playerXScore" class="score">0</span>
            </div>
            <div class="player-score">
                <span class="player">Player O:</span>
                <span id="playerOScore" class="score">0</span>
            </div>
            <div class="player-score">
                <span class="player">Highest Score as X:</span>
                <span id="highestScore" class="score"><?php echo htmlspecialchars($highestScore); ?></span>
            </div>
            <div>
                <p>(If your current score is higher than your highest score, it will be updated when you press New Game)</p>
            </div>
        </div>
    </div>

    <div id="rulesModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>How to play</h2>
            <p>Players take turns putting their marks in empty squares. The first player to get 3 of her marks in a row (up, down, across, or diagonally) is the winner. When all 9 squares are full, the game is over. If no player has 3 marks in a row, the game ends in a tie.</p>
        </div>
    </div>
    <div id="overlay"></div>


    <button onclick="startGame()">Reset Board</button> <!-- Previously restart game button -->
    <form method="post">
        <input type="hidden" name="playerXScore" id="playerXScoreInput" value="0">
        <button type="submit" name="newGame">New Game</button>
    </form>

    <div id="popup" class="popup">
        <div class="popup-content">
            <span class="close">&times;</span>
            <h2>Update Your Profile</h2>
            <form id="updateProfileForm" method="post">
                <input type="hidden" name="action" value="updateProfile">
                <label for="new_password">New Password:</label>
                <input type="password" id="new_password" name="new_password" value="">
                <label for="new_country">New Country:</label>
                <input type="text" id="new_country" name="new_country" value="">
                <button type="submit">Update Profile</button>
            </form>
        </div>
    </div>


    </div>
    <script src="popup.js"></script>
    <script src="modal.js"></script>
    <script src="animation.js"></script>
    <script src="script.js"></script> <!-- Link to your script.js file -->

    <!-- <script>
$(document).ready(function() {
    $('#updateProfileForm').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Get form data
        var formData = $(this).serialize();

        // Perform AJAX request
        $.ajax({
            type: 'POST',
            url: 'update_profile.php', // Adjust this path as necessary
            data: formData,
            success: function(response) {
                // Update popup content with server response
                $('#popup .popup-content').html(response);
            },
            error: function(xhr, status, error) {
                // Handle error response
                $('#popup .popup-content').html('<p>An error occurred: ' + error + '</p>');
            }
        });
    });
});
</script> -->

</body>

</html>