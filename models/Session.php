<?php 
header("Content-Type: application/json");
require "Game.php";

session_start();

use Tic\Game;

if (!isset($_SESSION["game"])) {
    //make sure to add error message
}



// Handle AJAX actions
if (isset($_POST["action"])) {
    switch ($_POST["action"]) {
        case "resetGame":
            $_SESSION["game"] = new Game();
            $response = [
                'success' => true,
                'message' => 'Game reset successfully'
            ];
            echo json_encode($response);
            break;

        case "makeMove":
            $index = $_POST['index'] ?? null;
            $player = $_POST['player'] ?? null;

            if ($index !== null && $player !== null) {
                $moveSuccessful = $_SESSION["game"]->makeMove($index, $player);

                // Prepare response with game state and move success status
                $response = [
                    'gameState' => $_SESSION["game"]->getGameState(),
                    'moveSuccessful' => $moveSuccessful,
                ];

                echo json_encode($response);
            } else {
                echo json_encode(['error' => 'Invalid move data']);
            }
            break;

        case "getGameState":
            // Prepare response with current game state
            $response = [
                'gameState' => $_SESSION["game"]->getGameState()
            ];
            echo json_encode($response);
            break;

        case "updateScores":
            $winner = $_POST["winner"] ?? null;
            if ($winner === 'X' || $winner === 'O') {
                $_SESSION['scores'][$winner]++;
            }
            echo json_encode(['success' => true]);
            break;

        case "getScores":
            // Prepare response with current scores
            $response = [
                'scores' => $_SESSION["scores"]
            ];
            echo json_encode($response);
            break;

        case "changeMode":
            $mode = $_POST["mode"] ?? null;
            if (in_array($mode, ['pvp', 'pvc'])) {
                $_SESSION["game"]->setMode($mode);
                $response = [
                    'success' => true,
                    'message' => 'Game mode changed to ' . $mode
                ];
            } else {
                $response = ['error' => 'Invalid mode'];
            }
            echo json_encode($response);
            break;

        case "getMode":
            $mode = $_SESSION["game"]->getMode();
            echo json_encode(['mode' => $mode]);
            break;

        default:
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
} else {
    echo json_encode(['error' => 'No action specified']);
}

?>