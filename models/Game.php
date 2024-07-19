<?php
namespace Tic;

class Game {
    public $board;
    public $currentPlayer;
    public $mode; // To store the game mode: 'pvp' (player vs player) or 'pvc' (player vs computer)

    public function __construct() {
        $this->handlePostRequest(); // Handle any POST requests
        $this->resetGame();
        $this->mode = isset($_SESSION['mode']) ? $_SESSION['mode'] : 'pvc'; // Use session mode or default to 'pvc'
        error_log('Game mode on start: ' . $this->mode); // Log the current mode
    }

    public function resetGame() {
        $this->board = array_fill(0, 9, null); // Initialize the board with null values (9 cells)
        $this->currentPlayer = 'X'; // Player X starts the game
    }

    public function makeMove($index, $player) {
        if ($this->board[$index] === null && ($player === 'X' || $player === 'O')) {
            $this->board[$index] = $player;
            $this->currentPlayer = ($player === 'X') ? 'O' : 'X'; // Switch turns

            // Check game mode and handle computer move if in 'pvc' mode
            if ($this->mode === 'pvc' && $this->currentPlayer === 'O') {
                $this->computerMove();
            }

            return true; // Move successful
        }
        return false; // Move invalid
    }

    private function computerMove() {
        // Collect all empty cell indices
        $emptyCells = array_keys(array_filter($this->board, function($cell) {
            return $cell === null;
        }));
    
        // Check if there are any empty cells
        if (empty($emptyCells)) {
            return; // No moves to make, return early
        }
    
        // Make a random move from the available empty cells
        $index = $emptyCells[array_rand($emptyCells)];
    
        // Make the computer move (assume computer is 'O')
        $this->board[$index] = 'O';
        $this->currentPlayer = 'X'; // Switch turns back to player after computer move
    }

    public function checkWinner() {
        $winPatterns = [
            [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
            [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
            [0, 4, 8], [2, 4, 6] // Diagonals
        ];
    
        foreach ($winPatterns as $pattern) {
            [$a, $b, $c] = $pattern;
            if ($this->board[$a] !== null && $this->board[$a] === $this->board[$b] && $this->board[$a] === $this->board[$c]) {
                return [
                    'winner' => $this->board[$a], // Return the winning player (X or O)
                    'pattern' => $pattern // Return the winning pattern
                ];
            }
        }
    
        return null; // No winner yet
    }

    public function getGameState() {
        return [
            'board' => $this->board,
            'currentPlayer' => $this->currentPlayer,
            'winner' => $this->checkWinner(),
        ];
    }

    // Set mode method
    public function setMode($mode) {
        $this->mode = $mode;
        $_SESSION['mode'] = $mode; // Ensure session is updated
    }

    // Get mode method
    public function getMode() {
        return $this->mode;
    }

    private function handlePostRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'changeMode' && in_array($_POST['mode'], ['pvp', 'pvc'])) {
            $this->changeMode($_POST['mode']);
        }
    }

    private function changeMode($mode) {
        $this->mode = $mode;
        $_SESSION['mode'] = $mode; // Update the session to reflect the change
    }
}
?>
