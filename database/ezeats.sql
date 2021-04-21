-- EzEats Database using postgresql

create table tb_user (
	id BIGSERIAL primary key unique not null,
	nama VARCHAR(50) not null,
	deskripsi_singkat VARCHAR(50),
	email VARCHAR(50) unique not null,
	passwrd VARCHAR(50) not null,
	no_telp VARCHAR(25),
	alamat VARCHAR(250) 
);

create table tb_makanan (
	tipe_id BIGSERIAL unique not null,
	makanan_id BIGSERIAL unique not null,
	tipe VARCHAR(50) unique not null,
	nama VARCHAR(50) unique not null,
	deskripsi TEXT,
	harga BIGINT not null,
	primary key (tipe_id, makanan_id)
);

create table tb_resto (
	id BIGSERIAL primary key unique not null,
	nama VARCHAR(50) not null,
	alamat TEXT not null,
	rating DOUBLE PRECISION,
	no_telp VARCHAR(25)
);

create table tb_resto_makanan (
	makanan_id BIGSERIAL references tb_makanan (makanan_id) on update cascade,
	tipe_id BIGSERIAL references tb_makanan (tipe_id) on update cascade,
	resto_id BIGSERIAL references tb_resto (id) on update cascade on delete cascade,
	CONSTRAINT resto_makanan_pkey PRIMARY KEY (makanan_id, tipe_id, resto_id)
);

create table tb_review (
	user_id BIGSERIAL references tb_user(id) on update cascade,
	resto_id BIGSERIAL references tb_resto(id) on update cascade on delete cascade,
	review TEXT,
	summary VARCHAR(250),
	upvote BIGINT,
	downvote BIGINT,
	likes INT,
	constraint review_pkey primary key (user_id,resto_id)
);