-- Table: public.phone_info

-- DROP TABLE IF EXISTS public.phone_info;

CREATE TABLE IF NOT EXISTS public.phone_info
(
    id bigint NOT NULL,
    city_id smallint NOT NULL DEFAULT 0,
    name character varying(255) COLLATE pg_catalog."default" NOT NULL,
    CONSTRAINT phone_info_pkey PRIMARY KEY (id),
    CONSTRAINT phone_info_city_id_fkey FOREIGN KEY (city_id)
        REFERENCES public.city (id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.phone_info
    OWNER to dbcher;
-- Index: phone_info_city_id_idx

-- DROP INDEX IF EXISTS public.phone_info_city_id_idx;

CREATE INDEX IF NOT EXISTS phone_info_city_id_idx
    ON public.phone_info USING btree
    (city_id ASC NULLS LAST)
    TABLESPACE pg_default;