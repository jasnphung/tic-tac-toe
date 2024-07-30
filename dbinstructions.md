psql -U postgres

CREATE database 
\c tictacdb

psql -U postgres -d tictacdb -f db/schema.sql