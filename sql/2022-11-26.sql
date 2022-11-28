CREATE SEQUENCE IF NOT EXISTS public.organization_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1
    OWNED BY organization.id;

ALTER SEQUENCE public.organization_id_seq
    OWNER TO dbcher;

CREATE TABLE IF NOT EXISTS public.organization
(
    id bigint NOT NULL DEFAULT nextval('organization_id_seq'::regclass),
    fullname character varying(255) COLLATE pg_catalog."default" NOT NULL,
    shortname character varying(255) COLLATE pg_catalog."default",
    ogrn bigint,
    type smallint,
    info json,
    inn bigint,
    CONSTRAINT organization_pkey PRIMARY KEY (id),
    CONSTRAINT inn_ogrn UNIQUE (inn, ogrn)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.organization
    OWNER to dbcher;
-- Index: ogrn

-- DROP INDEX IF EXISTS public.ogrn;

CREATE INDEX IF NOT EXISTS ogrn
    ON public.organization USING btree
    (ogrn ASC NULLS LAST)
    TABLESPACE pg_default;
-- Index: organization_inn

-- DROP INDEX IF EXISTS public.organization_inn;

CREATE INDEX IF NOT EXISTS organization_inn
    ON public.organization USING btree
    (inn ASC NULLS LAST)
    TABLESPACE pg_default;