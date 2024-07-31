psql -U postgres

CREATE database tictacdb

exit

psql -U postgres -d tictacdb -f db/schema.sql
