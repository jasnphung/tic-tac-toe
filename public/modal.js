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