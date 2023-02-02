
CREATE TABLE cody
(
    id serial PRIMARY KEY,
    value character varying NOT NULL,
    description text 
);

CREATE TABLE cody_to_organization (
  id  serial PRIMARY KEY,
  cody_id    int REFERENCES cody (id) ON DELETE CASCADE,
  organization_id int REFERENCES organization (id) ON DELETE CASCADE,
  UNIQUE (cody_id, organization_id)
);

ALTER TABLE cody ADD CONSTRAINT cody_value UNIQUE (value);