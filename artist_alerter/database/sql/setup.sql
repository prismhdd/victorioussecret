--Sets up the database for the web site
DROP DATABASE artist_alert;

CREATE DATABASE artist_alert WITH OWNER=postgres;

\c artist_alert;

\i users.sql
\i artist_albums.sql