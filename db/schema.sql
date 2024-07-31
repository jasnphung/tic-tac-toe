-- CREATE DATABASE tictacdb;


CREATE TABLE Users (
    EmailAddress VARCHAR(255), 
    Password VARCHAR(255) NOT NULL, 
    Country VARCHAR(100) NOT NULL,
    Role TEXT DEFAULT 'Player' CHECK (Role IN ('Admin', 'Player')), -- by default, unless specified is Player
    PRIMARY KEY (EmailAddress, Country));

CREATE TABLE Leaderboard (
    EmailAddress VARCHAR(255) NOT NULL,
    WinsAsX INT NOT NULL,
    PRIMARY KEY (EmailAddress),
    FOREIGN KEY (EmailAddress) REFERENCES Users (EmailAddress) 
);

INSERT INTO Users (EmailAddress, Password, Country, Role) VALUES
('admin@tictactoe.com', 'tic', 'Canada', 'Admin'),
('testplayer@tictactoe.com', 'tic', 'Canada', 'Player'),
('johndoe@tictactoe.com', 'john123', 'USA', 'Player'),
('janedoe@tictactoe.com', 'jane123', 'UK', 'Player'),
('bobsmith@tictactoe.com', 'bob123', 'Australia', 'Player'),
('alicejohnson@tictactoe.com', 'alice123', 'Canada', 'Player'),
('charliebrown@tictactoe.com', 'charlie123', 'USA', 'Player'),
('admin2@tictactoe.com', 'admin123', 'UK', 'Admin'),
('michaelclark@tictactoe.com', 'mike123', 'USA', 'Player'),
('emilydavis@tictactoe.com', 'emily123', 'Germany', 'Player'),
('oliviawilson@tictactoe.com', 'olivia123', 'France', 'Player'),
('noahmartin@tictactoe.com', 'noah123', 'Spain', 'Player'),
('isabellawright@tictactoe.com', 'isabella123', 'Italy', 'Player'),
('admin3@tictactoe.com', 'admin456', 'Germany', 'Admin'),
('admin4@tictactoe.com', 'admin789', 'France', 'Admin');

INSERT INTO Leaderboard (EmailAddress, WinsAsX) VALUES 
('admin@tictactoe.com', 5),
('testplayer@tictactoe.com', 3)
('johndoe@tictactoe.com', 2),
('janedoe@tictactoe.com', 4),
('bobsmith@tictactoe.com', 1),
('alicejohnson@tictactoe.com', 6),
('charliebrown@tictactoe.com', 3),
('admin2@tictactoe.com', 7),
('michaelclark@tictactoe.com', 8),
('emilydavis@tictactoe.com', 5),
('oliviawilson@tictactoe.com', 4),
('noahmartin@tictactoe.com', 7),
('isabellawright@tictactoe.com', 2),
('admin3@tictactoe.com', 9),
('admin4@tictactoe.com', 6);
