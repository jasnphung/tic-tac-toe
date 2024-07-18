<?php 

require "models/Game.php";

session_start();

use Tic\Game;

$_SESSION["games"] = []; //stores a list of games that have been played
$_SESSION["game"] = new Game();
$_SESSION["scores"] = ['X' => 0, 'O' => 0];


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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> <!-- Include jQuery -->
</head>
<body>
<div id="fallingElementsContainer"></div>
<h1>Tic Tac Toe</h1>

<button id="rulesButton" class="ruleButton">How to play</button>
<!-- <button id="modeButton" class="tooltip">
    <span class="button-text">Player vs Computer</span>
    <span class="tooltiptext">Click to change the mode</span>
</button> -->
<!-- <h2>Player vs Computer</h2> -->
<div id="leaderboard" class="leaderboard">
    <div class="title">Player leaderboard</div>
    <div class="player-score">
        <span class="player">Player X:</span>
        <span id="playerXScore" class="score">0</span>
    </div>
    <div class="player-score">
        <span class="player">Player O:</span>
        <span id="playerOScore" class="score">0</span>
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
<h2 id="message"></h2>
<div id="gameBoard" class="game-board"></div>
<button onclick="startGame()">Restart Game</button>
<script src="modal.js"></script>
<script src="animation.js"></script>
<script src="script.js"></script> <!-- Link to your script.js file -->

</body>
</html>
