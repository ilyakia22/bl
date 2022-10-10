ALTER TABLE comment_phone DROP COLUMN status;
ALTER TABLE comment_phone ADD COLUMN status smallint;
ALTER TABLE comment_phone ALTER COLUMN status SET DEFAULT 0;
UPDATE comment_phone SET status=0;
ALTER TABLE comment_phone ALTER COLUMN status SET NOT NULL;
CREATE INDEX ON comment_phone (status);