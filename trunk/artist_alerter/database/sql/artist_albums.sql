--Creates the database table that stores the artists/albums that we have
--also creates the tables that store what users have what artists/albums
CREATE SEQUENCE artist_seq;
CREATE SEQUENCE album_seq;

CREATE TABLE artists (
	artist_id int8 NOT NULL DEFAULT nextval('artist_seq') CONSTRAINT artists_pk PRIMARY KEY,
	name varchar(512) NOT NULL CONSTRAINT artist_name_unique UNIQUE
) WITHOUT OIDS;

CREATE TABLE albums (
	album_id int8 NOT NULL DEFAULT nextval('album_seq') CONSTRAINT albums_pk PRIMARY KEY,
	artist_id int8 NOT NULL CONSTRAINT artist_id_fk REFERENCES artists(artist_id) ON DELETE CASCADE,
	name varchar(512) NOT NULL
) WITHOUT OIDS;

--Contains what users have what artists
CREATE TABLE user_artists (
	user_id int8 NOT NULL CONSTRAINT user_id_fk REFERENCES users(user_id),
	artist_id int8 NOT NULL CONSTRAINT artist_id_fk REFERENCES artists(artist_id),
	CONSTRAINT user_artists_pk PRIMARY KEY (user_id, artist_id)
) WITHOUT OIDS;

--Contains what users have what albums
CREATE TABLE user_albums (
	user_id int8 NOT NULL CONSTRAINT user_id_fk REFERENCES users(user_id),
	album_id int8 NOT NULL CONSTRAINT album_id_fk REFERENCES albums(album_id),
	CONSTRAINT user_albums_pk PRIMARY KEY (user_id, album_id)
) WITHOUT OIDS;