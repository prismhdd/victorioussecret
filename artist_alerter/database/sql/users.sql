--Creates the database table that will
--hold the users information and preferences
CREATE SEQUENCE user_seq;
CREATE SEQUENCE user_index_seq;

CREATE TABLE users (
	user_id int8 NOT NULL DEFAULT nextval('user_seq') CONSTRAINT users_pk PRIMARY KEY,
	username VARCHAR(100) NOT NULL CONSTRAINT username_unique UNIQUE,
	email_address VARCHAR(100) NOT NULL CONSTRAINT email_unique UNIQUE,
	password CHAR(50) NOT NULL,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50),
	date_added date NOT NULL DEFAULT now()
) WITHOUT OIDS;

CREATE TABLE user_index (
	user_index_id int8 NOT NULL DEFAULT nextval('user_index_seq') CONSTRAINT user_index_pk PRIMARY KEY,
	user_id int8 NOT NULL, --CONSTRAINT user_id_fk REFERENCES users(user_id) ON DELETE CASCADE,
	keyword varchar(255) NOT NULL,
	field varchar(15) NOT NULL,
	position int8 NOT NULL
) WITHOUT OIDS;

INSERT INTO users VALUES(nextval('user_seq'),'SYSTEM','SYSTEM','SYSTEM','SYSTEM','SYSTEM');
