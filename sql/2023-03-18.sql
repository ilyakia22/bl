ALTER TABLE phone_info ADD COLUMN status smallint;
ALTER TABLE phone_info ALTER COLUMN status SET DEFAULT 0;
UPDATE phone_info SET status=0;
CREATE INDEX ON phone_info (status);
ALTER TABLE phone_info ALTER COLUMN city_id DROP NOT NULL;
ALTER TABLE phone_info ALTER COLUMN city_id SET DEFAULT NULL;