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
	gambar VARCHAR(100),
	cover VARCHAR(100)
);

create table tb_resto (
	id BIGSERIAL primary key not null,
	user_id INT,
	nama VARCHAR(150) not null,
	kategori VARCHAR(25) not null,
	harga VARCHAR(200) not null,
	jambuka VARCHAR(10) not null,
	jamtutup VARCHAR(10) not null,
	fasilitas TEXT,
	deskripsi TEXT,
	jalan VARCHAR(150) not null,
	kecamatan VARCHAR(100) not null,
	kotakab VARCHAR(50) not null,
	namakabkota VARCHAR(100) not null,
	provinsi VARCHAR(100) not null,
	web VARCHAR(200),
	foto_menu VARCHAR(600),
	foto_resto VARCHAR(100),
	no_telp VARCHAR(25),
	upvotes INT,
	downvotes INT,
	CONSTRAINT fk_user FOREIGN KEY(user_id) references tb_user(id)
);

create table tb_review (
	id BIGSERIAL primary key not null,
	user_id INT,
	resto_id INT,
	judul VARCHAR(100),
	ulasan TEXT,
	gambar VARCHAR(100),
	rekomendasi VARCHAR(50),
	jam VARCHAR(50),
	tanggal VARCHAR(50),
	upvotes INT,
	downvotes INT,
	CONSTRAINT fk_user FOREIGN KEY(user_id) references tb_user(id),
	CONSTRAINT fk_resto FOREIGN KEY(resto_id) references tb_resto(id)
);

insert into tb_user(nama, email ,password)
values ('admin', 'admin@gmail.com', 'admin'); --- Jangan lupa untuk diingat :D

-- Note : untuk user_id nya sesuaikan dengan id user 'admin' di table tb_user
--		  ex : karena id user admin gw 4, makanya user_id nya 4 sesuai dg yg kodingan dibawah
insert into tb_resto (user_id, nama, kategori, jalan, kecamatan, kotakab, 
					  namakabkota, provinsi, web, no_telp, jambuka, jamtutup, 
					  harga, fasilitas, upvotes, downvotes, foto_resto, foto_menu)
values
	(4, 'McDonald`s Dramaga', 'Cepat Saji', 'Jl. Raya Dramaga No.1',  
	'Dramaga', 'Kabupaten', 'Bogor', 'Jawa Barat', 'mcdonalds.co.id', '+628118067228', '00:00','23:59','10000 - 120000',
	'Drive Thru, Delivery, AC, Wi-Fi, Outdoor, Smoking Area', 100, 70, 'mcd.jpg','menu-mcd-1.jpg; menu-mcd-2.jpg'),
	(4, 'Pizza Hut Margonda', 'Cepat Saji', 'Jl. Margonda Raya No.356', 'Beji', 'Kota', 'Depok', 'Jawa Barat','pizzahut.co.id',
	'+628113249088', '09:00', '21:00', '40000 - 250000', 'Drive Thru, Delivery, AC, Smoking Area', 
	97, 54, 'pizzahut.jpg','menu-pizzahut-1.jpg; menu-pizzahut-2.jpeg'),
	(4, 'Taco Bell', 'Cepat Saji', 'Jl. Senopati No.96',  'Kebayoran Baru', 'Kota', 'Jakarta Selatan', 'DKI Jakarta','tacobell.co.id',
	'', '10:00', '21:00', '50000 - 200000', 'Wi-Fi, Delivery, AC, Music', 112, 42,'tacobell.jpg', 'menu-tacobell-1.jpg'),
	(4, 'Restoran Sederhana', 'Kuliner Indonesia', 'Jl. Raya Pajajaran No.31',  'Bogor Tengah', 
	'Kota', 'Bogor', 'Jawa Barat','','+622518343516', '08:00','22:00','15000 - 80000','AC, Smoking Area', 84, 25,'sederhana.jpg',
	'menu-sederhana-1.jpg; menu-sederhana-2.jpg'),
	(4, 'Gurih Tujuh', 'Kuliner Indonesia', 'Jl. Raya Pajajaran No.102', 'Bogor Tengah', 'Kota', 'Bogor', 'Jawa Barat','restogurih7.com',
	'+622518317889', '09:00','22:00','30000 - 200000','Delivery, AC, Wi-Fi, Music', 147, 41,'gurih7.jpg','menu-gurih7-1.jpg; menu-gurih7-2.jpg'),
	(4,'KAUM Jakarta', 'Kuliner Indonesia', 'Jl. Dr. Kusuma Atmaja No.77',  'Menteng', 'Kota', 'Jakarta Pusat', 'DKI Jakarta','kaum.com',
	'+622122393256', '11:00','22:30','50000 - 250000','Valet, AC, Wi-Fi, Music, Smoking Area', 110, 23,'kaumj.jpg',
	'menu-kaumj-1.jpg; menu-kaumj-2.jpg; menu-kaumj-3.jpg; menu-kaumj-4.jpg; menu-kaumj-5.jpg; menu-kaumj-6.jpg; menu-kaumj-7.jpg; menu-kaumj-8.jpg; menu-kaumj-9.jpg'),
	(4, 'Mujigae', 'Kuliner Korea', 'Jl. KH. Muchtar Tabrani Komplek Masjid Al-Makmur No.1',  'Bekasi Utara', 'Kota', 'Bekasi', 'Jawa Barat','www.mujigae.com',
	'+6287782127999', '09:00','23:59','10000 - 55000','Dine In, Delivery, Music, AC, Wi-Fi', 80, 23,'resto_mujigae.jpg','menu_mujigae1.png; menu_mujigae2.png'),
	(4, 'Ojju', 'Kuliner Korea', 'Jl. Raya Casablanca No.88',  'Tebet', 'Kota', 'Jakarta', 'DKI Jakarta','','+622123581349/1350', '11:00',
	'22:00','25000 - 250000','Dine In, Buffet, Take Home, AC, Wi-Fi', 110, 5,'resto_ojju.jpg', 'menu_ojju.png'),
	(4, 'Yongdaeri Korean BBQ', 'Kuliner Korea', 'Jl. Jenderal Sudirman No.Kav 52-53',  'SCBD', 'Kota', 'Jakarta', 'DKI Jakarta','','+62215150773', '11:30',
	'21:00','15000 - 350000','Dine In, Take Home, AC, Wi-Fi, Smoking Area, Alcohol', 80, 23,'resto_yongdaeri.jpg','menu_yongdaeri1.jpeg;menu_yongdaeri2.png'),
	(4, 'Bakso Taman Solo', 'Aneka Mie dan Bakso', 'Jl. Cempaka Putih Raya No.127',  'Cempaka Putih', 'Kota', 'Jakarta', 'DKI Jakarta','',
	'+6281293702839', '08:30','21:30','2000-20000','Dine In, Take Home, Smoking Area', 328, 10,'resto_tamansolo.jpg','menu_tamansolo.jpeg'),
	(4, 'Bakso Boedjangan', 'Aneka Mie dan Bakso', 'Jl. Ring Road Taman Yasmin',  'Yasmin', 'Kota', 'Bogor', 'Jawa Barat','baksoboedjangan.com','', 
	'08:30','21:30','6000 - 55000','Dine In, Take Home, Smoking Area', 60, 10,'resto_boedjangan.jpg','menu_boedjangan.png'),
	(4, 'Mie Ayam Surya', 'Aneka Mie dan Bakso', 'Jl. Karang Satria',  'Duren Jaya', 'Kota', 'Bekasi', 'Jawa Barat','','+6281316349745', 
	'09:00','22:20','6000 - 25000','Dine In, Take Home, Delivery, Smoking Area', 87, 5,'resto_mieayamsurya.jpg','menu_mieayamsurya.jpg');
	








