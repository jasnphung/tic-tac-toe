psql -U postgres

CREATE database tictacdb

exit

psql -U postgres -d tictacdb -f db/schema.sql

Notes:

While in psql, use \c tictacdb to connect to the database and \dt to list the tables
