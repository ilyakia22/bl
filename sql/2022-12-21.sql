ALTER TABLE forum DROP COLUMN status;
ALTER TABLE forum ADD COLUMN status smallint NOT NULL DEFAULT 0;
ALTER TABLE forum DROP COLUMN type_link;
ALTER TABLE forum ADD COLUMN type_link smallint NOT NULL DEFAULT 0;
ALTER TABLE forum DROP COLUMN site_id;
ALTER TABLE forum DROP COLUMN type;
ALTER TABLE forum DROP COLUMN gk_id;
CREATE INDEX ON comment_phone (status);
