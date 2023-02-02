ALTER TABLE organization_phone
DROP CONSTRAINT organization_id,
ADD CONSTRAINT organization_id
   FOREIGN KEY (organization_id)
   REFERENCES organization(id)
   ON DELETE CASCADE;