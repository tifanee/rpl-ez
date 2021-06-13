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

INSERT INTO tb_resto(user_id, namaresto, kategori, deskripsi, jalan, kecamatan,kabkota, kota , 
	provinsi, web, no_telp, jambuka, jamtutup, harga, fasilitas, upvotes, downvotes, foto_resto, foto_menu);
values
	(99, 'McDonalds Dramaga', 'Cepat Saji','-' ,'Jl. Raya Dramaga No.1', 'Dramaga','kota','Bogor', 'Jawa Barat','mcdonalds.co.id','+628118067228','00.00','23.59','IDR 10.000 - 120.000','Drive Thru, Delivery, AC, Wi-Fi, Outdoor, Smoking Area', 100, 70,'mcd.jpg','menu-mcd-1.jpg, menu-mcd-2.jpg'),
	(99, 'Pizza Hut Margonda', 'Cepat Saji', '-','Jl. Margonda Raya No.356',  'Beji','kota', 'Depok', 'Jawa Barat','pizzahut.co.id','+62 811 3249 088', '09.00','21.00','IDR 40.000 - 250.000','Drive Thru, Delivery, AC, Smoking Area', 97, 54,'pizzahut.jpg','menu-pizzahut-1.jpeg, menu-pizzahut-2.jpeg'),
	(99, 'Taco Bell', 'Cepat Saji','-', 'Jl. Senopati No.96',  'Kebayoran Baru','kota', 'Jakarta Selatan', 'DKI Jakarta','tacobell.co.id','-', '10.00','21.00','IDR 50.000 - 200.000','Wi-Fi, Delivery, AC, Music', 112, 42,'tacobell.jpg','menu-tacobell-1.jpg, menu-tacobell-2.jpg'),
	(99, 'Restoran Sederhana', 'Kuliner Indonesia','-', 'Jl. Raya Pajajaran No.31', 'Bogor Tengah','kota', 'Bogor', 'Jawa Barat','-','+62 251 8343 516', '08.00','22.00','IDR 15.000 - 80.000','AC, Smoking Area', 84, 25,'sederhana.jpg','menu-sederhana-1.jpg, menu-sederhana-2.jpg'),
	(99, 'Gurih Tujuh', 'Kuliner Indonesia', '-','Jl. Raya Pajajaran No.102', 'Bogor Tengah','kota', 'Bogor', 'Jawa Barat','restogurih7.com','+62 251 8317 889', '09.00','22.00','IDR 30.000 - 200.000','Delivery, AC, Wi-Fi, Music', 147, 41,'gurih7.jpg','menu-gurih7-1.jpg, menu-gurih7-2.jpg'),
	(99, 'KAUM Jakarta', 'Kuliner Indonesia','-', 'Jl. Dr. Kusuma Atmaja No.77',  'Menteng','kota', 'Jakarta Pusat', 'DKI Jakarta','kaum.com','+62 2122 3932 56', '11.00','22.30','IDR 50.000 - 250.000','Valet, AC, Wi-Fi, Music, Smoking Area', 110, 23,'kaumj.jpg','menu-kaumj-1.jpg, menu-kaumj-2.jpg, menu-kaumj-3.jpg, menu-kaumj-4.jpg,menu-kaumj-5.jpg,menu-kaumj-6.jpg,menu-kaumj-7.jpg,menu-kaumj-8.jpg,menu-kaumj-9.jpg'),
	(99, 'Mujigae', 'Kuliner Korea','-', 'Jl. KH. Muchtar Tabrani Komplek Masjid Al-Makmur No.1',  'Bekasi Utara','kota', 'Bekasi', 'Jawa Barat','www.mujigae.com','+62 877 8212 7999', '09.00','23.59','IDR 10.000 - 55.000','Dine In, Delivery, Music, AC, Wi-Fi', 80, 23,'resto_mujigae.jpg','menu_mujigae1.png,menu_mujigae2.png'),
	(99, 'Ojju', 'Kuliner Korea','-', 'Jl. Raya Casablanca No.88',  'Tebet', 'kota','Jakarta', 'DKI Jakarta','-','+6221 2358 1349/1350', '11.00','22.00','IDR 25.000 - 250.000','Dine In, Buffet, Take Home, AC, Wi-Fi', 110, 5,'resto_ojju.jpg','menu_ojju.png'),
	(99, 'Yongdaeri Korean BBQ', 'Kuliner Korea','-', 'Jl. Jenderal Sudirman No.Kav 52-53',  'SCBD', 'kota','Jakarta', 'DKI Jakarta','-','+6221 5150 773', '11.30','21.00','IDR 15.000-350.000','Dine In, Take Home, AC, Wi-Fi, Smoking Area, Alcohol', 80, 23,'resto_yongdaeri.jpg','menu_yongdaeri1.jpeg,menu_yongdaeri2.png'),
	(99, 'Bakso Taman Solo', 'Aneka Mie dan Bakso','-', 'Jl. Cempaka Putih Raya No,127',  'Cempaka Putih','kota','Jakarta', 'DKI Jakarta','-','+62 812 9370 2839', '08.30','21.30','IDR 2.000-20.000','Dine In, Take Home, Smoking Area', 328, 10,'resto_tamansolo.jpg','menu_tamansolo.jpeg',),
	(99, 'Bakso Boedjangan', 'Aneka Mie dan Bakso','-', 'Jl. Ring Road Taman Yasmin',  'Yasmin', 'kota','Bogor', 'Jawa Barat','baksoboedjangan.com','', '08.30','21.30','IDR 6.000.000-55.000','Dine In, Take Home, Smoking Area', 60, 10,'resto_boedjangan.jpg','menu_boedjangan.png',),
	(99, 'Mie Ayam Surya', 'Aneka Mie dan Bakso','-', 'Jl. Karang Satria',  'Duren Jaya','kota', 'Bekasi', 'Jawa Barat','-','+62 813 1634 9745', '09.00','22.20','IDR 6.000.000-25.000','Dine In, Take Home, Delivery, Smoking Area', 87, 5,'resto_mieayamsurya.jpg','menu_mieayamsurya.jpg',),
	(99,'KFC Dramaga', 'Cepat Saji','-', 'Jl. Dramaga Cantik',  'Dramaga','kota', 'Bogor', 'Jawa Barat','Kfcku.com','+62 851 9231 1289','09.00','21.00','IDR 9.500 - 124.500','Drive Thru, Delivery, AC, Wi-Fi, Outdoor, Smoking Area', 100, 30,'kfc-dramaga-cantik.jpg','menukfc1.png, menukfc2.1.png,menukfc2.2.png'),
	(99,'Hisana Dramaga', 'Cepat Saji','-', 'Jl. Babakan Tengah',  'Dramaga','kota', 'Bogor', 'Jawa Barat','-','-','06.00','22.00','IDR 9.500 - 24.000','indoor', 80, 20,'hisanadramaga.jpg','hisanadramagamenu.jpg'), 
	(99,'Chick n tea', 'Cepat Saji','-', 'Jl. Babakan Tengah',  'Dramaga','kota', 'Bogor', 'Jawa Barat','-','-','08.00','22.00','IDR 2.500 - 10.000','indoor', 80, 20,'chicknteababakan.png','chicknteababakanmenu.jpg'),
	(99,'Pancong Tampo', 'Cepat Saji','-', 'Jl.Babakan Raya',  'Dramaga','kota', 'Bogor', 'Jawa Barat','-','085719609811','10.00','23.00','IDR 5.000 - 21.500','indoor', 80, 20,'pancong.png','pancongmenu.jpg'),
	(99,'Super kue', 'Instant jadi','-', 'Jl. Raya Dramaga No.42',  'Dramaga','kota','Bogor', 'Jawa Barat','Superkue.com','0857-7773-8484','06.00','21.30','IDR 7.500 - 50.000','indoor', 80, 20,'superkue.png','superkuemenu.png'),
	(99,'Bersama snack', 'Snack','-', 'Jl. Babakan Raya No.22',  'Dramaga','kota', 'Bogor', 'Jawa Barat','-','0896-9469-4005','08.00','20.00','IDR 5.000 - 50.000','indoor', 80, 20,'bersamasnack.png','-');









