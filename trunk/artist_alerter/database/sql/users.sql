--Creates the database table that will
--hold the users information and preferences
CREATE SEQUENCE user_seq;

CREATE TABLE users (
	user_id int8 NOT NULL DEFAULT nextval('user_seq') CONSTRAINT users_pk PRIMARY KEY,
	username VARCHAR(100) NOT NULL CONSTRAINT username_unique UNIQUE,
	email_address VARCHAR(100) NOT NULL CONSTRAINT email_unique UNIQUE,
	password CHAR(50) NOT NULL,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50)
) WITHOUT OIDS;

INSERT INTO users VALUES(0,'SYSTEM','SYSTEM','SYSTEM','SYSTEM','SYSTEM');
