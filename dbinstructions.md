psql -U postgres

CREATE database tictacdb

exit

psql -U postgres -d tictacdb -f db/schema.sql

Notes:

For the error "Connection failed: could not find driver", make sure extension=pdo_pgsql does not have a leading ";" in php.ini

While in PSQL, use \c tictacdb to connect to the database and \dt to list the tables
