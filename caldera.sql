--
-- PostgreSQL database dump
--

\restrict Ul4ML38UZgxbHFMu6BpVCIdECWlCzdNekkkR6LhlYgfajXgxdywibOv2RTjbBDq

-- Dumped from database version 16.10
-- Dumped by pg_dump version 16.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: event_reservations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.event_reservations (
    id bigint NOT NULL,
    booking_code character varying(255) NOT NULL,
    event_id bigint NOT NULL,
    customer_name character varying(255) NOT NULL,
    customer_email character varying(255) NOT NULL,
    customer_phone character varying(255) NOT NULL,
    number_of_tickets integer NOT NULL,
    total_amount numeric(10,2) NOT NULL,
    payment_status character varying(255) DEFAULT 'unpaid'::character varying NOT NULL,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    user_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT event_reservations_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['unpaid'::character varying, 'paid'::character varying])::text[]))),
    CONSTRAINT event_reservations_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'confirmed'::character varying, 'cancelled'::character varying])::text[])))
);


ALTER TABLE public.event_reservations OWNER TO postgres;

--
-- Name: event_reservations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.event_reservations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.event_reservations_id_seq OWNER TO postgres;

--
-- Name: event_reservations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.event_reservations_id_seq OWNED BY public.event_reservations.id;


--
-- Name: events; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.events (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text NOT NULL,
    banner_image character varying(255) NOT NULL,
    start_date timestamp(0) without time zone NOT NULL,
    end_date timestamp(0) without time zone NOT NULL,
    location character varying(255) NOT NULL,
    max_participants integer,
    ticket_price numeric(10,2),
    event_schedule json,
    contact_info json,
    is_featured boolean DEFAULT false NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    promo_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.events OWNER TO postgres;

--
-- Name: events_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.events_id_seq OWNER TO postgres;

--
-- Name: events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;


--
-- Name: galleries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.galleries (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    type character varying(255) DEFAULT 'image'::character varying NOT NULL,
    file_path character varying(255) NOT NULL,
    menu_id bigint,
    event_id bigint,
    promo_id bigint,
    testimonial_id bigint,
    category character varying(255),
    description text,
    is_featured boolean DEFAULT false NOT NULL,
    sort_order integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT check_single_parent CHECK ((((menu_id IS NOT NULL) AND (event_id IS NULL) AND (promo_id IS NULL) AND (testimonial_id IS NULL)) OR ((menu_id IS NULL) AND (event_id IS NOT NULL) AND (promo_id IS NULL) AND (testimonial_id IS NULL)) OR ((menu_id IS NULL) AND (event_id IS NULL) AND (promo_id IS NOT NULL) AND (testimonial_id IS NULL)) OR ((menu_id IS NULL) AND (event_id IS NULL) AND (promo_id IS NULL) AND (testimonial_id IS NOT NULL)))),
    CONSTRAINT galleries_type_check CHECK (((type)::text = ANY ((ARRAY['image'::character varying, 'video'::character varying])::text[])))
);


ALTER TABLE public.galleries OWNER TO postgres;

--
-- Name: galleries_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.galleries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.galleries_id_seq OWNER TO postgres;

--
-- Name: galleries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.galleries_id_seq OWNED BY public.galleries.id;


--
-- Name: menus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menus (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    category character varying(255) NOT NULL,
    description text NOT NULL,
    price numeric(10,2) NOT NULL,
    image character varying(255),
    is_available boolean DEFAULT true NOT NULL,
    is_recommended boolean DEFAULT false NOT NULL,
    sort_order integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.menus OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menus_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menus_id_seq OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payments (
    id bigint NOT NULL,
    payment_code character varying(255) NOT NULL,
    payable_type character varying(255) NOT NULL,
    payable_id bigint NOT NULL,
    amount numeric(10,2) NOT NULL,
    payment_type character varying(255) NOT NULL,
    payment_method character varying(255) NOT NULL,
    bank_name character varying(255),
    account_number character varying(255),
    account_name character varying(255),
    payment_proof character varying(255),
    payment_status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    notes text,
    verified_at timestamp(0) without time zone,
    verified_by bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT payments_payment_method_check CHECK (((payment_method)::text = ANY ((ARRAY['cash'::character varying, 'transfer'::character varying, 'credit_card'::character varying, 'e_wallet'::character varying])::text[]))),
    CONSTRAINT payments_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['pending'::character varying, 'verified'::character varying, 'rejected'::character varying])::text[]))),
    CONSTRAINT payments_payment_type_check CHECK (((payment_type)::text = ANY ((ARRAY['down_payment'::character varying, 'full_payment'::character varying])::text[])))
);


ALTER TABLE public.payments OWNER TO postgres;

--
-- Name: payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payments_id_seq OWNER TO postgres;

--
-- Name: payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payments_id_seq OWNED BY public.payments.id;


--
-- Name: pool_tickets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pool_tickets (
    id bigint NOT NULL,
    ticket_code character varying(255) NOT NULL,
    customer_name character varying(255) NOT NULL,
    customer_email character varying(255) NOT NULL,
    customer_phone character varying(255) NOT NULL,
    visit_date date NOT NULL,
    visit_time time(0) without time zone,
    number_of_tickets integer NOT NULL,
    ticket_type character varying(255) DEFAULT 'adult'::character varying NOT NULL,
    price_per_ticket numeric(10,2) NOT NULL,
    total_amount numeric(10,2) NOT NULL,
    payment_status character varying(255) DEFAULT 'unpaid'::character varying NOT NULL,
    payment_method character varying(255),
    payment_proof character varying(255),
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    used_at timestamp(0) without time zone,
    user_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT pool_tickets_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['unpaid'::character varying, 'paid'::character varying])::text[]))),
    CONSTRAINT pool_tickets_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'used'::character varying, 'expired'::character varying, 'cancelled'::character varying])::text[]))),
    CONSTRAINT pool_tickets_ticket_type_check CHECK (((ticket_type)::text = ANY ((ARRAY['adult'::character varying, 'child'::character varying, 'family'::character varying])::text[])))
);


ALTER TABLE public.pool_tickets OWNER TO postgres;

--
-- Name: pool_tickets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pool_tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pool_tickets_id_seq OWNER TO postgres;

--
-- Name: pool_tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pool_tickets_id_seq OWNED BY public.pool_tickets.id;


--
-- Name: promo_menu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.promo_menu (
    id bigint NOT NULL,
    promo_id bigint NOT NULL,
    menu_id bigint NOT NULL,
    special_price numeric(10,2),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.promo_menu OWNER TO postgres;

--
-- Name: promo_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.promo_menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.promo_menu_id_seq OWNER TO postgres;

--
-- Name: promo_menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.promo_menu_id_seq OWNED BY public.promo_menu.id;


--
-- Name: promos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.promos (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text NOT NULL,
    banner_image character varying(255) NOT NULL,
    discount_type character varying(255) DEFAULT 'percentage'::character varying NOT NULL,
    discount_value numeric(10,2) NOT NULL,
    promo_code character varying(255),
    promo_type character varying(255) DEFAULT 'menu'::character varying NOT NULL,
    min_purchase numeric(10,2),
    max_discount numeric(10,2),
    start_date timestamp(0) without time zone NOT NULL,
    end_date timestamp(0) without time zone NOT NULL,
    applicable_for json,
    max_usage integer,
    used_count integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT promos_discount_type_check CHECK (((discount_type)::text = ANY ((ARRAY['percentage'::character varying, 'nominal'::character varying])::text[]))),
    CONSTRAINT promos_promo_type_check CHECK (((promo_type)::text = ANY ((ARRAY['menu'::character varying, 'ticket'::character varying, 'reservation'::character varying, 'event'::character varying])::text[])))
);


ALTER TABLE public.promos OWNER TO postgres;

--
-- Name: promos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.promos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.promos_id_seq OWNER TO postgres;

--
-- Name: promos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.promos_id_seq OWNED BY public.promos.id;


--
-- Name: table_reservations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.table_reservations (
    id bigint NOT NULL,
    booking_code character varying(255) NOT NULL,
    customer_name character varying(255) NOT NULL,
    customer_email character varying(255) NOT NULL,
    customer_phone character varying(255) NOT NULL,
    reservation_date date NOT NULL,
    reservation_time time(0) without time zone NOT NULL,
    number_of_guests integer NOT NULL,
    table_numbers json,
    special_requests text,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    down_payment numeric(10,2),
    payment_status character varying(255) DEFAULT 'unpaid'::character varying NOT NULL,
    payment_proof character varying(255),
    cancellation_reason text,
    confirmed_at timestamp(0) without time zone,
    cancelled_at timestamp(0) without time zone,
    user_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT table_reservations_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['unpaid'::character varying, 'partial'::character varying, 'paid'::character varying])::text[]))),
    CONSTRAINT table_reservations_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'confirmed'::character varying, 'cancelled'::character varying, 'completed'::character varying])::text[])))
);


ALTER TABLE public.table_reservations OWNER TO postgres;

--
-- Name: table_reservations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.table_reservations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.table_reservations_id_seq OWNER TO postgres;

--
-- Name: table_reservations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.table_reservations_id_seq OWNED BY public.table_reservations.id;


--
-- Name: testimonials; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.testimonials (
    id bigint NOT NULL,
    customer_name character varying(255) NOT NULL,
    customer_email character varying(255),
    customer_photo character varying(255),
    rating integer NOT NULL,
    comment text NOT NULL,
    service_type character varying(255),
    visit_date date,
    is_approved boolean DEFAULT false NOT NULL,
    is_featured boolean DEFAULT false NOT NULL,
    approved_at timestamp(0) without time zone,
    approved_by bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.testimonials OWNER TO postgres;

--
-- Name: testimonials_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.testimonials_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.testimonials_id_seq OWNER TO postgres;

--
-- Name: testimonials_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.testimonials_id_seq OWNED BY public.testimonials.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    role character varying(255) DEFAULT 'customer'::character varying NOT NULL,
    phone character varying(255),
    avatar character varying(255),
    is_active boolean DEFAULT true NOT NULL,
    email_verified_at timestamp(0) without time zone,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['admin'::character varying, 'staff'::character varying, 'customer'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: event_reservations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations ALTER COLUMN id SET DEFAULT nextval('public.event_reservations_id_seq'::regclass);


--
-- Name: events id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);


--
-- Name: galleries id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries ALTER COLUMN id SET DEFAULT nextval('public.galleries_id_seq'::regclass);


--
-- Name: menus id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: payments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments ALTER COLUMN id SET DEFAULT nextval('public.payments_id_seq'::regclass);


--
-- Name: pool_tickets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pool_tickets ALTER COLUMN id SET DEFAULT nextval('public.pool_tickets_id_seq'::regclass);


--
-- Name: promo_menu id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu ALTER COLUMN id SET DEFAULT nextval('public.promo_menu_id_seq'::regclass);


--
-- Name: promos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promos ALTER COLUMN id SET DEFAULT nextval('public.promos_id_seq'::regclass);


--
-- Name: table_reservations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_reservations ALTER COLUMN id SET DEFAULT nextval('public.table_reservations_id_seq'::regclass);


--
-- Name: testimonials id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials ALTER COLUMN id SET DEFAULT nextval('public.testimonials_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: event_reservations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.event_reservations (id, booking_code, event_id, customer_name, customer_email, customer_phone, number_of_tickets, total_amount, payment_status, status, user_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.events (id, title, slug, description, banner_image, start_date, end_date, location, max_participants, ticket_price, event_schedule, contact_info, is_featured, is_active, promo_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: galleries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.galleries (id, title, type, file_path, menu_id, event_id, promo_id, testimonial_id, category, description, is_featured, sort_order, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menus (id, name, category, description, price, image, is_available, is_recommended, sort_order, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	2026_03_11_062811_create_menus_table	1
3	2026_03_11_062955_create_galleries_table	1
4	2026_03_11_063017_create_promos_table	1
5	2026_03_11_063037_create_events_table	1
6	2026_03_11_063059_create_testimonials_table	1
7	2026_03_11_063124_create_table_reservations_table	1
8	2026_03_11_063608_create_pool_tickets_table	1
9	2026_03_11_063625_create_promo_menu_table	1
10	2026_03_11_063642_create_event_reservations_table	1
11	2026_03_11_064139_create_payments_table	1
12	2026_03_11_073040_update_galleries_table_with_foreign_keys	1
\.


--
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (id, payment_code, payable_type, payable_id, amount, payment_type, payment_method, bank_name, account_number, account_name, payment_proof, payment_status, notes, verified_at, verified_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: pool_tickets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pool_tickets (id, ticket_code, customer_name, customer_email, customer_phone, visit_date, visit_time, number_of_tickets, ticket_type, price_per_ticket, total_amount, payment_status, payment_method, payment_proof, status, used_at, user_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: promo_menu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.promo_menu (id, promo_id, menu_id, special_price, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: promos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.promos (id, title, slug, description, banner_image, discount_type, discount_value, promo_code, promo_type, min_purchase, max_discount, start_date, end_date, applicable_for, max_usage, used_count, is_active, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: table_reservations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.table_reservations (id, booking_code, customer_name, customer_email, customer_phone, reservation_date, reservation_time, number_of_guests, table_numbers, special_requests, status, down_payment, payment_status, payment_proof, cancellation_reason, confirmed_at, cancelled_at, user_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: testimonials; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.testimonials (id, customer_name, customer_email, customer_photo, rating, comment, service_type, visit_date, is_approved, is_featured, approved_at, approved_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, password, role, phone, avatar, is_active, email_verified_at, remember_token, created_at, updated_at) FROM stdin;
\.


--
-- Name: event_reservations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.event_reservations_id_seq', 1, false);


--
-- Name: events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.events_id_seq', 1, false);


--
-- Name: galleries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.galleries_id_seq', 1, false);


--
-- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menus_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 12, true);


--
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_id_seq', 1, false);


--
-- Name: pool_tickets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pool_tickets_id_seq', 1, false);


--
-- Name: promo_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.promo_menu_id_seq', 1, false);


--
-- Name: promos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.promos_id_seq', 1, false);


--
-- Name: table_reservations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.table_reservations_id_seq', 1, false);


--
-- Name: testimonials_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.testimonials_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: event_reservations event_reservations_booking_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations
    ADD CONSTRAINT event_reservations_booking_code_unique UNIQUE (booking_code);


--
-- Name: event_reservations event_reservations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations
    ADD CONSTRAINT event_reservations_pkey PRIMARY KEY (id);


--
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- Name: events events_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_slug_unique UNIQUE (slug);


--
-- Name: galleries galleries_event_id_sort_order_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_event_id_sort_order_unique UNIQUE (event_id, sort_order);


--
-- Name: galleries galleries_menu_id_sort_order_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_menu_id_sort_order_unique UNIQUE (menu_id, sort_order);


--
-- Name: galleries galleries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_pkey PRIMARY KEY (id);


--
-- Name: galleries galleries_promo_id_sort_order_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_promo_id_sort_order_unique UNIQUE (promo_id, sort_order);


--
-- Name: galleries galleries_testimonial_id_sort_order_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_testimonial_id_sort_order_unique UNIQUE (testimonial_id, sort_order);


--
-- Name: menus menus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: payments payments_payment_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_payment_code_unique UNIQUE (payment_code);


--
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- Name: pool_tickets pool_tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pool_tickets
    ADD CONSTRAINT pool_tickets_pkey PRIMARY KEY (id);


--
-- Name: pool_tickets pool_tickets_ticket_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pool_tickets
    ADD CONSTRAINT pool_tickets_ticket_code_unique UNIQUE (ticket_code);


--
-- Name: promo_menu promo_menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu
    ADD CONSTRAINT promo_menu_pkey PRIMARY KEY (id);


--
-- Name: promo_menu promo_menu_promo_id_menu_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu
    ADD CONSTRAINT promo_menu_promo_id_menu_id_unique UNIQUE (promo_id, menu_id);


--
-- Name: promos promos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promos
    ADD CONSTRAINT promos_pkey PRIMARY KEY (id);


--
-- Name: promos promos_promo_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promos
    ADD CONSTRAINT promos_promo_code_unique UNIQUE (promo_code);


--
-- Name: promos promos_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promos
    ADD CONSTRAINT promos_slug_unique UNIQUE (slug);


--
-- Name: table_reservations table_reservations_booking_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_reservations
    ADD CONSTRAINT table_reservations_booking_code_unique UNIQUE (booking_code);


--
-- Name: table_reservations table_reservations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_reservations
    ADD CONSTRAINT table_reservations_pkey PRIMARY KEY (id);


--
-- Name: testimonials testimonials_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials
    ADD CONSTRAINT testimonials_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: event_reservations_booking_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_booking_code_index ON public.event_reservations USING btree (booking_code);


--
-- Name: event_reservations_event_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_event_id_index ON public.event_reservations USING btree (event_id);


--
-- Name: event_reservations_payment_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_payment_status_index ON public.event_reservations USING btree (payment_status);


--
-- Name: event_reservations_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_status_index ON public.event_reservations USING btree (status);


--
-- Name: event_reservations_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_user_id_index ON public.event_reservations USING btree (user_id);


--
-- Name: events_end_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_end_date_index ON public.events USING btree (end_date);


--
-- Name: events_is_active_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_is_active_index ON public.events USING btree (is_active);


--
-- Name: events_promo_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_promo_id_index ON public.events USING btree (promo_id);


--
-- Name: events_slug_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_slug_index ON public.events USING btree (slug);


--
-- Name: events_start_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_start_date_index ON public.events USING btree (start_date);


--
-- Name: galleries_category_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_category_index ON public.galleries USING btree (category);


--
-- Name: galleries_event_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_event_id_index ON public.galleries USING btree (event_id);


--
-- Name: galleries_is_featured_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_is_featured_index ON public.galleries USING btree (is_featured);


--
-- Name: galleries_menu_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_menu_id_index ON public.galleries USING btree (menu_id);


--
-- Name: galleries_promo_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_promo_id_index ON public.galleries USING btree (promo_id);


--
-- Name: galleries_testimonial_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_testimonial_id_index ON public.galleries USING btree (testimonial_id);


--
-- Name: menus_category_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX menus_category_index ON public.menus USING btree (category);


--
-- Name: menus_is_available_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX menus_is_available_index ON public.menus USING btree (is_available);


--
-- Name: menus_is_recommended_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX menus_is_recommended_index ON public.menus USING btree (is_recommended);


--
-- Name: payments_payable_type_payable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_payable_type_payable_id_index ON public.payments USING btree (payable_type, payable_id);


--
-- Name: payments_payment_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_payment_code_index ON public.payments USING btree (payment_code);


--
-- Name: payments_payment_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_payment_status_index ON public.payments USING btree (payment_status);


--
-- Name: payments_verified_by_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_verified_by_index ON public.payments USING btree (verified_by);


--
-- Name: pool_tickets_payment_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_payment_status_index ON public.pool_tickets USING btree (payment_status);


--
-- Name: pool_tickets_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_status_index ON public.pool_tickets USING btree (status);


--
-- Name: pool_tickets_ticket_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_ticket_code_index ON public.pool_tickets USING btree (ticket_code);


--
-- Name: pool_tickets_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_user_id_index ON public.pool_tickets USING btree (user_id);


--
-- Name: pool_tickets_visit_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_visit_date_index ON public.pool_tickets USING btree (visit_date);


--
-- Name: promo_menu_menu_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promo_menu_menu_id_index ON public.promo_menu USING btree (menu_id);


--
-- Name: promo_menu_promo_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promo_menu_promo_id_index ON public.promo_menu USING btree (promo_id);


--
-- Name: promos_end_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_end_date_index ON public.promos USING btree (end_date);


--
-- Name: promos_is_active_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_is_active_index ON public.promos USING btree (is_active);


--
-- Name: promos_promo_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_promo_code_index ON public.promos USING btree (promo_code);


--
-- Name: promos_promo_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_promo_type_index ON public.promos USING btree (promo_type);


--
-- Name: promos_slug_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_slug_index ON public.promos USING btree (slug);


--
-- Name: promos_start_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_start_date_index ON public.promos USING btree (start_date);


--
-- Name: table_reservations_booking_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_booking_code_index ON public.table_reservations USING btree (booking_code);


--
-- Name: table_reservations_payment_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_payment_status_index ON public.table_reservations USING btree (payment_status);


--
-- Name: table_reservations_reservation_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_reservation_date_index ON public.table_reservations USING btree (reservation_date);


--
-- Name: table_reservations_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_status_index ON public.table_reservations USING btree (status);


--
-- Name: table_reservations_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_user_id_index ON public.table_reservations USING btree (user_id);


--
-- Name: testimonials_is_approved_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX testimonials_is_approved_index ON public.testimonials USING btree (is_approved);


--
-- Name: testimonials_is_featured_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX testimonials_is_featured_index ON public.testimonials USING btree (is_featured);


--
-- Name: testimonials_rating_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX testimonials_rating_index ON public.testimonials USING btree (rating);


--
-- Name: testimonials_service_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX testimonials_service_type_index ON public.testimonials USING btree (service_type);


--
-- Name: users_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX users_email_index ON public.users USING btree (email);


--
-- Name: users_role_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX users_role_index ON public.users USING btree (role);


--
-- Name: event_reservations event_reservations_event_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations
    ADD CONSTRAINT event_reservations_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;


--
-- Name: event_reservations event_reservations_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations
    ADD CONSTRAINT event_reservations_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: events events_promo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_promo_id_foreign FOREIGN KEY (promo_id) REFERENCES public.promos(id) ON DELETE SET NULL;


--
-- Name: galleries galleries_event_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;


--
-- Name: galleries galleries_menu_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_menu_id_foreign FOREIGN KEY (menu_id) REFERENCES public.menus(id) ON DELETE CASCADE;


--
-- Name: galleries galleries_promo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_promo_id_foreign FOREIGN KEY (promo_id) REFERENCES public.promos(id) ON DELETE CASCADE;


--
-- Name: galleries galleries_testimonial_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_testimonial_id_foreign FOREIGN KEY (testimonial_id) REFERENCES public.testimonials(id) ON DELETE CASCADE;


--
-- Name: payments payments_verified_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_verified_by_foreign FOREIGN KEY (verified_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: pool_tickets pool_tickets_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pool_tickets
    ADD CONSTRAINT pool_tickets_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: promo_menu promo_menu_menu_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu
    ADD CONSTRAINT promo_menu_menu_id_foreign FOREIGN KEY (menu_id) REFERENCES public.menus(id) ON DELETE CASCADE;


--
-- Name: promo_menu promo_menu_promo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu
    ADD CONSTRAINT promo_menu_promo_id_foreign FOREIGN KEY (promo_id) REFERENCES public.promos(id) ON DELETE CASCADE;


--
-- Name: table_reservations table_reservations_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_reservations
    ADD CONSTRAINT table_reservations_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: testimonials testimonials_approved_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials
    ADD CONSTRAINT testimonials_approved_by_foreign FOREIGN KEY (approved_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: TABLE event_reservations; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.event_reservations TO admin_role;


--
-- Name: SEQUENCE event_reservations_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.event_reservations_id_seq TO admin_role;


--
-- Name: TABLE events; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.events TO admin_role;


--
-- Name: SEQUENCE events_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.events_id_seq TO admin_role;


--
-- Name: TABLE galleries; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.galleries TO admin_role;


--
-- Name: SEQUENCE galleries_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.galleries_id_seq TO admin_role;


--
-- Name: TABLE menus; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.menus TO admin_role;


--
-- Name: SEQUENCE menus_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.menus_id_seq TO admin_role;


--
-- Name: TABLE migrations; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.migrations TO admin_role;


--
-- Name: SEQUENCE migrations_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.migrations_id_seq TO admin_role;


--
-- Name: TABLE payments; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.payments TO admin_role;


--
-- Name: SEQUENCE payments_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.payments_id_seq TO admin_role;


--
-- Name: TABLE pool_tickets; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.pool_tickets TO admin_role;


--
-- Name: SEQUENCE pool_tickets_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.pool_tickets_id_seq TO admin_role;


--
-- Name: TABLE promo_menu; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.promo_menu TO admin_role;


--
-- Name: SEQUENCE promo_menu_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.promo_menu_id_seq TO admin_role;


--
-- Name: TABLE promos; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.promos TO admin_role;


--
-- Name: SEQUENCE promos_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.promos_id_seq TO admin_role;


--
-- Name: TABLE table_reservations; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.table_reservations TO admin_role;


--
-- Name: SEQUENCE table_reservations_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.table_reservations_id_seq TO admin_role;


--
-- Name: TABLE testimonials; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.testimonials TO admin_role;


--
-- Name: SEQUENCE testimonials_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.testimonials_id_seq TO admin_role;


--
-- Name: TABLE users; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.users TO admin_role;


--
-- Name: SEQUENCE users_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.users_id_seq TO admin_role;


--
-- PostgreSQL database dump complete
--

\unrestrict Ul4ML38UZgxbHFMu6BpVCIdECWlCzdNekkkR6LhlYgfajXgxdywibOv2RTjbBDq

--
-- PostgreSQL database dump
--

\restrict b3OpJBYfpXn6WbdTHYwx5i5vzyEKPYYWG1rltJOLcJXAcEe5gOBukaAbtNDtjAv

-- Dumped from database version 16.10
-- Dumped by pg_dump version 16.10

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: event_reservations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.event_reservations (
    id bigint NOT NULL,
    booking_code character varying(255) NOT NULL,
    event_id bigint NOT NULL,
    customer_name character varying(255) NOT NULL,
    customer_email character varying(255) NOT NULL,
    customer_phone character varying(255) NOT NULL,
    number_of_tickets integer NOT NULL,
    total_amount numeric(10,2) NOT NULL,
    payment_status character varying(255) DEFAULT 'unpaid'::character varying NOT NULL,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    user_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT event_reservations_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['unpaid'::character varying, 'paid'::character varying])::text[]))),
    CONSTRAINT event_reservations_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'confirmed'::character varying, 'cancelled'::character varying])::text[])))
);


ALTER TABLE public.event_reservations OWNER TO postgres;

--
-- Name: event_reservations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.event_reservations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.event_reservations_id_seq OWNER TO postgres;

--
-- Name: event_reservations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.event_reservations_id_seq OWNED BY public.event_reservations.id;


--
-- Name: events; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.events (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text NOT NULL,
    banner_image character varying(255) NOT NULL,
    start_date timestamp(0) without time zone NOT NULL,
    end_date timestamp(0) without time zone NOT NULL,
    location character varying(255) NOT NULL,
    max_participants integer,
    ticket_price numeric(10,2),
    event_schedule json,
    contact_info json,
    is_featured boolean DEFAULT false NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    promo_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.events OWNER TO postgres;

--
-- Name: events_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.events_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.events_id_seq OWNER TO postgres;

--
-- Name: events_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.events_id_seq OWNED BY public.events.id;


--
-- Name: galleries; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.galleries (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    type character varying(255) DEFAULT 'image'::character varying NOT NULL,
    file_path character varying(255) NOT NULL,
    menu_id bigint,
    event_id bigint,
    promo_id bigint,
    testimonial_id bigint,
    category character varying(255),
    description text,
    is_featured boolean DEFAULT false NOT NULL,
    sort_order integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT check_single_parent CHECK ((((menu_id IS NOT NULL) AND (event_id IS NULL) AND (promo_id IS NULL) AND (testimonial_id IS NULL)) OR ((menu_id IS NULL) AND (event_id IS NOT NULL) AND (promo_id IS NULL) AND (testimonial_id IS NULL)) OR ((menu_id IS NULL) AND (event_id IS NULL) AND (promo_id IS NOT NULL) AND (testimonial_id IS NULL)) OR ((menu_id IS NULL) AND (event_id IS NULL) AND (promo_id IS NULL) AND (testimonial_id IS NOT NULL)))),
    CONSTRAINT galleries_type_check CHECK (((type)::text = ANY ((ARRAY['image'::character varying, 'video'::character varying])::text[])))
);


ALTER TABLE public.galleries OWNER TO postgres;

--
-- Name: galleries_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.galleries_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.galleries_id_seq OWNER TO postgres;

--
-- Name: galleries_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.galleries_id_seq OWNED BY public.galleries.id;


--
-- Name: menus; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.menus (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    category character varying(255) NOT NULL,
    description text NOT NULL,
    price numeric(10,2) NOT NULL,
    image character varying(255),
    is_available boolean DEFAULT true NOT NULL,
    is_recommended boolean DEFAULT false NOT NULL,
    sort_order integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.menus OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.menus_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.menus_id_seq OWNER TO postgres;

--
-- Name: menus_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.menus_id_seq OWNED BY public.menus.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: payments; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.payments (
    id bigint NOT NULL,
    payment_code character varying(255) NOT NULL,
    payable_type character varying(255) NOT NULL,
    payable_id bigint NOT NULL,
    amount numeric(10,2) NOT NULL,
    payment_type character varying(255) NOT NULL,
    payment_method character varying(255) NOT NULL,
    bank_name character varying(255),
    account_number character varying(255),
    account_name character varying(255),
    payment_proof character varying(255),
    payment_status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    notes text,
    verified_at timestamp(0) without time zone,
    verified_by bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT payments_payment_method_check CHECK (((payment_method)::text = ANY ((ARRAY['cash'::character varying, 'transfer'::character varying, 'credit_card'::character varying, 'e_wallet'::character varying])::text[]))),
    CONSTRAINT payments_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['pending'::character varying, 'verified'::character varying, 'rejected'::character varying])::text[]))),
    CONSTRAINT payments_payment_type_check CHECK (((payment_type)::text = ANY ((ARRAY['down_payment'::character varying, 'full_payment'::character varying])::text[])))
);


ALTER TABLE public.payments OWNER TO postgres;

--
-- Name: payments_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.payments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.payments_id_seq OWNER TO postgres;

--
-- Name: payments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.payments_id_seq OWNED BY public.payments.id;


--
-- Name: pool_tickets; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.pool_tickets (
    id bigint NOT NULL,
    ticket_code character varying(255) NOT NULL,
    customer_name character varying(255) NOT NULL,
    customer_email character varying(255) NOT NULL,
    customer_phone character varying(255) NOT NULL,
    visit_date date NOT NULL,
    visit_time time(0) without time zone,
    number_of_tickets integer NOT NULL,
    ticket_type character varying(255) DEFAULT 'adult'::character varying NOT NULL,
    price_per_ticket numeric(10,2) NOT NULL,
    total_amount numeric(10,2) NOT NULL,
    payment_status character varying(255) DEFAULT 'unpaid'::character varying NOT NULL,
    payment_method character varying(255),
    payment_proof character varying(255),
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    used_at timestamp(0) without time zone,
    user_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT pool_tickets_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['unpaid'::character varying, 'paid'::character varying])::text[]))),
    CONSTRAINT pool_tickets_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'used'::character varying, 'expired'::character varying, 'cancelled'::character varying])::text[]))),
    CONSTRAINT pool_tickets_ticket_type_check CHECK (((ticket_type)::text = ANY ((ARRAY['adult'::character varying, 'child'::character varying, 'family'::character varying])::text[])))
);


ALTER TABLE public.pool_tickets OWNER TO postgres;

--
-- Name: pool_tickets_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.pool_tickets_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.pool_tickets_id_seq OWNER TO postgres;

--
-- Name: pool_tickets_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.pool_tickets_id_seq OWNED BY public.pool_tickets.id;


--
-- Name: promo_menu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.promo_menu (
    id bigint NOT NULL,
    promo_id bigint NOT NULL,
    menu_id bigint NOT NULL,
    special_price numeric(10,2),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.promo_menu OWNER TO postgres;

--
-- Name: promo_menu_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.promo_menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.promo_menu_id_seq OWNER TO postgres;

--
-- Name: promo_menu_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.promo_menu_id_seq OWNED BY public.promo_menu.id;


--
-- Name: promos; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.promos (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    description text NOT NULL,
    banner_image character varying(255) NOT NULL,
    discount_type character varying(255) DEFAULT 'percentage'::character varying NOT NULL,
    discount_value numeric(10,2) NOT NULL,
    promo_code character varying(255),
    promo_type character varying(255) DEFAULT 'menu'::character varying NOT NULL,
    min_purchase numeric(10,2),
    max_discount numeric(10,2),
    start_date timestamp(0) without time zone NOT NULL,
    end_date timestamp(0) without time zone NOT NULL,
    applicable_for json,
    max_usage integer,
    used_count integer DEFAULT 0 NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT promos_discount_type_check CHECK (((discount_type)::text = ANY ((ARRAY['percentage'::character varying, 'nominal'::character varying])::text[]))),
    CONSTRAINT promos_promo_type_check CHECK (((promo_type)::text = ANY ((ARRAY['menu'::character varying, 'ticket'::character varying, 'reservation'::character varying, 'event'::character varying])::text[])))
);


ALTER TABLE public.promos OWNER TO postgres;

--
-- Name: promos_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.promos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.promos_id_seq OWNER TO postgres;

--
-- Name: promos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.promos_id_seq OWNED BY public.promos.id;


--
-- Name: table_reservations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.table_reservations (
    id bigint NOT NULL,
    booking_code character varying(255) NOT NULL,
    customer_name character varying(255) NOT NULL,
    customer_email character varying(255) NOT NULL,
    customer_phone character varying(255) NOT NULL,
    reservation_date date NOT NULL,
    reservation_time time(0) without time zone NOT NULL,
    number_of_guests integer NOT NULL,
    table_numbers json,
    special_requests text,
    status character varying(255) DEFAULT 'pending'::character varying NOT NULL,
    down_payment numeric(10,2),
    payment_status character varying(255) DEFAULT 'unpaid'::character varying NOT NULL,
    payment_proof character varying(255),
    cancellation_reason text,
    confirmed_at timestamp(0) without time zone,
    cancelled_at timestamp(0) without time zone,
    user_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT table_reservations_payment_status_check CHECK (((payment_status)::text = ANY ((ARRAY['unpaid'::character varying, 'partial'::character varying, 'paid'::character varying])::text[]))),
    CONSTRAINT table_reservations_status_check CHECK (((status)::text = ANY ((ARRAY['pending'::character varying, 'confirmed'::character varying, 'cancelled'::character varying, 'completed'::character varying])::text[])))
);


ALTER TABLE public.table_reservations OWNER TO postgres;

--
-- Name: table_reservations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.table_reservations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.table_reservations_id_seq OWNER TO postgres;

--
-- Name: table_reservations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.table_reservations_id_seq OWNED BY public.table_reservations.id;


--
-- Name: testimonials; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.testimonials (
    id bigint NOT NULL,
    customer_name character varying(255) NOT NULL,
    customer_email character varying(255),
    customer_photo character varying(255),
    rating integer NOT NULL,
    comment text NOT NULL,
    service_type character varying(255),
    visit_date date,
    is_approved boolean DEFAULT false NOT NULL,
    is_featured boolean DEFAULT false NOT NULL,
    approved_at timestamp(0) without time zone,
    approved_by bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.testimonials OWNER TO postgres;

--
-- Name: testimonials_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.testimonials_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.testimonials_id_seq OWNER TO postgres;

--
-- Name: testimonials_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.testimonials_id_seq OWNED BY public.testimonials.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    role character varying(255) DEFAULT 'customer'::character varying NOT NULL,
    phone character varying(255),
    avatar character varying(255),
    is_active boolean DEFAULT true NOT NULL,
    email_verified_at timestamp(0) without time zone,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT users_role_check CHECK (((role)::text = ANY ((ARRAY['admin'::character varying, 'staff'::character varying, 'customer'::character varying])::text[])))
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: event_reservations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations ALTER COLUMN id SET DEFAULT nextval('public.event_reservations_id_seq'::regclass);


--
-- Name: events id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events ALTER COLUMN id SET DEFAULT nextval('public.events_id_seq'::regclass);


--
-- Name: galleries id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries ALTER COLUMN id SET DEFAULT nextval('public.galleries_id_seq'::regclass);


--
-- Name: menus id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus ALTER COLUMN id SET DEFAULT nextval('public.menus_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: payments id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments ALTER COLUMN id SET DEFAULT nextval('public.payments_id_seq'::regclass);


--
-- Name: pool_tickets id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pool_tickets ALTER COLUMN id SET DEFAULT nextval('public.pool_tickets_id_seq'::regclass);


--
-- Name: promo_menu id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu ALTER COLUMN id SET DEFAULT nextval('public.promo_menu_id_seq'::regclass);


--
-- Name: promos id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promos ALTER COLUMN id SET DEFAULT nextval('public.promos_id_seq'::regclass);


--
-- Name: table_reservations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_reservations ALTER COLUMN id SET DEFAULT nextval('public.table_reservations_id_seq'::regclass);


--
-- Name: testimonials id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials ALTER COLUMN id SET DEFAULT nextval('public.testimonials_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: event_reservations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.event_reservations (id, booking_code, event_id, customer_name, customer_email, customer_phone, number_of_tickets, total_amount, payment_status, status, user_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: events; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.events (id, title, slug, description, banner_image, start_date, end_date, location, max_participants, ticket_price, event_schedule, contact_info, is_featured, is_active, promo_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: galleries; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.galleries (id, title, type, file_path, menu_id, event_id, promo_id, testimonial_id, category, description, is_featured, sort_order, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: menus; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.menus (id, name, category, description, price, image, is_available, is_recommended, sort_order, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	2026_03_11_062811_create_menus_table	1
3	2026_03_11_062955_create_galleries_table	1
4	2026_03_11_063017_create_promos_table	1
5	2026_03_11_063037_create_events_table	1
6	2026_03_11_063059_create_testimonials_table	1
7	2026_03_11_063124_create_table_reservations_table	1
8	2026_03_11_063608_create_pool_tickets_table	1
9	2026_03_11_063625_create_promo_menu_table	1
10	2026_03_11_063642_create_event_reservations_table	1
11	2026_03_11_064139_create_payments_table	1
12	2026_03_11_073040_update_galleries_table_with_foreign_keys	1
\.


--
-- Data for Name: payments; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.payments (id, payment_code, payable_type, payable_id, amount, payment_type, payment_method, bank_name, account_number, account_name, payment_proof, payment_status, notes, verified_at, verified_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: pool_tickets; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.pool_tickets (id, ticket_code, customer_name, customer_email, customer_phone, visit_date, visit_time, number_of_tickets, ticket_type, price_per_ticket, total_amount, payment_status, payment_method, payment_proof, status, used_at, user_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: promo_menu; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.promo_menu (id, promo_id, menu_id, special_price, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: promos; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.promos (id, title, slug, description, banner_image, discount_type, discount_value, promo_code, promo_type, min_purchase, max_discount, start_date, end_date, applicable_for, max_usage, used_count, is_active, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: table_reservations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.table_reservations (id, booking_code, customer_name, customer_email, customer_phone, reservation_date, reservation_time, number_of_guests, table_numbers, special_requests, status, down_payment, payment_status, payment_proof, cancellation_reason, confirmed_at, cancelled_at, user_id, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: testimonials; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.testimonials (id, customer_name, customer_email, customer_photo, rating, comment, service_type, visit_date, is_approved, is_featured, approved_at, approved_by, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, password, role, phone, avatar, is_active, email_verified_at, remember_token, created_at, updated_at) FROM stdin;
\.


--
-- Name: event_reservations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.event_reservations_id_seq', 1, false);


--
-- Name: events_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.events_id_seq', 1, false);


--
-- Name: galleries_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.galleries_id_seq', 1, false);


--
-- Name: menus_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.menus_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 12, true);


--
-- Name: payments_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.payments_id_seq', 1, false);


--
-- Name: pool_tickets_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.pool_tickets_id_seq', 1, false);


--
-- Name: promo_menu_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.promo_menu_id_seq', 1, false);


--
-- Name: promos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.promos_id_seq', 1, false);


--
-- Name: table_reservations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.table_reservations_id_seq', 1, false);


--
-- Name: testimonials_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.testimonials_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: event_reservations event_reservations_booking_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations
    ADD CONSTRAINT event_reservations_booking_code_unique UNIQUE (booking_code);


--
-- Name: event_reservations event_reservations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations
    ADD CONSTRAINT event_reservations_pkey PRIMARY KEY (id);


--
-- Name: events events_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_pkey PRIMARY KEY (id);


--
-- Name: events events_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_slug_unique UNIQUE (slug);


--
-- Name: galleries galleries_event_id_sort_order_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_event_id_sort_order_unique UNIQUE (event_id, sort_order);


--
-- Name: galleries galleries_menu_id_sort_order_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_menu_id_sort_order_unique UNIQUE (menu_id, sort_order);


--
-- Name: galleries galleries_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_pkey PRIMARY KEY (id);


--
-- Name: galleries galleries_promo_id_sort_order_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_promo_id_sort_order_unique UNIQUE (promo_id, sort_order);


--
-- Name: galleries galleries_testimonial_id_sort_order_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_testimonial_id_sort_order_unique UNIQUE (testimonial_id, sort_order);


--
-- Name: menus menus_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.menus
    ADD CONSTRAINT menus_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: payments payments_payment_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_payment_code_unique UNIQUE (payment_code);


--
-- Name: payments payments_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_pkey PRIMARY KEY (id);


--
-- Name: pool_tickets pool_tickets_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pool_tickets
    ADD CONSTRAINT pool_tickets_pkey PRIMARY KEY (id);


--
-- Name: pool_tickets pool_tickets_ticket_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pool_tickets
    ADD CONSTRAINT pool_tickets_ticket_code_unique UNIQUE (ticket_code);


--
-- Name: promo_menu promo_menu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu
    ADD CONSTRAINT promo_menu_pkey PRIMARY KEY (id);


--
-- Name: promo_menu promo_menu_promo_id_menu_id_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu
    ADD CONSTRAINT promo_menu_promo_id_menu_id_unique UNIQUE (promo_id, menu_id);


--
-- Name: promos promos_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promos
    ADD CONSTRAINT promos_pkey PRIMARY KEY (id);


--
-- Name: promos promos_promo_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promos
    ADD CONSTRAINT promos_promo_code_unique UNIQUE (promo_code);


--
-- Name: promos promos_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promos
    ADD CONSTRAINT promos_slug_unique UNIQUE (slug);


--
-- Name: table_reservations table_reservations_booking_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_reservations
    ADD CONSTRAINT table_reservations_booking_code_unique UNIQUE (booking_code);


--
-- Name: table_reservations table_reservations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_reservations
    ADD CONSTRAINT table_reservations_pkey PRIMARY KEY (id);


--
-- Name: testimonials testimonials_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials
    ADD CONSTRAINT testimonials_pkey PRIMARY KEY (id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: event_reservations_booking_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_booking_code_index ON public.event_reservations USING btree (booking_code);


--
-- Name: event_reservations_event_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_event_id_index ON public.event_reservations USING btree (event_id);


--
-- Name: event_reservations_payment_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_payment_status_index ON public.event_reservations USING btree (payment_status);


--
-- Name: event_reservations_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_status_index ON public.event_reservations USING btree (status);


--
-- Name: event_reservations_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX event_reservations_user_id_index ON public.event_reservations USING btree (user_id);


--
-- Name: events_end_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_end_date_index ON public.events USING btree (end_date);


--
-- Name: events_is_active_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_is_active_index ON public.events USING btree (is_active);


--
-- Name: events_promo_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_promo_id_index ON public.events USING btree (promo_id);


--
-- Name: events_slug_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_slug_index ON public.events USING btree (slug);


--
-- Name: events_start_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX events_start_date_index ON public.events USING btree (start_date);


--
-- Name: galleries_category_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_category_index ON public.galleries USING btree (category);


--
-- Name: galleries_event_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_event_id_index ON public.galleries USING btree (event_id);


--
-- Name: galleries_is_featured_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_is_featured_index ON public.galleries USING btree (is_featured);


--
-- Name: galleries_menu_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_menu_id_index ON public.galleries USING btree (menu_id);


--
-- Name: galleries_promo_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_promo_id_index ON public.galleries USING btree (promo_id);


--
-- Name: galleries_testimonial_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX galleries_testimonial_id_index ON public.galleries USING btree (testimonial_id);


--
-- Name: menus_category_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX menus_category_index ON public.menus USING btree (category);


--
-- Name: menus_is_available_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX menus_is_available_index ON public.menus USING btree (is_available);


--
-- Name: menus_is_recommended_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX menus_is_recommended_index ON public.menus USING btree (is_recommended);


--
-- Name: payments_payable_type_payable_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_payable_type_payable_id_index ON public.payments USING btree (payable_type, payable_id);


--
-- Name: payments_payment_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_payment_code_index ON public.payments USING btree (payment_code);


--
-- Name: payments_payment_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_payment_status_index ON public.payments USING btree (payment_status);


--
-- Name: payments_verified_by_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX payments_verified_by_index ON public.payments USING btree (verified_by);


--
-- Name: pool_tickets_payment_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_payment_status_index ON public.pool_tickets USING btree (payment_status);


--
-- Name: pool_tickets_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_status_index ON public.pool_tickets USING btree (status);


--
-- Name: pool_tickets_ticket_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_ticket_code_index ON public.pool_tickets USING btree (ticket_code);


--
-- Name: pool_tickets_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_user_id_index ON public.pool_tickets USING btree (user_id);


--
-- Name: pool_tickets_visit_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX pool_tickets_visit_date_index ON public.pool_tickets USING btree (visit_date);


--
-- Name: promo_menu_menu_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promo_menu_menu_id_index ON public.promo_menu USING btree (menu_id);


--
-- Name: promo_menu_promo_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promo_menu_promo_id_index ON public.promo_menu USING btree (promo_id);


--
-- Name: promos_end_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_end_date_index ON public.promos USING btree (end_date);


--
-- Name: promos_is_active_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_is_active_index ON public.promos USING btree (is_active);


--
-- Name: promos_promo_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_promo_code_index ON public.promos USING btree (promo_code);


--
-- Name: promos_promo_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_promo_type_index ON public.promos USING btree (promo_type);


--
-- Name: promos_slug_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_slug_index ON public.promos USING btree (slug);


--
-- Name: promos_start_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX promos_start_date_index ON public.promos USING btree (start_date);


--
-- Name: table_reservations_booking_code_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_booking_code_index ON public.table_reservations USING btree (booking_code);


--
-- Name: table_reservations_payment_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_payment_status_index ON public.table_reservations USING btree (payment_status);


--
-- Name: table_reservations_reservation_date_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_reservation_date_index ON public.table_reservations USING btree (reservation_date);


--
-- Name: table_reservations_status_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_status_index ON public.table_reservations USING btree (status);


--
-- Name: table_reservations_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX table_reservations_user_id_index ON public.table_reservations USING btree (user_id);


--
-- Name: testimonials_is_approved_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX testimonials_is_approved_index ON public.testimonials USING btree (is_approved);


--
-- Name: testimonials_is_featured_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX testimonials_is_featured_index ON public.testimonials USING btree (is_featured);


--
-- Name: testimonials_rating_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX testimonials_rating_index ON public.testimonials USING btree (rating);


--
-- Name: testimonials_service_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX testimonials_service_type_index ON public.testimonials USING btree (service_type);


--
-- Name: users_email_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX users_email_index ON public.users USING btree (email);


--
-- Name: users_role_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX users_role_index ON public.users USING btree (role);


--
-- Name: event_reservations event_reservations_event_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations
    ADD CONSTRAINT event_reservations_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;


--
-- Name: event_reservations event_reservations_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.event_reservations
    ADD CONSTRAINT event_reservations_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: events events_promo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.events
    ADD CONSTRAINT events_promo_id_foreign FOREIGN KEY (promo_id) REFERENCES public.promos(id) ON DELETE SET NULL;


--
-- Name: galleries galleries_event_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_event_id_foreign FOREIGN KEY (event_id) REFERENCES public.events(id) ON DELETE CASCADE;


--
-- Name: galleries galleries_menu_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_menu_id_foreign FOREIGN KEY (menu_id) REFERENCES public.menus(id) ON DELETE CASCADE;


--
-- Name: galleries galleries_promo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_promo_id_foreign FOREIGN KEY (promo_id) REFERENCES public.promos(id) ON DELETE CASCADE;


--
-- Name: galleries galleries_testimonial_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.galleries
    ADD CONSTRAINT galleries_testimonial_id_foreign FOREIGN KEY (testimonial_id) REFERENCES public.testimonials(id) ON DELETE CASCADE;


--
-- Name: payments payments_verified_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.payments
    ADD CONSTRAINT payments_verified_by_foreign FOREIGN KEY (verified_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: pool_tickets pool_tickets_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.pool_tickets
    ADD CONSTRAINT pool_tickets_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: promo_menu promo_menu_menu_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu
    ADD CONSTRAINT promo_menu_menu_id_foreign FOREIGN KEY (menu_id) REFERENCES public.menus(id) ON DELETE CASCADE;


--
-- Name: promo_menu promo_menu_promo_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.promo_menu
    ADD CONSTRAINT promo_menu_promo_id_foreign FOREIGN KEY (promo_id) REFERENCES public.promos(id) ON DELETE CASCADE;


--
-- Name: table_reservations table_reservations_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.table_reservations
    ADD CONSTRAINT table_reservations_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: testimonials testimonials_approved_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.testimonials
    ADD CONSTRAINT testimonials_approved_by_foreign FOREIGN KEY (approved_by) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- Name: TABLE event_reservations; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.event_reservations TO admin_role;


--
-- Name: SEQUENCE event_reservations_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.event_reservations_id_seq TO admin_role;


--
-- Name: TABLE events; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.events TO admin_role;


--
-- Name: SEQUENCE events_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.events_id_seq TO admin_role;


--
-- Name: TABLE galleries; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.galleries TO admin_role;


--
-- Name: SEQUENCE galleries_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.galleries_id_seq TO admin_role;


--
-- Name: TABLE menus; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.menus TO admin_role;


--
-- Name: SEQUENCE menus_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.menus_id_seq TO admin_role;


--
-- Name: TABLE migrations; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.migrations TO admin_role;


--
-- Name: SEQUENCE migrations_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.migrations_id_seq TO admin_role;


--
-- Name: TABLE payments; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.payments TO admin_role;


--
-- Name: SEQUENCE payments_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.payments_id_seq TO admin_role;


--
-- Name: TABLE pool_tickets; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.pool_tickets TO admin_role;


--
-- Name: SEQUENCE pool_tickets_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.pool_tickets_id_seq TO admin_role;


--
-- Name: TABLE promo_menu; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.promo_menu TO admin_role;


--
-- Name: SEQUENCE promo_menu_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.promo_menu_id_seq TO admin_role;


--
-- Name: TABLE promos; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.promos TO admin_role;


--
-- Name: SEQUENCE promos_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.promos_id_seq TO admin_role;


--
-- Name: TABLE table_reservations; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.table_reservations TO admin_role;


--
-- Name: SEQUENCE table_reservations_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.table_reservations_id_seq TO admin_role;


--
-- Name: TABLE testimonials; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.testimonials TO admin_role;


--
-- Name: SEQUENCE testimonials_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.testimonials_id_seq TO admin_role;


--
-- Name: TABLE users; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON TABLE public.users TO admin_role;


--
-- Name: SEQUENCE users_id_seq; Type: ACL; Schema: public; Owner: postgres
--

GRANT ALL ON SEQUENCE public.users_id_seq TO admin_role;


--
-- PostgreSQL database dump complete
--

\unrestrict b3OpJBYfpXn6WbdTHYwx5i5vzyEKPYYWG1rltJOLcJXAcEe5gOBukaAbtNDtjAv

