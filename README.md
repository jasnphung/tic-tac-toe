# tic-tac-toe

Welcome to the Tic Tac Toe game project as part of CSI3140 assignment.

## Description
This project is a Tic Tac Toe game built with HTML, CSS, JavaScript, and PHP.

## Features
- Player vs Player
- Player vs Computer gameplay
- Interactive UI
- Winning message display
- Falling X's and O's animation

## Design System
For detailed information about the design system used in this project, please refer to the [Design System](docs/design_system.md).

## Screenshots

### Initial Game Interface

![Initial Interface](docs/design_system/assets/v3/initial_interface.png)

### Rules

![Rules](docs/design_system/assets/v3/rules.png)

### Player vs Player Mode

![Player vs Player](docs/design_system/assets/v3/player_vs_player.png)

### Player vs Computer Mode

![Player vs Computer](docs/design_system/assets/v3/player_vs_computer.png)

### Winning state

![Winning state](docs/design_system/assets/v3/winning_state.png)

### It's a tie state

![Tie state](docs/design_system/assets/v3/tie_state.png)

## User instructions (how to play)
1. Start the game by clicking on any cell.
2. The player (X) plays against another play or the computer (O), placing an X on their turn and having the computer subsequently place an O, or, the player may play against another player.
3. The game ends when one player gets three marks in a row (horizontally, vertically, or diagonally) or all cells are filled without a winner.

## Developer instructions (how to setup/run it locally)
Initial database setup:
1. psql -U postgres
2. CREATE database tictacdb
3. exit
4. psql -U postgres -d tictacdb -f db/schema.sql

Notes:
1. For the error "Connection failed: could not find driver", make sure extension=pdo_pgsql does not have a leading ";" in php.ini
2. While in PSQL, use \c tictacdb to connect to the database and \dt to list the tables

To run this project locally with the PHP component (after the database is setup):
1. Clone the repository.
2. Navigate to the project location within CMD.
3. Use: php -S localhost:9000
4. Navigate to http://localhost:9000 in your web browser.