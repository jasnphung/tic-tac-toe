//implementation modal component and falling x and o background
const modal = document.getElementById('rulesModal');

const rulesButton = document.getElementById('rulesButton');

const closeSpan = document.getElementsByClassName('close')[0];

rulesButton.onclick = function() {
    modal.style.display = 'block';
}

closeSpan.onclick = function() {
    modal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Generate falling X's and O's
function generateFallingElements() {
    const container = document.getElementById('fallingElementsContainer');
    const numElements = 50; // Number of elements to generate

    for (let i = 0; i < numElements; i++) {
        const element = document.createElement('div');
        element.classList.add('falling-element');
        element.textContent = i % 2 === 0 ? 'X' : 'O'; // Alternate between X and O

        // Randomize X position
        element.style.setProperty('--random-x', Math.random());

        // Randomize fall duration
        const duration = Math.random() * 5 + 5; // Random between 5s and 10s
        element.style.setProperty('--duration', `${duration}s`);

        container.appendChild(element);
    }
}

// Call function to generate falling elements
generateFallingElements();