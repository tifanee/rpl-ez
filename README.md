# EzEats
![index](https://user-images.githubusercontent.com/65725044/121421713-a7a8c680-c998-11eb-85f9-d318d9fe48b3.png)
EzEats adalah aplikasi berbasis web yang diharapkan dapat membantu masyarakat, khususnya foodhunter untuk saling berinteraksi satu sama lain dengan bertukar informasi mengenai penilaian ataupun ulasan terhadap sebuah rumah makan.

# Laporan Akhir Proyek Rekayasa Perangkat Lunak (KOM331)
* Pararel : 2
* Kelompok : 12

**Asisten Praktikum:**
| Nama                            | NIM       | 
| ------------------------------- | --------- | 
| Levina Siatono                  | G64180019 | 
| Ali Naufal Ammarullah           | G64180080 | 
| Muhammad Fauzan Ramadhan        | G64180117 | 

# Our Team
| Nama                            | NIM       | ROLE                                  |
| ------------------------------- | --------- | ------------------------------------- |
| Laudza Muhammad Afin Tachtiar   | G64190052 | Project Manager & Front-End Developer |
| Muhammad Arief                  | G64190063 | Back-End Developer                    |
| M. Iqbal                        | G64190074 | Back-End Developer                    |
| Tifanee Anindhita               | G64190080 | UI Designer & Front-End Developer     |

# Latar Belakang
Kemudahan dan keterbukaan akses informasi untuk segala kalangan merupakan hal yang banyak didambakan oleh semua orang. Revolusi industri 4.0 yang berfokus pada transformasi industri manufaktur melalui digitalisasi dan eksploitasi teknologi baru telah memaksa kita untuk beralih menjadi pribadi yang harus melek dengan teknologi, khususnya dunia digital. Kenyataannya, kemajuan teknologi benar-benar telah memudahkan manusia hampir di segala sendi kehidupan, tak terkecuali di bidang kuliner. Di sisi lain, seiring dengan berkembangnya peradaban manusia, bidang kuliner tak hanya menjadi urusan mengenyangkan perut balaka, akan tetapi telah menjadi gaya hidup dan bahkan telah menjadi salah satu tonggak dalam sektor bisnis dan pariwisata.

Jika ditarik mundur ke belakang, tepatnya di tahun 1970 dimana komputer generasi ketiga mulai diproduksi, teknologi komputasi mulai banyak digunakan di sektor industri. Istilah perangkat lunak adalah hal yang tak dapat dipisahkan dengan teknologi komputasi ini. Salah satu jenis perangkat lunak yang banyak dapat ditemukan saat ini adalah perangkat lunak aplikasi. Perangkat lunak aplikasi itu sendiri adalah serangkaian instruksi mandiri yang diproses oleh komputer dan bertujuan untuk memenuhi kebutuhan bisnis tertentu.

Kemajuan teknologi perangkat lunak serta berkembangnya paradigma masyarakat dalam bidang kuliner ini kami lihat sebagai sebuah peluang untuk dapat mengembangkan teknologi perangkat lunak aplikasi yang menghimpun kumpulan penilaian dan ulasan suatu entitas rumah makan. Kami berinovasi untuk membuat semacam aplikasi berbasis web yang akan memudahkan pengguna untuk mengetahui info lebih dalam dan beragam penilaian serta ulasan dari pengguna lainnya mengenai rumah makan tertentu. Aplikasi ini diharapkan dapat membantu pengguna untuk memilih tempat makan sesuai dengan preferensinya masing-masing.

# Tujuan
1. Memudahkan pengguna untuk mengetahui info lebih lanjut mengenai rumah makan.
2. Memudahkan pengguna untuk reservasi tempat di rumah makan dan memesan makanan secara delivery bila mendukung.
3. Membantu pengguna dalam mempertimbangkan memilih rumah makan dengan menyediakan fitur ratings and reviews.
4. Menyediakan tempat bagi pemilik rumah makan untuk memperkenalkan kedainya.
5. Menciptakan persaingan sehat antar rumah makan agar lebih dapat menarik perhatian pelanggan.

# User Analisis
## User Profile
Target kami adalah food hunter dan masyarakat yang ingin membeli suatu makanan dan tidak mengetahui letak tempat restorannya. Dengan ini juga para pedagang penjual makanan yang berada direstoran maupun toko dapat memasukkan data restorannya sehingga menjadi tempat promosi mereka.
## User Story
- Sebagai pengguna yang ingin menggunakan aplikasi, agar dapat terdaftar dalam aplikasi dan dapat menggunakan seluruh fitur yang tersedia, saya dapat melakukan registrasi dengan mencantumkan nama, alamat surel, dan kata sandi baru
- Sebagai pengguna yang ingin mencari rumah makan, menu masakan, serta lokasi tempat makan, saya dapat memanfaatkan search bar yang ada pada halaman utama aplikasi
- Sebagai pengguna yang telah terdaftar dan ingin ikut berkontribusi untuk mengembangkan database aplikasi, saya dapat menambah entri rumah makan beserta info seputar rumah makan yang bersangkutan
- Sebagai pengguna yang telah terdaftar dan ingin menginfokan suatu rumah makan kepada pengguna lain, saya dapat memberikan penilaian berupa rating dan ulasan berupa komentar terhadap suatu rumah makan
- Sebagai pengguna yang sedang mencari referensi rumah makan, saya dapat melihat berbagai menu dan galeri penampakan interior rumah makan pada detil entri rumah makan
- Sebagai pengguna terdaftar yang ingin menyimpan daftar rumah makan favorit maupun rumah makan yang dihindari, saya dapat menambahkan kedua daftar tersebut pada info profil saya
- Sebagai pengguna yang ingin mencari rumah makan dengan kategori-kategori tertentu, saya menginginkan adanya fitur yang dapat memfilter hasil pencarian
- Sebagai pengguna yang ingin memesan makanan atau mereservasi tempat di rumah makan, saya dapat menghubungi pihak rumah makan melalui kontak yang tercantum pada detail entri rumah makan
- Sebagai pengguna terdaftar yang ingin memberikan tanggapan terhadap ulasan dari pengguna lain, saya dapat menilai apakah ulasan dari pengguna lain tersebut membantu atau tidak
# Spesifikasi Teknis Lingkungan Pengembangan
## Software
* Operating system : Windows 10, Mac OS 
* Text Editor : VS Code
* UI Design Tool : Figma
* Database : PostgreSQL
* Server : Apache
* Hosting : Heroku

## Hardware
* Prosesor : 11th Gen Intel(R) Core(TM) i5-1135G7 @ 2.40GHz (8 CPUs), ~2.4GHz
* Memori : 8192MB RAM
* Storage : 512GB

## Tech Stack 
* Front-End : HTML, CSS, Bootsrap, JQuery
* Back-End : PHP

## Lainnya
* Version Control System : Github
* Project Management : Trello
* Software Documentation : Google Sites

# Hasil dan Pembahasan
## Use Case Diagram
![usecase](https://user-images.githubusercontent.com/78838446/121642373-a1127000-caba-11eb-9a50-90df89979398.PNG)

## Use Case Description
### Add Resto
![usecasetabeladdresto](https://user-images.githubusercontent.com/78838446/121642462-bedfd500-caba-11eb-8a13-d3258b756ae2.PNG)
### Menambah ulasan
![usecasetabelreview](https://user-images.githubusercontent.com/78838446/121717138-0ee68800-cb0b-11eb-869d-5440942ea173.PNG)
### Menambah penilaian
![usecasetabelrateng](https://user-images.githubusercontent.com/78838446/121717210-20c82b00-cb0b-11eb-8b53-7398ea459cfb.PNG)
## Activity Diagram
### Mendaftar Akun
![Activity Diagram-Register Akun](https://user-images.githubusercontent.com/65725044/121325450-cfb60c80-c93b-11eb-8895-8c36ee7319ed.png)
### Masuk Akun
![Activity Diagram-Sign In](https://user-images.githubusercontent.com/65725044/121325997-50750880-c93c-11eb-85de-495fb5f29faf.png)
### Menambah Ulasan
![EzEats-Menambah ulasan](https://user-images.githubusercontent.com/65725044/121656439-ac20cc80-cac9-11eb-9b52-fa11694ee805.png)
### Menambah Resto Baru
![EzEats-Menambah info restoran](https://user-images.githubusercontent.com/65725044/121656401-a4f9be80-cac9-11eb-9c28-72a3aeb5630c.png)
### Menambah Penilaian
![EzEats-Menambah penilaian resto](https://user-images.githubusercontent.com/65725044/121659023-18043480-cacc-11eb-90a8-063947d603b4.png)
## Class Diagram
## Entity Relationship Diagram (ERD)
![ERD](https://user-images.githubusercontent.com/78838446/121718457-8963d780-cb0c-11eb-823a-81e51aa098de.PNG)
## Software Architecture
## Fungsi Utama yang Dikembangkan
* User dapat membuat ulasan untuk restoran.
* User dapat menambah info restoran.
* User dapat memberi penilaian pada restoran.
## Fungsi CRUD
### Create
* Membuat akun pada aplikasi web EzEats
* Membuat ulasan
* Menambah daftar restoran
* Menambah daftar restoran favorit
* Menambah daftar restoran direkomendasikan/tidak direkomendasikan
### Read
* Membaca user input (email dan password) pada akun pengguna saat sign in.
* Menampilkan ulasan
* Menampilkan daftar restoran
### Update
* Mengedit info user
* Mengubah kata sandi
* Mengedit info restoran
* Menambah foto profil pada pengguna
### Delete
* Menghapus restoran favorit
* Menghapus restoran direkomendasikan/tidak direkomendasikan
* Menghapus riwayat resto yang baru dilihat
# Hasil Implementasi
## Link Aplikasi
Demo aplikasi dapat diakses pada link : *insert link*
# Testing (Test Cases)
Kami melakukan pengujian secara manual (manual testing) tanpa menggunakan bantuan tools atau scripts, tujuannya adalah untuk memastikan aplikasi bebas dari bugs/error dan memastikan dapat bekerja sesuai dengan yang diharapkan.

## Positive Case
Pengujian Positif merupakan jenis pengujian yang dilakukan pada aplikasi perangkat lunak dengan memberikan kumpulan data yang valid sebagai input.
| No |   Scenario  | Pre-requisites | Steps | Expected Result | Actual Result | Status |
| -- | ----------- | -------------- | ----- | --------------- | ------------- | ------ |
| 1  | User login dengan akun yang valid | User mengakses website EzEats | Pergi ke halaman Masuk, masukkan email dan password, klik masuk | Login berhasil dan user diarahkan ke home | d | e |
| 2  | User mendaftar nama lengkap, email, dan password yang valid | User mengakses website EzEats | Pergi ke halaman daftar, masukkan nama, alamat email, password, dan konfirmasi password, lalu klik daftar | Daftar berhasil | d | e |
| 3  | Edit info user di edit profile | User mengakses website EzEats | b | c | d | e |
| 4  | Menambah ulasan restoran | User mengakses website EzEat | b | Berhasil menambahkan ulasan | d | e |
## Negative Case
Pengujian Negatif adalah metode pengujian yang dilakukan pada aplikasi perangkat lunak dengan memberikan kumpulan data yang tidak valid atau tidak tepat sebagai input.

# Kesimpulan
Dengan rentang waktu pengembangan aplikasi yang terbatas, tim kami berhasil membangun sistem yang diharapkan walaupun masih jauh dari kata sempurna.

# Saran untuk Pengembangan Berikutnya

# Ucapan Terima Kasih
Selama pengembangan website EzEats ini, tim kami banyak mempelajari hal-hal baru dalam bidang pengembangan perangkat lunak. Maka dari itu, kami ingin mengucapkan terima kasih kepada :
1. Para dosen Ilmu Komputer IPB terutama dosen-dosen mata kuliah Rekayasa Perangkat Lunak karena telah memberikan ilmu kepada kami
2. Para asisten praktikum karena telah memberikan masukan dan saran selama pengembangan website EzEats
