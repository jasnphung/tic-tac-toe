let board;
let currentPlayer;
const winPatterns = [
    [0, 1, 2], [3, 4, 5], [6, 7, 8], // Rows
    [0, 3, 6], [1, 4, 7], [2, 5, 8], // Columns
    [0, 4, 8], [2, 4, 6] // Diagonals
];
let cells; // Declare cells array
let mode = 2; // 1: Player vs Computer, 2: Player vs Player

document.getElementById('modeButton').addEventListener('click', function() {
    mode = mode === 1 ? 2 : 1;
    console.log(`Mode: ${mode}`);
    const buttonText = this.querySelector('.button-text');
    if (mode === 1) {
        buttonText.textContent = 'Player vs Computer';
    } else {
        buttonText.textContent = 'Player vs Player';
    }
    startGame();
});

function startGame() {
    board = Array(9).fill(null);
    currentPlayer = 'X';
    resetMessage();
    document.getElementById('message').textContent = `Player ${currentPlayer}'s turn`;
    renderBoard();
}

function computerMove() {
    const emptyCells = board.map((cell, index) => cell === null ? index : null).filter(val => val !== null);
    if (emptyCells.length > 0) {
        setTimeout(() => {
            const randomCellIndex = emptyCells[Math.floor(Math.random() * emptyCells.length)];
            board[randomCellIndex] = 'O';
            renderBoard();
            if (checkWinner()) {
                document.getElementById('message').textContent = `Player ${currentPlayer} wins!`;
                highlightWinningCells();
                showWinMessage();
            } else if (board.every(cell => cell)) {
                document.getElementById('message').textContent = `It's a tie!`;
            } else {
                currentPlayer = 'X';
                document.getElementById('message').textContent = `Player ${currentPlayer}'s turn`;
            }
        }, 500);
    }
}

function renderBoard() {
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
    if (board[index] || checkWinner()) return; 

    board[index] = currentPlayer;
    renderBoard(); 

    if (checkWinner()) {
        document.getElementById('message').textContent = `Player ${currentPlayer} wins!`;
        highlightWinningCells(); // Highlight winning cells
        showWinMessage();
    } else if (board.every(cell => cell)) {
        document.getElementById('message').textContent = `It's a tie!`;
    } else {
        if (mode === 2) {
            currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
            document.getElementById('message').textContent = `Player ${currentPlayer}'s turn`;
        }
        else {
            currentPlayer = currentPlayer === 'X' ? 'O' : 'X';
            document.getElementById('message').textContent = `Player ${currentPlayer}'s turn`;
            computerMove();
        }
    }
}

function checkWinner() {
    return winPatterns.some(pattern => {
        const [a, b, c] = pattern;
        return board[a] && board[a] === board[b] && board[a] === board[c];
    });
}

function highlightWinningCells() {
    winPatterns.forEach(pattern => {
        const [a, b, c] = pattern;
        if (board[a] && board[a] === board[b] && board[a] === board[c]) {
            cells[a].classList.add('win');
            cells[b].classList.add('win');
            cells[c].classList.add('win');
            console.log(`Winning pattern: ${a}, ${b}, ${c}`);
        }
    });
}

function showWinMessage() {
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'block'; // Show the overlay
    const message = document.getElementById('message');
    message.classList.add('winning-message'); // Apply 3D effect
}


function resetMessage() {
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'none';
    const message = document.getElementById('message');
    message.classList.remove('winning-message');
    message.textContent = '';
}


// Start the game initially
startGame();
