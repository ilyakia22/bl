
CREATE TABLE IF NOT EXISTS public.phone_search
(
    id bigint NOT NULL,
    phone_number bigint NOT NULL,
    secret character(32) COLLATE pg_catalog."default" NOT NULL,
    status smallint NOT NULL,
    ip bigint NOT NULL,
    datetime bigint NOT NULL,
    CONSTRAINT phone_search_pkey PRIMARY KEY (id)
)
	 
CREATE SEQUENCE IF NOT EXISTS public.phone_search_id_seq
    INCREMENT 1
    START 1
    MINVALUE 1
    MAXVALUE 9223372036854775807
    CACHE 1
    OWNED BY phone_search.id;


ALTER TABLE phone_search 
    ALTER COLUMN id 
        SET DEFAULT NEXTVAL('phone_search_id_seq');