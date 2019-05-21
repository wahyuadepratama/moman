PGDMP     3    2                w            moman    11.2    11.2 �    �           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                       false            �           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                       false            �           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                       false            �           1262    18907    moman    DATABASE     �   CREATE DATABASE moman WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'Indonesian_Indonesia.1252' LC_CTYPE = 'Indonesian_Indonesia.1252';
    DROP DATABASE moman;
             postgres    false                        3079    22102    postgis 	   EXTENSION     ;   CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;
    DROP EXTENSION postgis;
                  false            �           0    0    EXTENSION postgis    COMMENT     g   COMMENT ON EXTENSION postgis IS 'PostGIS geometry, geography, and raster spatial types and functions';
                       false    2            �            1259    24302    sequence_account    SEQUENCE     y   CREATE SEQUENCE public.sequence_account
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.sequence_account;
       public       postgres    false            �            1259    24453    account    TABLE       CREATE TABLE public.account (
    id character varying(10) DEFAULT nextval('public.sequence_account'::regclass) NOT NULL,
    stewardship_id character varying(10),
    bank character varying(20),
    owner character varying(40),
    account_number character varying(50)
);
    DROP TABLE public.account;
       public         postgres    false    229            �            1259    24188    admin    TABLE     p   CREATE TABLE public.admin (
    username character varying(25) NOT NULL,
    password character varying(190)
);
    DROP TABLE public.admin;
       public         postgres    false            �            1259    24579    sequence_builder    SEQUENCE     y   CREATE SEQUENCE public.sequence_builder
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.sequence_builder;
       public       postgres    false            �            1259    24518    builder    TABLE     �   CREATE TABLE public.builder (
    id character varying(7) DEFAULT nextval('public.sequence_builder'::regclass) NOT NULL,
    name character varying(25),
    address character varying(60),
    phone character varying(15)
);
    DROP TABLE public.builder;
       public         postgres    false    247            �            1259    24566    sequence_cash_in    SEQUENCE     y   CREATE SEQUENCE public.sequence_cash_in
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.sequence_cash_in;
       public       postgres    false            �            1259    24528    cash_in    TABLE     (  CREATE TABLE public.cash_in (
    id character varying(15) DEFAULT nextval('public.sequence_cash_in'::regclass) NOT NULL,
    worship_place_id character varying(7),
    project_id character varying(10),
    jamaah_id character varying(7),
    tpa_id character varying(7),
    orphanage_id character varying(7),
    poor_id character varying(7),
    fund bigint,
    status_in character varying(15),
    status_out character varying(15),
    datetime timestamp(6) without time zone,
    description text,
    confirmation boolean,
    public boolean
);
    DROP TABLE public.cash_in;
       public         postgres    false    241            �            1259    24158    detail_condition    TABLE     �   CREATE TABLE public.detail_condition (
    worship_place_id character varying(7) NOT NULL,
    facility_id character(2) NOT NULL,
    facility_condition_id character(1) NOT NULL,
    total integer,
    updated_at timestamp without time zone
);
 $   DROP TABLE public.detail_condition;
       public         postgres    false            �            1259    25101    detail_qurban    TABLE     �  CREATE TABLE public.detail_qurban (
    jamaah_id character varying(7) NOT NULL,
    animal_type character varying(25) NOT NULL,
    year character(4) NOT NULL,
    worship_place_id character varying(7) NOT NULL,
    datetime timestamp without time zone,
    fund bigint,
    payment_method character varying(10),
    description text,
    confirmation boolean,
    grup character varying(3) NOT NULL
);
 !   DROP TABLE public.detail_qurban;
       public         postgres    false            �            1259    24086    district    TABLE     y   CREATE TABLE public.district (
    id character(2) NOT NULL,
    name character varying(25),
    geom public.geometry
);
    DROP TABLE public.district;
       public         postgres    false    2    2    2    2    2    2    2    2            �            1259    24597    sequence_event    SEQUENCE     w   CREATE SEQUENCE public.sequence_event
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.sequence_event;
       public       postgres    false            �            1259    24117    event    TABLE     �   CREATE TABLE public.event (
    id character varying(10) DEFAULT nextval('public.sequence_event'::regclass) NOT NULL,
    name character varying(25) NOT NULL,
    worship_place_id character varying(7),
    description text
);
    DROP TABLE public.event;
       public         postgres    false    249            �            1259    24253    sequence_facility    SEQUENCE     z   CREATE SEQUENCE public.sequence_facility
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 (   DROP SEQUENCE public.sequence_facility;
       public       postgres    false            �            1259    24148    facility    TABLE     �   CREATE TABLE public.facility (
    id character(2) DEFAULT nextval('public.sequence_facility'::regclass) NOT NULL,
    name character varying(25)
);
    DROP TABLE public.facility;
       public         postgres    false    224            �            1259    24153    facility_condition    TABLE     n   CREATE TABLE public.facility_condition (
    id character(1) NOT NULL,
    condition character varying(12)
);
 &   DROP TABLE public.facility_condition;
       public         postgres    false            �            1259    24185    sequence_gallery    SEQUENCE     y   CREATE SEQUENCE public.sequence_gallery
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.sequence_gallery;
       public       postgres    false            �            1259    24098    gallery    TABLE     �   CREATE TABLE public.gallery (
    id character varying(7) DEFAULT nextval('public.sequence_gallery'::regclass) NOT NULL,
    image character varying(100),
    worship_place_id character varying(7)
);
    DROP TABLE public.gallery;
       public         postgres    false    222            �            1259    24286    sequence_jamaah    SEQUENCE     x   CREATE SEQUENCE public.sequence_jamaah
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 &   DROP SEQUENCE public.sequence_jamaah;
       public       postgres    false            �            1259    24281    jamaah    TABLE     �  CREATE TABLE public.jamaah (
    worship_place_id character varying(7),
    id character varying(10) DEFAULT nextval('public.sequence_jamaah'::regclass) NOT NULL,
    type character varying(10),
    username character varying(25),
    password character varying(100),
    avatar character varying(100) DEFAULT 'user.png'::bpchar,
    address character varying(60),
    phone character varying(15),
    updated_at timestamp with time zone
);
    DROP TABLE public.jamaah;
       public         postgres    false    226            �            1259    25069    mosque_qurban    TABLE     �   CREATE TABLE public.mosque_qurban (
    worship_place_id character varying(7) NOT NULL,
    year character(4) NOT NULL,
    animal_price bigint,
    animal_type character varying(25) NOT NULL,
    max_person integer
);
 !   DROP TABLE public.mosque_qurban;
       public         postgres    false            �            1259    24575    sequence_orphanage    SEQUENCE     {   CREATE SEQUENCE public.sequence_orphanage
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 )   DROP SEQUENCE public.sequence_orphanage;
       public       postgres    false            �            1259    24505 	   orphanage    TABLE     �   CREATE TABLE public.orphanage (
    id character varying(7) DEFAULT nextval('public.sequence_orphanage'::regclass) NOT NULL,
    name character varying(25),
    geom public.geometry,
    address character varying(60),
    phone character varying(15)
);
    DROP TABLE public.orphanage;
       public         postgres    false    245    2    2    2    2    2    2    2    2            �            1259    25128    participant    TABLE     �   CREATE TABLE public.participant (
    grup character varying(3) NOT NULL,
    name character varying(25) NOT NULL,
    year character(4) NOT NULL,
    worship_place_id character varying(7) NOT NULL
);
    DROP TABLE public.participant;
       public         postgres    false            �            1259    24577    sequence_poor    SEQUENCE     v   CREATE SEQUENCE public.sequence_poor
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 $   DROP SEQUENCE public.sequence_poor;
       public       postgres    false            �            1259    24513    poor    TABLE     �   CREATE TABLE public.poor (
    id character varying(7) DEFAULT nextval('public.sequence_poor'::regclass) NOT NULL,
    name character varying(25),
    address character varying(60),
    phone character varying(15)
);
    DROP TABLE public.poor;
       public         postgres    false    246            �            1259    24464    sequence_project    SEQUENCE     y   CREATE SEQUENCE public.sequence_project
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.sequence_project;
       public       postgres    false            �            1259    24127    project    TABLE       CREATE TABLE public.project (
    id character varying(10) DEFAULT nextval('public.sequence_project'::regclass) NOT NULL,
    name character varying(25),
    description text,
    fund bigint,
    worship_place_id character varying(7),
    progress text
);
    DROP TABLE public.project;
       public         postgres    false    232            �            1259    24466    sequence_project_gallery    SEQUENCE     �   CREATE SEQUENCE public.sequence_project_gallery
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 /   DROP SEQUENCE public.sequence_project_gallery;
       public       postgres    false            �            1259    24138    project_gallery    TABLE     �   CREATE TABLE public.project_gallery (
    id character varying(10) DEFAULT nextval('public.sequence_project_gallery'::regclass) NOT NULL,
    image character varying(100),
    project_id character varying(10)
);
 #   DROP TABLE public.project_gallery;
       public         postgres    false    233            �            1259    24581    sequence_store    SEQUENCE     w   CREATE SEQUENCE public.sequence_store
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.sequence_store;
       public       postgres    false            �            1259    24573    sequence_tpa    SEQUENCE     u   CREATE SEQUENCE public.sequence_tpa
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 #   DROP SEQUENCE public.sequence_tpa;
       public       postgres    false            �            1259    24298    sequence_type_of_work    SEQUENCE     ~   CREATE SEQUENCE public.sequence_type_of_work
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.sequence_type_of_work;
       public       postgres    false            �            1259    24569    sequence_ustad    SEQUENCE     w   CREATE SEQUENCE public.sequence_ustad
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 %   DROP SEQUENCE public.sequence_ustad;
       public       postgres    false            �            1259    24571    sequence_ustad_payment    SEQUENCE        CREATE SEQUENCE public.sequence_ustad_payment
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.sequence_ustad_payment;
       public       postgres    false            �            1259    24182    sequence_worship_place    SEQUENCE        CREATE SEQUENCE public.sequence_worship_place
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 -   DROP SEQUENCE public.sequence_worship_place;
       public       postgres    false            �            1259    24304    stewardship    TABLE     �   CREATE TABLE public.stewardship (
    jamaah_id character varying(10) NOT NULL,
    type_of_work_id character(2),
    identity_number character varying(16),
    whatsapp character varying(15)
);
    DROP TABLE public.stewardship;
       public         postgres    false            �            1259    24602    store    TABLE     �   CREATE TABLE public.store (
    id character varying(7) DEFAULT nextval('public.sequence_store'::regclass) NOT NULL,
    name character varying(25),
    address character varying(60),
    phone character varying(15)
);
    DROP TABLE public.store;
       public         postgres    false    248            �            1259    24500    tpa    TABLE     �   CREATE TABLE public.tpa (
    id character varying(7) DEFAULT nextval('public.sequence_tpa'::regclass) NOT NULL,
    name character varying(25),
    address character varying(60)
);
    DROP TABLE public.tpa;
       public         postgres    false    244            �            1259    24293    type_of_work    TABLE     �   CREATE TABLE public.type_of_work (
    id character(2) DEFAULT nextval('public.sequence_type_of_work'::regclass) NOT NULL,
    name character varying(20),
    salary integer
);
     DROP TABLE public.type_of_work;
       public         postgres    false    228            �            1259    24480    ustad    TABLE     �   CREATE TABLE public.ustad (
    id character varying(7) DEFAULT nextval('public.sequence_ustad'::regclass) NOT NULL,
    name character varying(25),
    address character varying(60),
    phone character varying(15)
);
    DROP TABLE public.ustad;
       public         postgres    false    242            �            1259    24485    ustad_payment    TABLE     �   CREATE TABLE public.ustad_payment (
    id integer DEFAULT nextval('public.sequence_ustad_payment'::regclass) NOT NULL,
    ustad_id character varying(7),
    event_id character varying(10),
    schedule date
);
 !   DROP TABLE public.ustad_payment;
       public         postgres    false    243            �            1259    24095    worship_place    TABLE     k  CREATE TABLE public.worship_place (
    id character varying(7) DEFAULT nextval('public.sequence_worship_place'::regclass) NOT NULL,
    name character varying(40) NOT NULL,
    address character varying(60) NOT NULL,
    capacity integer,
    park_area_size integer,
    geom public.geometry,
    type character(1),
    updated_at timestamp without time zone
);
 !   DROP TABLE public.worship_place;
       public         postgres    false    221    2    2    2    2    2    2    2    2            �          0    24453    account 
   TABLE DATA               R   COPY public.account (id, stewardship_id, bank, owner, account_number) FROM stdin;
    public       postgres    false    231   ��       �          0    24188    admin 
   TABLE DATA               3   COPY public.admin (username, password) FROM stdin;
    public       postgres    false    223   $�       �          0    24518    builder 
   TABLE DATA               ;   COPY public.builder (id, name, address, phone) FROM stdin;
    public       postgres    false    239   h�       �          0    24528    cash_in 
   TABLE DATA               �   COPY public.cash_in (id, worship_place_id, project_id, jamaah_id, tpa_id, orphanage_id, poor_id, fund, status_in, status_out, datetime, description, confirmation, public) FROM stdin;
    public       postgres    false    240   �       �          0    24158    detail_condition 
   TABLE DATA               s   COPY public.detail_condition (worship_place_id, facility_id, facility_condition_id, total, updated_at) FROM stdin;
    public       postgres    false    220   ��       �          0    25101    detail_qurban 
   TABLE DATA               �   COPY public.detail_qurban (jamaah_id, animal_type, year, worship_place_id, datetime, fund, payment_method, description, confirmation, grup) FROM stdin;
    public       postgres    false    252   ��       �          0    24086    district 
   TABLE DATA               2   COPY public.district (id, name, geom) FROM stdin;
    public       postgres    false    212   إ       �          0    24117    event 
   TABLE DATA               H   COPY public.event (id, name, worship_place_id, description) FROM stdin;
    public       postgres    false    215   v�       �          0    24148    facility 
   TABLE DATA               ,   COPY public.facility (id, name) FROM stdin;
    public       postgres    false    218   ��       �          0    24153    facility_condition 
   TABLE DATA               ;   COPY public.facility_condition (id, condition) FROM stdin;
    public       postgres    false    219   ��       �          0    24098    gallery 
   TABLE DATA               >   COPY public.gallery (id, image, worship_place_id) FROM stdin;
    public       postgres    false    214   �       �          0    24281    jamaah 
   TABLE DATA               t   COPY public.jamaah (worship_place_id, id, type, username, password, avatar, address, phone, updated_at) FROM stdin;
    public       postgres    false    225   \�       �          0    25069    mosque_qurban 
   TABLE DATA               f   COPY public.mosque_qurban (worship_place_id, year, animal_price, animal_type, max_person) FROM stdin;
    public       postgres    false    251   \�       �          0    24505 	   orphanage 
   TABLE DATA               C   COPY public.orphanage (id, name, geom, address, phone) FROM stdin;
    public       postgres    false    237   ��       �          0    25128    participant 
   TABLE DATA               I   COPY public.participant (grup, name, year, worship_place_id) FROM stdin;
    public       postgres    false    253   ƴ       �          0    24513    poor 
   TABLE DATA               8   COPY public.poor (id, name, address, phone) FROM stdin;
    public       postgres    false    238   Q�       �          0    24127    project 
   TABLE DATA               Z   COPY public.project (id, name, description, fund, worship_place_id, progress) FROM stdin;
    public       postgres    false    216   ص       �          0    24138    project_gallery 
   TABLE DATA               @   COPY public.project_gallery (id, image, project_id) FROM stdin;
    public       postgres    false    217   շ       �          0    22411    spatial_ref_sys 
   TABLE DATA               X   COPY public.spatial_ref_sys (srid, auth_name, auth_srid, srtext, proj4text) FROM stdin;
    public       postgres    false    198   ��       �          0    24304    stewardship 
   TABLE DATA               \   COPY public.stewardship (jamaah_id, type_of_work_id, identity_number, whatsapp) FROM stdin;
    public       postgres    false    230   ��       �          0    24602    store 
   TABLE DATA               9   COPY public.store (id, name, address, phone) FROM stdin;
    public       postgres    false    250   �       �          0    24500    tpa 
   TABLE DATA               0   COPY public.tpa (id, name, address) FROM stdin;
    public       postgres    false    236   /�       �          0    24293    type_of_work 
   TABLE DATA               8   COPY public.type_of_work (id, name, salary) FROM stdin;
    public       postgres    false    227   ��       �          0    24480    ustad 
   TABLE DATA               9   COPY public.ustad (id, name, address, phone) FROM stdin;
    public       postgres    false    234   ͹       �          0    24485    ustad_payment 
   TABLE DATA               I   COPY public.ustad_payment (id, ustad_id, event_id, schedule) FROM stdin;
    public       postgres    false    235   �       �          0    24095    worship_place 
   TABLE DATA               l   COPY public.worship_place (id, name, address, capacity, park_area_size, geom, type, updated_at) FROM stdin;
    public       postgres    false    213   L�       �           0    0    sequence_account    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.sequence_account', 13, true);
            public       postgres    false    229            �           0    0    sequence_builder    SEQUENCE SET     >   SELECT pg_catalog.setval('public.sequence_builder', 2, true);
            public       postgres    false    247            �           0    0    sequence_cash_in    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.sequence_cash_in', 22, true);
            public       postgres    false    241            �           0    0    sequence_event    SEQUENCE SET     <   SELECT pg_catalog.setval('public.sequence_event', 3, true);
            public       postgres    false    249            �           0    0    sequence_facility    SEQUENCE SET     @   SELECT pg_catalog.setval('public.sequence_facility', 33, true);
            public       postgres    false    224            �           0    0    sequence_gallery    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.sequence_gallery', 31, true);
            public       postgres    false    222            �           0    0    sequence_jamaah    SEQUENCE SET     >   SELECT pg_catalog.setval('public.sequence_jamaah', 13, true);
            public       postgres    false    226            �           0    0    sequence_orphanage    SEQUENCE SET     A   SELECT pg_catalog.setval('public.sequence_orphanage', 1, false);
            public       postgres    false    245            �           0    0    sequence_poor    SEQUENCE SET     ;   SELECT pg_catalog.setval('public.sequence_poor', 2, true);
            public       postgres    false    246            �           0    0    sequence_project    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.sequence_project', 38, true);
            public       postgres    false    232            �           0    0    sequence_project_gallery    SEQUENCE SET     G   SELECT pg_catalog.setval('public.sequence_project_gallery', 24, true);
            public       postgres    false    233            �           0    0    sequence_store    SEQUENCE SET     <   SELECT pg_catalog.setval('public.sequence_store', 8, true);
            public       postgres    false    248            �           0    0    sequence_tpa    SEQUENCE SET     :   SELECT pg_catalog.setval('public.sequence_tpa', 2, true);
            public       postgres    false    244            �           0    0    sequence_type_of_work    SEQUENCE SET     C   SELECT pg_catalog.setval('public.sequence_type_of_work', 2, true);
            public       postgres    false    228            �           0    0    sequence_ustad    SEQUENCE SET     <   SELECT pg_catalog.setval('public.sequence_ustad', 1, true);
            public       postgres    false    242            �           0    0    sequence_ustad_payment    SEQUENCE SET     D   SELECT pg_catalog.setval('public.sequence_ustad_payment', 3, true);
            public       postgres    false    243            �           0    0    sequence_worship_place    SEQUENCE SET     E   SELECT pg_catalog.setval('public.sequence_worship_place', 67, true);
            public       postgres    false    221            �           2606    24970    account account_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.account
    ADD CONSTRAINT account_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.account DROP CONSTRAINT account_pkey;
       public         postgres    false    231            �           2606    24783    admin admin_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.admin
    ADD CONSTRAINT admin_pkey PRIMARY KEY (username);
 :   ALTER TABLE ONLY public.admin DROP CONSTRAINT admin_pkey;
       public         postgres    false    223            �           2606    24942    builder builder_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.builder
    ADD CONSTRAINT builder_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.builder DROP CONSTRAINT builder_pkey;
       public         postgres    false    239            �           2606    25006    cash_in cash_in_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.cash_in
    ADD CONSTRAINT cash_in_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.cash_in DROP CONSTRAINT cash_in_pkey;
       public         postgres    false    240            �           2606    24876 &   detail_condition detail_condition_pkey 
   CONSTRAINT     �   ALTER TABLE ONLY public.detail_condition
    ADD CONSTRAINT detail_condition_pkey PRIMARY KEY (worship_place_id, facility_id, facility_condition_id);
 P   ALTER TABLE ONLY public.detail_condition DROP CONSTRAINT detail_condition_pkey;
       public         postgres    false    220    220    220            �           2606    25311     detail_qurban detail_qurban_pkey 
   CONSTRAINT     x   ALTER TABLE ONLY public.detail_qurban
    ADD CONSTRAINT detail_qurban_pkey PRIMARY KEY (year, worship_place_id, grup);
 J   ALTER TABLE ONLY public.detail_qurban DROP CONSTRAINT detail_qurban_pkey;
       public         postgres    false    252    252    252            �           2606    24627    district district_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.district
    ADD CONSTRAINT district_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.district DROP CONSTRAINT district_pkey;
       public         postgres    false    212            �           2606    24830    event event_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.event
    ADD CONSTRAINT event_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.event DROP CONSTRAINT event_pkey;
       public         postgres    false    215            �           2606    24858 *   facility_condition facility_condition_pkey 
   CONSTRAINT     h   ALTER TABLE ONLY public.facility_condition
    ADD CONSTRAINT facility_condition_pkey PRIMARY KEY (id);
 T   ALTER TABLE ONLY public.facility_condition DROP CONSTRAINT facility_condition_pkey;
       public         postgres    false    219            �           2606    24848    facility facility_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.facility
    ADD CONSTRAINT facility_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.facility DROP CONSTRAINT facility_pkey;
       public         postgres    false    218            �           2606    24621    gallery gallery_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.gallery
    ADD CONSTRAINT gallery_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.gallery DROP CONSTRAINT gallery_pkey;
       public         postgres    false    214            �           2606    24753    jamaah jamaah_pkey 
   CONSTRAINT     P   ALTER TABLE ONLY public.jamaah
    ADD CONSTRAINT jamaah_pkey PRIMARY KEY (id);
 <   ALTER TABLE ONLY public.jamaah DROP CONSTRAINT jamaah_pkey;
       public         postgres    false    225            �           2606    25260     mosque_qurban mosque_qurban_pkey 
   CONSTRAINT        ALTER TABLE ONLY public.mosque_qurban
    ADD CONSTRAINT mosque_qurban_pkey PRIMARY KEY (worship_place_id, year, animal_type);
 J   ALTER TABLE ONLY public.mosque_qurban DROP CONSTRAINT mosque_qurban_pkey;
       public         postgres    false    251    251    251            �           2606    24909    orphanage orphanage_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.orphanage
    ADD CONSTRAINT orphanage_pkey PRIMARY KEY (id);
 B   ALTER TABLE ONLY public.orphanage DROP CONSTRAINT orphanage_pkey;
       public         postgres    false    237            �           2606    25300    participant participant_pkey 
   CONSTRAINT     z   ALTER TABLE ONLY public.participant
    ADD CONSTRAINT participant_pkey PRIMARY KEY (grup, name, year, worship_place_id);
 F   ALTER TABLE ONLY public.participant DROP CONSTRAINT participant_pkey;
       public         postgres    false    253    253    253    253            �           2606    24931    poor poor_pkey 
   CONSTRAINT     L   ALTER TABLE ONLY public.poor
    ADD CONSTRAINT poor_pkey PRIMARY KEY (id);
 8   ALTER TABLE ONLY public.poor DROP CONSTRAINT poor_pkey;
       public         postgres    false    238            �           2606    24647 $   project_gallery project_gallery_pkey 
   CONSTRAINT     b   ALTER TABLE ONLY public.project_gallery
    ADD CONSTRAINT project_gallery_pkey PRIMARY KEY (id);
 N   ALTER TABLE ONLY public.project_gallery DROP CONSTRAINT project_gallery_pkey;
       public         postgres    false    217            �           2606    24671    project project_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.project
    ADD CONSTRAINT project_pkey PRIMARY KEY (id);
 >   ALTER TABLE ONLY public.project DROP CONSTRAINT project_pkey;
       public         postgres    false    216            �           2606    24816    stewardship stewardship_pkey 
   CONSTRAINT     a   ALTER TABLE ONLY public.stewardship
    ADD CONSTRAINT stewardship_pkey PRIMARY KEY (jamaah_id);
 F   ALTER TABLE ONLY public.stewardship DROP CONSTRAINT stewardship_pkey;
       public         postgres    false    230            �           2606    24949    store store_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public.store
    ADD CONSTRAINT store_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public.store DROP CONSTRAINT store_pkey;
       public         postgres    false    250            �           2606    24898    tpa tpa_pkey 
   CONSTRAINT     J   ALTER TABLE ONLY public.tpa
    ADD CONSTRAINT tpa_pkey PRIMARY KEY (id);
 6   ALTER TABLE ONLY public.tpa DROP CONSTRAINT tpa_pkey;
       public         postgres    false    236            �           2606    24798    type_of_work type_of_work_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.type_of_work
    ADD CONSTRAINT type_of_work_pkey PRIMARY KEY (id);
 H   ALTER TABLE ONLY public.type_of_work DROP CONSTRAINT type_of_work_pkey;
       public         postgres    false    227            �           2606    24489     ustad_payment ustad_payment_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.ustad_payment
    ADD CONSTRAINT ustad_payment_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.ustad_payment DROP CONSTRAINT ustad_payment_pkey;
       public         postgres    false    235            �           2606    24637     worship_place worship_place_pkey 
   CONSTRAINT     ^   ALTER TABLE ONLY public.worship_place
    ADD CONSTRAINT worship_place_pkey PRIMARY KEY (id);
 J   ALTER TABLE ONLY public.worship_place DROP CONSTRAINT worship_place_pkey;
       public         postgres    false    213                        2606    24979 #   account account_stewardship_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.account
    ADD CONSTRAINT account_stewardship_id_fkey FOREIGN KEY (stewardship_id) REFERENCES public.stewardship(jamaah_id) ON UPDATE CASCADE ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.account DROP CONSTRAINT account_stewardship_id_fkey;
       public       postgres    false    231    4319    230            �           2606    24999 <   detail_condition detail_condition_facility_condition_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detail_condition
    ADD CONSTRAINT detail_condition_facility_condition_id_fkey FOREIGN KEY (facility_condition_id) REFERENCES public.facility_condition(id) ON UPDATE CASCADE ON DELETE CASCADE;
 f   ALTER TABLE ONLY public.detail_condition DROP CONSTRAINT detail_condition_facility_condition_id_fkey;
       public       postgres    false    219    220    4309            �           2606    24994 2   detail_condition detail_condition_facility_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detail_condition
    ADD CONSTRAINT detail_condition_facility_id_fkey FOREIGN KEY (facility_id) REFERENCES public.facility(id) ON UPDATE CASCADE ON DELETE CASCADE;
 \   ALTER TABLE ONLY public.detail_condition DROP CONSTRAINT detail_condition_facility_id_fkey;
       public       postgres    false    4307    218    220            �           2606    24989 7   detail_condition detail_condition_worship_place_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detail_condition
    ADD CONSTRAINT detail_condition_worship_place_id_fkey FOREIGN KEY (worship_place_id) REFERENCES public.worship_place(id) ON UPDATE CASCADE ON DELETE CASCADE;
 a   ALTER TABLE ONLY public.detail_condition DROP CONSTRAINT detail_condition_worship_place_id_fkey;
       public       postgres    false    213    220    4297                       2606    25261 %   detail_qurban detail_qurban_year_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.detail_qurban
    ADD CONSTRAINT detail_qurban_year_fkey FOREIGN KEY (year, worship_place_id, animal_type) REFERENCES public.mosque_qurban(year, worship_place_id, animal_type) ON UPDATE CASCADE ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.detail_qurban DROP CONSTRAINT detail_qurban_year_fkey;
       public       postgres    false    251    252    252    4337    251    251    252            �           2606    24984 !   event event_worship_place_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.event
    ADD CONSTRAINT event_worship_place_id_fkey FOREIGN KEY (worship_place_id) REFERENCES public.worship_place(id) ON UPDATE CASCADE ON DELETE CASCADE;
 K   ALTER TABLE ONLY public.event DROP CONSTRAINT event_worship_place_id_fkey;
       public       postgres    false    215    213    4297            �           2606    24729 %   gallery gallery_worship_place_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.gallery
    ADD CONSTRAINT gallery_worship_place_id_fkey FOREIGN KEY (worship_place_id) REFERENCES public.worship_place(id) ON UPDATE CASCADE ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.gallery DROP CONSTRAINT gallery_worship_place_id_fkey;
       public       postgres    false    214    4297    213            �           2606    24762 #   jamaah jamaah_worship_place_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.jamaah
    ADD CONSTRAINT jamaah_worship_place_id_fkey FOREIGN KEY (worship_place_id) REFERENCES public.worship_place(id) ON UPDATE CASCADE ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.jamaah DROP CONSTRAINT jamaah_worship_place_id_fkey;
       public       postgres    false    225    213    4297                       2606    25235 1   mosque_qurban mosque_qurban_worship_place_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.mosque_qurban
    ADD CONSTRAINT mosque_qurban_worship_place_id_fkey FOREIGN KEY (worship_place_id) REFERENCES public.worship_place(id) ON UPDATE CASCADE ON DELETE CASCADE;
 [   ALTER TABLE ONLY public.mosque_qurban DROP CONSTRAINT mosque_qurban_worship_place_id_fkey;
       public       postgres    false    251    213    4297                       2606    25312 "   participant participant_group_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.participant
    ADD CONSTRAINT participant_group_fkey FOREIGN KEY (grup, year, worship_place_id) REFERENCES public.detail_qurban(grup, year, worship_place_id) ON UPDATE CASCADE ON DELETE CASCADE;
 L   ALTER TABLE ONLY public.participant DROP CONSTRAINT participant_group_fkey;
       public       postgres    false    4339    252    252    253    253    253    252            �           2606    24767 /   project_gallery project_gallery_project_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.project_gallery
    ADD CONSTRAINT project_gallery_project_id_fkey FOREIGN KEY (project_id) REFERENCES public.project(id) ON UPDATE CASCADE ON DELETE CASCADE;
 Y   ALTER TABLE ONLY public.project_gallery DROP CONSTRAINT project_gallery_project_id_fkey;
       public       postgres    false    217    216    4303            �           2606    24734 %   project project_worship_place_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.project
    ADD CONSTRAINT project_worship_place_id_fkey FOREIGN KEY (worship_place_id) REFERENCES public.worship_place(id) ON UPDATE CASCADE ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.project DROP CONSTRAINT project_worship_place_id_fkey;
       public       postgres    false    4297    216    213            �           2606    24958 &   stewardship stewardship_jamaah_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.stewardship
    ADD CONSTRAINT stewardship_jamaah_id_fkey FOREIGN KEY (jamaah_id) REFERENCES public.jamaah(id) ON UPDATE CASCADE ON DELETE CASCADE;
 P   ALTER TABLE ONLY public.stewardship DROP CONSTRAINT stewardship_jamaah_id_fkey;
       public       postgres    false    230    225    4315            �           2606    24963 ,   stewardship stewardship_type_of_work_id_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.stewardship
    ADD CONSTRAINT stewardship_type_of_work_id_fkey FOREIGN KEY (type_of_work_id) REFERENCES public.type_of_work(id) ON UPDATE CASCADE ON DELETE CASCADE;
 V   ALTER TABLE ONLY public.stewardship DROP CONSTRAINT stewardship_type_of_work_id_fkey;
       public       postgres    false    4317    227    230            �   n   x�3�4��M�K�,��LL)*-�M�SpKL���4464!K#CcK.S�R'?OLeF�@��F��\�F�`e���
�)�
E�%�����F�&@��F@�Ȑ+F��� �\ �      �   4   x�KL����42M15ML1�0NL410HL313I67K174N60OL����� wu      �   w   x�3�tL/�KW�H,(N���)M*�Vp*M�L�Q��/�WI�KO��QHL�8,�͍́��9�!�SbnR"H{jQ�����X�`����ԑ���X����Y�jdhb$���b���� |4$6      �   �  x���Ak�0���б=��Y�G����BB��^r��ڵ�]yQ�C�}���-q K�0HBo�y�@�W�V���;-4ӧ���i�~�s��yx��F����ML��C���ϏZν~�׷��^6 �~��)�oݐ^ԨƢ^��� L@��Ʈ�'�뻯R��j@�-(Wm�_�g��-��]Skp��`�$oՏ�;��c�������d��ɒ	$�ܽ<�4�3�Rd桙ǯ�y���`���U��h?�m����# �.ri�"M 	X9V7C�3:β�E�z9�,�F
N��%T���XMC��Ӏ��#��GN��֢q{=I.��M�!;N���� R�߈���A8���*�ˌQ�ne%�%Uu����,�-�*X���ԍt��"x_E�h�N      �     x�}�[��*��Q�څ^�<�;�q܍��NG��-�������?�Å�o������R�ҮZ�y1�|A���/�Mj ;�FT$P���6Կ �� �b�[�-��¨������?To֛��T���F~S�]&�U4������������K�?\n���˺�@vD�Z)�I����KP} ���_"BF���Z+m"9"���I��������7�*
�CM��2~`�(�i�����7i��/D_�@���f���R/:�?_�o�o�}ق�d�,��>:�����D�,�Ⱥʶ`#)Ve��H�ս���I�I�&�&{�6�Z��m#�&/���ܤWS�J�Ғ&2-́Қ2�aҒ�A�|I;T���7*�A-�v7R��e/T���e/ԋX����8P��-�K'����`�J-PZ�D"N(�i!S�Q�|3���.�VƇ�yMu�e��P+�%PV�F?��o��4P��Y�rX��\/�T��~	�>��|RZ�B5ѡ&�M����0Jw|!�@i�	B���̚�ֻ���'��[h4Á�e���zHDm7�U�T���-X��V�[�P����ܦ�y�tqa��m��&r�\��C�Z�A����mT�.�u�>Jɺ�wꁲ�-dD%�������6�ֱ��4s�#Ǔ��PE��!17�8���ܨ��@y����e+>ދ��qP��-��-P����
ڥz#S�z#-����V�a^�/��@i��1\�!�7�<��!�7r_�!�'����˿��W�@��!��=������e��C?nl�c(�@��� ��}�Ӄ��M��O��l�>��A8->P�Oo$ģ7}���$V�l惤�)	����_�#�F7�*��}Z��aI'��h����Ӄ=<P��5A��4쁐O�/�1�JkZ��(}�B]�K����X!�(}�B��eif�{�-hh��K��A�1aZ����a����񕗥I��4�Z�.,M��q��4�䆣iiԽ�an���/e#�#K��A�؂4ƀ�]�n�5P���0�P�tu�DI�tu���������H<)=��ha�fP7M� (�i����fԃp���Ҍ�[��q]�(�̅F��ִP�c��σp~���H���1���O�o�8��I�fn���e�od����� �3�46�;�+�!&5��.n�J^'J���';��FZQv��FWy�!}��f��h���Y�1�|RZ�B����j�u����D���n#��z���0Z}��C�,�Cg�IiMq�實7D��0��X]=d�F�/�@��6�q��!�Dn���+Ƌ���T�)�� ۨ�2���PG_	��KA���!�FWB���Y�q����!~�]��N��k�n�J߶�����4X�$y�|4VB �YpG����� �O��p�F-P�����5P���j!�s��+aT�frEsJ�ʁ����qM�>oT�����bm�Ii�a�Ɠ���r	����C�l��&-i�[[�����[�-m`atč����z�m>�f      �     x�}�MK1@�ɯ�?И�l>oփ"��/#��Km��H��i�A��\&��xo���� �Q�?͕�+B@L�%���	�V�#��y�tE�؈(�5���xE1k. �P_CP�
ʑ��K�A��K65V��U	��/��|����-��ԕ~��r�a�y���o�=�p�v�\x��.r�<@�v�֠AjN��$B�{���<��k�NU�䈄YV���b�#����ŤM�F�����D�� L�S��f�G���>���(��w%��?̑F      �   �
  x��X��]�\'O�'((R��DJ��vc�E7EV}t�st���h��G��O��/������O�ǿ~���o�P�B�����'�=���ĕ��T�eZ��(�����X�\ܙr~�G�(M?�6l�D��OQ��,�k��5J�kǃȴ�f���C���2�X����qjT����;�[m]����VӚ��x��"+.{���Z�4w����5U�Ϝ������le0��s~O�&��yG�i�w�<b����$yz�%k�u��v����X[R>qn�ؠ��_$f��";.}W�a�|-���l�N+��%�񜵝��k՛W) Ĕ�;ާ�]��oaq^������M�㜟�wi�[�qC����g}M37���8N��E��٘; d�cq2-��>S���{~�$�9�z��V0����O|.��>P�8���f�=��ehJ����}�g~�K�9���ݩ�2���?ĳ�3\��O5�� �q��2���)�#Q��Y���f��=�>�_Q����?����p�x�'� �z��oY�I)�]�JCk�����h�����q_���UW>���>��h[�eX_�|���ds~�{����?P�@���~��k�g�H�"�����v+�'��(o\r�荍lǓC1�����(�UC��t����h��|,�h��'�D�]���M	8�>����;/���3QM�#ӻ?��V$���8�,ƨI��::��}S�/#�`��|\f�ҋ�g}�Z�����G���IK��?)GJ��A'�*���TTC�^|�̻Y{Z��u��J����l-h����ի*|��t���'PF�j�޸�����Ľ ���?��!N���Ԑ�|��s��Aj�.H��'�,[���O���$}ϟN*�C$����G�py�o!�{@.�䠯���eED�w��/�5&����(:��v��jYѻ�4'է�n`E����X����t�����#x�6��w~��m����'�:�b����&(�?&�U��G?F��^�����:����^�d��#�>�^��FA@O�R6���_�����c뭮G�$�f����`�%�8���Q[�[�?���M ���G_|����g�(]���F
<q��۪%�o?�d�%5Sȇ?Й�F���l�ܽ��2��?�2��Tո��)��s?�)kpX��?�v�*<��Ă?j����a�w��q��}Y��_�q�[�xX���P�}� �:j���yB���?�0 |�9��+.2���炊�q�������`��b����o�z��oz�_"� ���0׬�g���/�O�u�����z��B�ã|XP��n��'��_`�7T����f��!g�o�[j�������� �Yw��.X��ꃿ������A���V�g6a&�����=�Do��j}���p�j��28pN��O�=N���Us����oUq8z/g=�C[����	~vD��u���_|yů��ٗ2D�>�C�{�s>5E�7��o��	U��ೡ!�F��́#M�������϶(,P��C�n���55�y��lR_|P�h�M�w~��Z^|m�E�}�w�RrÒ�>��ʶ �@+�0|~�[�d�Z���e3} ������Yh\��/a�1��DL�/~����|��2�
<��?s�N�9�C�`� !��d�O@��@�3� ��_M�H����#�����ZR_%��U�?Z��G�0�=f��~�/�I�M��a��9x%~��0#�Ѫ0c�sH�W��ew4�.z�wu��������g~W�e7��V�$~�2��ۭo���K靟@��`���T<�垯��g��7��
�ފ3G����b�ɯo������^�LV�O[^�z�YB��]���J��O<���h��h�:o�&����Ù�'�#��Qۂ��������鏜b��|�/�y��B_�2f6X���:U�����ap3��g![ �\|9���o.&(���s�;��ko}�h���Ƒi���R}�WG��`����BZ����6Hp��S�f�xԴ��t#�A�'�kW�̃A�G� �ɟ�O�!p��g�~xO�a��_������>�(��3V4w`x�_z�{���9�q;�:z��0+Btp��s?ax��/~�h6ԧ�� kO6}���?zv[����{��Z`�.~�t����+����0mJ��|*�#�'��1J77ȇ~��2c���p�im��� �'Z���}l�<U���>��5+�.t�?��.���Mr,����n������D��{������#�_�Pt����3��Z>�A]�oK��(�	໿3��/�/v�y�GL{�:�#�y��T�A{|?�����=��c��W�J��;�J�� F�}=�#e}��[Gfv��~{/[��j�b)��L������`L���Nq����~e��}c-ؽ���w����ה����'C�����%��F���z��r��� [hEL��3s�F�=��^F_��s�����9�`Y��L�bx������rԊ�|_���ݿ5�n����ܸ��zޏ�����>��
�5����B>R��g0ib;���,$T�Ts�V�S?G����>�c#����1?�����lXa�������������믿�ΣT�      �   t   x�}�1!Dk�)����X��YZ���
����r����̛7�b��
�[���J��!�#6T�� v-�(��^w����XG2����~B��~�ȓ�����y}h�+y�E�Ѕ6      �   �   x�5�1�@��z�s��j�r�� $$46C��ʲ�Ź��~���ސ2?�B6�>"�utQ�4k?B��Y>�h��'(e�ʭ��I�Jb'�6l�d�@�n} ;�V0;(UbOW�%��¢���r��k4�+$�>Q6�>�����4B      �   /   x�3�tJ���2�*-N��2�N�KO,Q �sz��^� J�0      �   j   x�m�;
�@ ��9�������[
�r�J0q�����:�������ꌔH�:�����;�������Q�d��Y0Oh�����}a@Âa#l7���#D��6���7�      �   �  x���]j�@�g���F��~�-)��`�C�ʒ��eɬ-�O�����yz�^�+�D��6m_�Y�������LV���m�^71���ೆ��ᤫ�r���Tfɸ�V4ٰkb��Vٛ�������ch�끕��~��<ė0���Vpݴ�Q��UZ9�Nr�H��!�-�+�ra�2/���dD�n�2��_�|�!�6���j�5��($���!���o7��XH�����Q��S�OB=o}��&%q��t�#��2N;b,�~�?�;X���@�j7�_5i���2%�R!Y<	U�m�X����N�w`�v��ӳԖIkʇq;���k�$LR�34�	�
v�	���e�1����nS<iN)D���G�f��N��|���ۗ�?�%�$KD����a�?�c֩Z�'l���9�?����
+$[���[.٘za�m$9y�JiS˛y��b�H��D[
[�c�_�!J�S���� UH̝0J�!��f���0       �   =   x�32�420��442 N��rNs.#���)X�=?���.lS퓙�_Z��� ����� ��!      �      x������ � �      �   {   x���tI�ͬLL��420��42���M,.O��,I��Yr�'fT�*8��*%�$�"�8#�s�R�ˑ�r���g"x'��!��!)1�g�1>IN��[fIB0F��� 6�:\      �   w   x�=��
�0E痯�Ĵt�
����B��4��$��fr9��']#=��R�ʙȉ�h_�Mm�1�i���S���\��p3���C�S�,�����%h)�����ڝ
̰3�� �_$o      �   �  x�}SMo�0=;��?`K�[���vkQl;�BM��H�J<�ߏ�G�Eؑ�G���i�ؼ96H#<L���H�i�n���2b��1���o`����A�n��"$;���w���Z�#'W�#Z�kxƎ !#�!b�j|�R�hD7�x@ V"��`(�"t)5y��h\-���x\!�$�б��c�l�Vu�cMD���,��,���M��y��w㯹l������NۈW^�ǖ�T%}g�zP��X�X*��?��i%L���tDUS�찊�ۍ�|�ђ�g)>�.m�}{����L� ��nfN��ݢ�Cm�Y鹿��pir�nk�g���l������,��z��pq���*��։��M����5�A��E��tn�zC��a�OK7��Cs��o���ҳ)�,S}=��j?xD�\�����P�*�x��^��x��0�[������h�}"�ᣗߑm�]�Q��_�V��H\s]      �   �   x�}��
�0���.I�&�ѓx��E(Ձl�|�R��rM���$H�(BI��z	P!�� �i�^�g�ކ�a��tm�r�X��QlxtT�{G���Ցp�	|.�q-�2Oۧ���v����cr�I�3r�-��v��|̥��Q[~����Q�˳E��Oι��m�      �      x������ � �      �   F   x�M˱�0C���� ��]��1���K�0Ѐ]�S���vh���fcΣ�t�|�tP�[U?�B      �      x�3�,I-��".s$�;F��� �R	�      �   P   x�3�	pT�M,��LQp��u�M�K��tN�K2�%�
��E\F��\�J��ss9�r���,O���1z\\\ n{�      �   .   x�3T�H�K/-*-V�M,��L�46 .#N�Ģ�\4�=... ��      �   <   x�3�L��HL)K�SpKL���tN�KI�KT�M,ITp�,�4�04�4bC#c�=... �+�      �   #   x�3�4B#CK]S]#.c!`����� x�      �      x��Z[o��|�~��v�$?^����esLfؗ�:kl+3r� ���I��v��d0������RE�07���?w�k�����ͯ�ð_�|׻��p���u|�������iX�����̀>�߾�G����ƙf�?~�I_}���F�$�1n��Lq.|��{�r	e�Uv|�MQQ�5)	�q���eT��(L�x���^H����a�/��qW����O̭��
�%�!ͅ�����Ǉ������ׇ��#�X��2v��ǵP�۬I�f�U�T�NH���Rxb$)�UW�Helw�9���l�ϸ�>��	)I��9�����>d%1g���K�/X#�ef���J��߼>>� �a������􌶻��o�zx�~���ix�]
<�n�u��N%�45�����b�*N���3oE�.�R��%y��k�������%���Hܥ(��3~i�qbP�`[鶌m�6���wwO_���t�5q�S��^G�FMŴ
ΗB!�й.��YsiZ
f�ؘf<j�lK1OV����:R��QX����?�JO[�6Bc�vEԩ�}�2����w_���(i�`W��U�r-U��=y'S�>SvV�xT�8�nǒĳ��:��ŵ��%�����3�t���~l���oο�Kl�m�XҊ䜛�}�y�tܯ����<�Fڐ��4�yi�F�$��4��G���P���'�u���P�/dh¹M�{�m+H�_��E9�q�o����������U:�-[�7V�bEj&-��h?�nmK�^�߁��J�o�����:�çe#���?fy�d�hm��U��gd���S���d�'�q[�V�4�,3ڨ�Ĭ��̇���׿4��?b[NÅ�h��������hc�	N���Y���'�������D��ן�b9+��Z]l�m��t3���MT���o��{�b�qu��E%�|����'/b�Be-�IF�:�g�ˀ�n8�K��������h������"�\Ӵ������q{|X*?���O�L?<s6��McA�`������ŘvVyVC�Ԍs�|ǹ.
��Es>ް��ȵ��+�Č�h�S
ћdH%5�JH2-�!8��0y����/Y���DU�d�D�ϻ?(ߡ�z���C�v�ce2���^�-�P1�B��G�@4�p��W�R��GK�f!�F1��e���4��"[E��~��ܮS�����xx��~M��Z��)Ƭ}/�
2�(k��l�}� ֽ�	XE�V̸	^�\��X�L�C��~�dc6A%���_P$�V���+�����������FQ���C��+��AH�k54�3F�Uޱ���x���r�}�����:�C�4�T_Aǈ�v���~}.mp�*�y����E�V�l�Rb%y��4�OO���5�Μ����5_��Xe��r�x�(&*"�[�Th�z�-c� �"�)�ꅠ����8do�x�-g���F�e���u{.�/��8�Ƚ>����@R[E�V�@s�s���޾Ё_�z�6]W�y�|R�Վ���ő2d}��)`��E��"��q$�p7PƦxN�t�@�Po�p���C}2��oϿ��l����V��*~���S,ֿG��*Yg/�NT�+SθB��pH-�B�,j�
�)e<]���{"t>��W���ka��
ڧ�����G�B�C�O�cǍ�F��X��nQ���ћQ������I��t���t���X}8�3ƚ��so���ݎ�;ρ��B�^�=���5Sq
&˨��r]g��ar.D��{�p�M@��	O��!�ɗ;�B�I��K�R�%�@w���K���àl(4X�N<=��a�����t���Z���c)W����:
�P������������\B�����U�y�ZL�aƘ�1U��«�����:Rl¿7��%���#~WR?�@��9��������������:t7}�3��J��/�YP4��2t�l|�미�<��B-G��J3N޴�x)(�9j�ˆs� ~B�ePa������iT�M��E�4�����172�O���w����+��#U�2��BȰ�"�EW<M�u

�%|\�a
��#�d����,�)(+0J�~}��4�	�4��4[�]݅aHM�,�{l�}/�*%���Ə��)�e���XJ�Xs'\�M�1����6t��S��~�z�xr4���o��&�<^�َ�x��ײ_��M����x����%t�i�����b�����tp� ܝ��������p7p�������Ӯf�������|d��~>��{���d_��MDR�+둽d�������e�	tp?�.r(e�~9�9q�n��]C�Wuϕw\&Я'�����^�s\�5�{���|�K�[�;�)��pZ�3�2�2�ʙK�k�����D�FOA���a_As��V< }�Ty�\�=��!<������B��2T:��o���M?���'j�:;AA<�����0�����֜/J�*y��([(]�w(��H�B���K�VcsQ��K(�3�8�`E�H�Z�q͐譻��Z�"D�|����̙-�<'WJ<��}����a���î��W�?�?�A����Џ7枴h��XdC;<��j�s�4nU7�Y۵��^�̌'��<��(�1hǒ�)�4I�r�mA%�8D`���*��L��ַ���-A��0j��"������e����2���	&��H��?{��ߞm�HX��\�����gi��n��������g\�rtR(0��'�xaYꖪ	ꓼ1���"�@���y~����^�p�v�/�Q*9�f�~%��J���Us�V�,�/�s��W�]E��xQ�*A���0G��S4�����;΄�]�� ���t�ʨC����i�������-��ag������þ�Z]"�_�o}�|h�������B����w��v5�q�F�C1C{8�EeS��q�TQ7Y#�8���(�"�,	�/��_�ɑ�GU�`�g:�� mSz_�I��������&���'T�> �/*�m8��I�}+d�]��X��h� H=�Z1�#R�$9�>�dh�*��J�������>	����.���%1_�`��翴�%�nK0��	%V�<#�~8 �n.�H�T5=UmAqs|�$b����T�� �k�����F�qŽ6��O�I��x�>�U��"[_"PXǉg��+Q������^�i|�V���'���,����߱+e� >�wǱ����f�L�	Y{�骰��	+-b���F����W�
�ޑ�0���:^n�t���$B8�y|�_n�b>�2�i��{�/����EП��yY��x;|?�<ͳLT*ʢ=�\o�{����*�#��[8Q�-1���Sǋ'$l@Q˱�#���h�^ڹy<EB&2�	e2��h(7��%��	�#�����R�h�

�|;��p���OU��z�����.�u��%�b���#����x$Ɩ	7�5��.�̲����4�\�۾(��N����ؖ�c#2
Y=��4��%���-�R�9i��<���vP������a�{�9��b���W[���)��Z�{%�u��?&\׳���em	� ��ŏ�k	e��	Z��*�r��'��C=}���щ��:4+��:����[0J Um�vژ����'��m��R�ԣ-�I?��H��I���ǈC�v����Q�]�}��۾Q	
��g\{��b�rQ�_���/�-��Ju�i6�o���a�C���X�{�	�!U=�n;���8�W����mh�T���Rʹ�G(��-�C�%��&#t���>�<����G��&��Ep���z��f�E�\w��}9���"���PpP��A(��
�ÀM�<Y���&�'��ЂM�W"Z�	W�V����	Y�XO������\A��7;VZ�$�?���i;v���U�o}Mz|���×�ُ�g��B�p��+5���h��SS1ZW��i�
}���<(��QLx�趪(Uw�-z�	�G�g�*qi3���m=Xi� f �   �������/���nÉPIW�d[�1�P�~�v��S����a��xg�����-Ze�����{(�`f_G=*��\R���Z�i�y����()��ɖy���t}���L��������2\����e8|a��ml�mv�c���'_����~�����n)[��+_�)�JJ���b��s�MT<&��ֆG�x�1�8K�u<8_OMc.�͸������!k��K�/I4[�6
y����j�O
;��     