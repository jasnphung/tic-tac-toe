# Tic Tac Toe Game Design System

This document outlines the design system for the project.

### Fonts 
- **Primary Font**: Arial, sans-serif
- **Header Font Size**: 5em
- **Message Font Size**: 1.5em
- **Button Font Size**: 2em
- **Player's Turn Font Size**: 2.5em
- **Cell Font Size**: 4em
- **Modal Header Font Size**: 1.5em
- **Modal Text Font Size**: 1.5em
- **Falling Element Font Size**: 1em
- **Winning Message Font Size**: 5em (with 3D effect)

### Colours
- **Background Color**: `#000000` (Black)
- **Text Color**: `#FFFFFF` (White)
- **Button Background Color**: `#000000` (Black)
- **Button Text Color**: `#FFFFFF` (White)
- **Cell Border Color**: `#FFFFFF` (White)
- **Winning Cell Background Color**: `#FFFF00` (Yellow)
- **Winning Cell Text Color**: `rgb(117, 139, 47)` (Greenish)
- **Falling Element Color**: `rgb(185, 182, 182)` (Light Grey)
- **Modal Background Color**: `rgba(0, 0, 0, 0.5)` (Semi-transparent Black)
- **Modal Content Background Color**: `#000000` (Black)
- **Modal Border Color**: `#FFFFFF` (White)
- **Close Button Hover Color**: `#000000` (Black)
-**Winning Message Text Shadow**: `#373636` (Grayish) 

## Structural / Recurring Components

### Header
- **Description**: The header contains the title of the game and the "How to play" button.
- **Content**:
  - Title: "Tic Tac Toe"
  - Button: "How to play"
  - Button: "Player vs Player" or "Player vs Computer" with a tip for a player
- **CSS Classes**:
  - `h1`
  - `.ruleButton`
  - `.Button`
  - `.tooltip`


### Modal
- **Description**: Displays the game rules when the "How to play" button is clicked.
- **Content**: Modal with game rules.
- **CSS Classes**:
  - `.modal`
  - `.modal-content`
  - `.close`

### Scoreboard
- **Description**: Displays the current player's turn and the winning message.
- **Content**:
  - Player Turn Message: "Player X's turn" or "Player O's turn"
  - Winning Message: "Player X wins!" or "Player O wins!"
- **CSS Classes**:
  - `h2`
  - `.winning-message`
  - `.winning-message`

### Play Area
- **Description**: The main game board where the tic-tac-toe game is played. This part also includes the "Restart Game" button.
- **Content**: 3x3 grid of cells.
- **CSS Classes**:
  - `game-board`
  - `.cell`
  - `.cell.win`
  - `.button`

### Animation
- **Description**: Falling X's and O's as a background animation.
- **Content**: Animated X's and O's falling from the top of the screen.
- **CSS Classes**:
  - `#fallingElementsContainer`
  - `.falling-element`

