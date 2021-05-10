-- EzEats Database using postgresql --
create database db_ezeats;
-- user table
create table tb_user (
	id BIGSERIAL primary key, 
	email VARCHAR(100) not null,
	nama VARCHAR(100) not null,
	deskripsi_singkat VARCHAR(50),
	password VARCHAR(255) not null,
	no_telp VARCHAR(50),
	alamat VARCHAR(250),
	tanggal_lahir date,
	gambar VARCHAR(100)
);

---------------------------------------------------
---------- Masih menunggu mockup figmanya ---------
---------------------------------------------------
-- create table tb_tipe_makanan (
-- 	kategori_id varchar(25) not null,
-- 	kategori VARCHAR(50) not null,
-- 	nama VARCHAR(50) not null,
-- 	deskripsi TEXT not null
-- );

-- insert into tb_tipe_makanan(kategori, nama, deskripsi, harga) 
-- 	values
-- 	('Minuman', 'Boba', 'Minuman yg berbahan dasar tepung dan dikasih toping', 8000),
-- 	('Makanan Ringan', 'Martabak Telur', '', 12000),
-- 	('Makanan Berat', 'Rendang', 'Dishes yang berbahan dasar daging', 9000),
-- 	('Makanan Berat', 'Gulai', 'Dishes yang berbahan dasar daging', 10000);

-- create table tb_resto (
-- 	id BIGSERIAL primary key unique not null,
-- 	nama VARCHAR(50) not null,
-- 	alamat TEXT unique not null,
-- 	rating DOUBLE PRECISION,
-- 	no_telp VARCHAR(25),
-- 	upvotes BIGINT,
-- 	downvotes BIGINT
-- );

-- insert into tb_resto(nama, alamat, no_telp) 
-- 	values
-- 	('Boba Kingdom', 'Bogor', '0813452626212'),
-- 	('Martabak City', 'Tangerang', '08134562728'),
-- 	('RM Padang', 'Jakarta', '08134556272777');

-- create table tb_resto_makanan (
-- 	makanan_id BIGSERIAL references tb_makanan (makanan_id) on update cascade on delete cascade,
-- 	kategori_id BIGSERIAL references tb_makanan (kategori_id) on update cascade on DELETE cascade,
-- 	resto_id BIGSERIAL references tb_resto (id) on update cascade on delete cascade,
-- 	CONSTRAINT resto_makanan_pkey PRIMARY KEY (makanan_id, kategori_id, resto_id)
-- );

-- create table tb_review (
-- 	user_id INT references tb_user(id) on update cascade,
-- 	resto_id INT references tb_resto(id) on update cascade on delete cascade,
-- 	lokasi VARCHAR(50) references tb_resto(alamat),
-- 	review TEXT,
-- 	vote INT,
-- 	likes INT,
-- 	constraint review_pkey primary key (user_id,resto_id)
-- );

-- insert into tb_review(user_id, resto_id, nama_resto, lokasi, review, vote) 
-- 	values
-- 	(0, 1, 'Bobanya sungguh lezat, bikin nagih!!', 1),
-- 	(1, 1, 'kebanyakan gula', 0),
-- 	(2, 2, 'kebanyakan gula', 0);
-- ================================================================================================
-- Procedure dan Trigger --------------------------------------------------------------------------
-- ================================================================================================

