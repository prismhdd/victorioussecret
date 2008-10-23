CREATE SEQUENCE recommendation_seq;

CREATE TABLE recommendations (
	recommendation_id int8 NOT NULL DEFAULT nextval('recommendation_seq') CONSTRAINT recommendations_pk PRIMARY KEY,
	to_user_id int8 NOT NULL CONSTRAINT to_user_id_fk REFERENCES users(user_id),
	from_user_id int8 NOT NULL CONSTRAINT from_user_id_fk REFERENCES users(user_id),
	album_id int8 NOT NULL CONSTRAINT album_id_fk REFERENCES albums(album_id),
	note VARCHAR(512), --note to the receiver of the recommendation
	date_added date NOT NULL DEFAULT now()
) WITHOUT OIDS;