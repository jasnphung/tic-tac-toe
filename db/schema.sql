-- CREATE DATABASE tictacdatabase;


CREATE TABLE Users (
    EmailAddress VARCHAR, 
    Password VARCHAR NOT NULL, 
    Country VARCHAR NOT NULL,
    Role TEXT DEFAULT 'Player' CHECK (Role IN ('Admin', 'Player')), -- by default, unless specified is Player
    PRIMARY KEY (EmailAddress, Country));

INSERT INTO Users (EmailAddress, Password, Country, Role) VALUES ('admin@tictactoe.com', 'tic', 'Canada', 'Admin');
INSERT INTO Users (EmailAddress, Password, Country, Role) VALUES ('testplayer@tictactoe.com', 'tic', 'Canada', 'Player');