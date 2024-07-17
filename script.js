let board;
let gameActive = true;
let cells;
let scores = {};


function startGame() {
    //request to reset the game
    var xhttp = new XMLHttpRequest();
    xhttp.open("POST", "models/Session.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("action=resetGame");
    startGameBoard();
    gameActive=true;

}

function startGameBoard() {
    board = Array(9).fill(null);
    currentPlayer = 'X';
    
    document.getElementById('message').textContent = `Player ${currentPlayer}'s turn`;
    renderBoard();
}
function renderBoard() {
    console.log("rendering board");
    const gameBoard = document.getElementById('gameBoard');
    gameBoard.innerHTML = ''; // Clear the board
    cells = []; // Initialize cells array

    board.forEach((cell, index) => {
        const cellElement = document.createElement('div');
        cellElement.classList.add('cell');
        cellElement.textContent = cell;
        cellElement.addEventListener('click', () => handleCellClick(index));
        gameBoard.appendChild(cellElement);

        cells.push(cellElement); // Push each cell element into cells array
    });
}
function handleCellClick(index) {
    if (board[index] || !gameActive) return; // Check if cell is already occupied or game is over

    var xhr = new XMLHttpRequest();
    var url = 'models/Session.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText.trim();
            console.log('Response from server:', response); // Log response from server
            try {
                var jsonResponse = JSON.parse(response); // Parse JSON response
                console.log('Parsed JSON response:', jsonResponse); // Log parsed JSON for debugging

                if (jsonResponse.hasOwnProperty('gameState')) {
                    // Update local game state based on server response
                    var gameState = jsonResponse.gameState;
                    board = gameState.board;
                    currentPlayer = gameState.currentPlayer;
                    renderBoard(); // Update UI with new game state

                    // Check for winner or tie
                    if (gameState.winner && gameState.winner.winner) {
                        document.getElementById('message').textContent = `Player ${gameState.winner.winner} wins!`;
                        highlightWinningCells(gameState.winner.pattern); // Highlight winning cells
                        gameActive = false; // Game is over
                        updateScores(gameState.winner.winner);
                        renderLeaderboard();
                    } else if (board.every(cell => cell !== null)) {
                        document.getElementById('message').textContent = `It's a tie!`;
                        gameActive = false; // Game is over
                    } else {
                        // Update player turn message
                        document.getElementById('message').textContent = `Player ${currentPlayer}'s turn`;
                    }
                } else {
                    console.error('Missing gameState property in JSON response:', jsonResponse);
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error);
            }
        } else {
            console.error('Request failed. Status:', xhr.status);
        }
    };

    xhr.send('action=makeMove&index=' + encodeURIComponent(index) + '&player=' + encodeURIComponent(currentPlayer));
}

function checkWinner() {
    var xhr = new XMLHttpRequest();
    var url = 'models/Session.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText.trim();
            console.log('Response from server:', response); // Log response from server
            try {
                var jsonResponse = JSON.parse(response); // Parse JSON response
                console.log('Parsed JSON response:', jsonResponse); // Log parsed JSON for debugging

                if (jsonResponse.hasOwnProperty('gameState')) {
                    // Update local game state based on server response
                    var gameState = jsonResponse.gameState;
                    board = gameState.board;
                    currentPlayer = gameState.currentPlayer;
                    renderBoard(); // Update UI with new game state
                    console.log("AP" + gameState.winner);
                    // Check for winner or tie
                    if (gameState.winner && gameState.winner.winner) {
                        console.log(gameState.winner.pattern);
                        document.getElementById('message').textContent = `Player ${gameState.winner.winner} wins!`;
                        highlightWinningCells(gameState.winner.pattern); // Highlight winning cells
                        gameActive = false; // Game is over
                    } else if (board.every(cell => cell !== null)) {
                        document.getElementById('message').textContent = `It's a tie!`;
                        gameActive = false; // Game is over
                    } else {
                        // Update player turn message
                        document.getElementById('message').textContent = `Player ${currentPlayer}'s turn`;
                    }
                } else {
                    console.error('Missing gameState property in JSON response:', jsonResponse);
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error);
            }
        } else {
            console.error('Request failed. Status:', xhr.status);
        }
    };

    xhr.send('action=getGameState');
}

function highlightWinningCells(pattern) {
    pattern.forEach(index => {
        // Example: Assume each board index corresponds to a visual representation on the UI
        var cellElement = document.querySelector(`.game-board > :nth-child(${index + 1})`); // Adjust based on your actual grid structure
        if (cellElement) {
            // Apply a visual indication (e.g., add a class)
            cellElement.classList.add('win');
        } else {
            console.error('Cell element not found for index:', index);
        }
    });
}

function updateScores(winner) {
    var xhr = new XMLHttpRequest();
    var url = 'models/Session.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            getScores(); // Refresh scores after updating
        } else {
            console.error('Failed to update scores. Status:', xhr.status);
        }
    };
    xhr.send('action=updateScores&winner=' + encodeURIComponent(winner));
}

function getScores() {
    var xhr = new XMLHttpRequest();
    var url = 'models/Session.php';
    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText.trim();
            console.log("AP"+ response);
            try {
                var jsonResponse = JSON.parse(response);
                console.log(jsonResponse);
                if (jsonResponse.hasOwnProperty('scores')) {
                    scores = jsonResponse.scores; // Update global scores
                    renderLeaderboard(); // Update leaderboard display
                } else {
                    console.error('Missing scores property in JSON response:', jsonResponse);
                }
            } catch (error) {
                console.error('Error parsing JSON response:', error);
            }
        } else {
            console.error('Request failed. Status:', xhr.status);
        }
    };
    xhr.send('action=getScores');
}

function renderLeaderboard() {
    document.getElementById('playerXScore').textContent = scores.X;
    document.getElementById('playerOScore').textContent = scores.O;
}

//on load, execute the startGame() function
window.addEventListener("load", startGame);