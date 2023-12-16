Juan Verrel Tanuwijaya, 121140072, RA, UAS Pemrograman Web 

Website (hosting) : https://data-makanan-121140072.000webhostapp.com/ 

(website akan menampilkan pesan dangerous website ketika diakses, untuk masuk kedalam website klik detail dan klik "visit this unsafe website")

Username : Admin

Password : 123456

-Bagian 1: Client-side Programming

Dibuat 2 page website dengan page yang pertama untuk login(index.php), dan page kedua untuk manajemen data makanan CRUD (makanan.php), 
pada page login ada form untuk menginput data login,
dan pada page manajemen ada 2 form yang digunakan untuk menginput dan mengedit data,
form akan muncul ketika tombol tambah data / edit data di klik menggunakan DOM javascript, 
pada page manajemen form memiliki 5 inputan yang memiliki tipe input text, radio, selection, dan check box. 
Kemudian setelah data diinput, data akan ditampilkan pada tabel dan tabel dilengkapi dengan fitur filter melalui jenis data makanan dan hapus data.
Sebelum data yang diinput diproses ke dalam file php, data akan terlebih dahulu divalidasi dengan javascript menggunakan fungsi "validasiForm()" untuk memastikan inputan tidak kosong, jika ada inputan kosong akan ditampilkan "alert" pada website. 

-Bagian 2: Server-side Programming

Dibuat 5 file php utama yang berfungsi untuk menghandle proses data pada website ke database,

login.php = digunakan untuk memverifikasi user yang ingin login dan ingin mengakses ke dalam page manajemen (method Post), 

tambahdata.php = digunakan untuk menambahkan data makananan yang diinput dari website ke database (method Post),

editdata.php = digunakan untuk melakukan pembaruan data yang sudah diinput berdasarkan id yang dipilih (method Post),

hapusdata.php = digunakan untuk menghapus data yang telah diinput berdasarkan id (method Get),

ambildata.php = digunakan untuk mengambil data dari database untuk ditampilkan pada tabel di website(method Get).

-Bagian 3: Database Management 

Query konfigurasi database:
CREATE TABLE `makanan` (
  `id` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kehalalan` varchar(50) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `ciri` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `users` (`username`, `password`) VALUES
('admin', '123456');

ALTER TABLE `makanan`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);
COMMIT;

Pada file dibuat juga sebuah file db_con.php yang berfungsi untuk menyambungkan website dengan database :
<?php
//Variabel berikut menyesuaikan dengan database yang telah dibuat pada 000webhost.com
$sname= "localhost";
$uname= "id21680724_juan";
$password= "passwordDB123!";
$db_name= "id21680724_uas_pemweb";

$conn = mysqli_connect($sname, $uname, $password, $db_name);

// Check koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  ?>
  
Query script php:

login.php = "SELECT * FROM users WHERE username='$username' AND password='$password'"

tambahdata.php = "INSERT INTO makanan (id, nama, kehalalan, jenis, ciri) VALUES ('$id', '$nama', '$kehalalan', '$jenis', '$ciri');"

editdata.php = "UPDATE makanan SET nama='$nama', kehalalan='$kehalalan', jenis='$jenis', ciri='$ciri' WHERE id='$id';"

hapusdata.php = "DELETE FROM makanan WHERE id='$del'"

ambildata.php = tanpa filter -> "SELECT * FROM makanan", dengan filter -> "SELECT * FROM makanan WHERE jenis = '$filterJenis'"

-Bagian 4: State Management

Dibuat sebuah session pada page index.php(page login) yang digunakan untuk menyimpan pesan error ketika melakukan login seperti "User Name is Required", "Password is required", dan "Incorrect Username or Password"
session disimpan dengan variabel  $_SESSION['error'], dan akan dirender pada page login jika terjadi kesalahan, $_SESSION['error'] akan dihapus ketika user keluar dari index.html(page login).

Dibuat juga cookie menggunakan javascript dengan nama "user_id" yang berdurasi 30 hari, cookie berada pada index.php dan makanan.php,
pada index.php akan dibuat cookie baru dengan nama "user_id" ketika user sudah terverifikasi saat melakukan login melalui script login.php, dengan kode = document.cookie = "user_id=" + encodeURIComponent(data.user_id) + "; expires=" + new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";,
selain itu pada index.php juga akan dilakukan pengecekan cookie menggunakan fungsi checkCookie(), jika ditemukan cookie "user_id" maka user akan diarahkan ke makanan.php(page manajemen),
sedangkan pada makanan.php juga dilakukan pengecakan cookie menggunakan fungsi checkCookie(), jika tidak ditemukan cookie"user_id" maka user akan diarahkan ke index.php(page login) dan tidak dapat mengakses makanan.php sampai berhasil melakukan login,
jika user mengklik tombol logout pada makanan.php, cookie "user_id" akan dihapus dan user akan diarahkan ke index.php.

-Bagian Bonus: Hosting Aplikasi Web

1. Apa langkah-langkah yang Anda lakukan untuk meng-host aplikasi web Anda?
   Pertama mengakses website 000webhost.com, kemudian membuat akun baru disana, setelah itu klik tombol create website, dan memilih plan yang free,
   kemudian masukan nama website dan password website, setelah itu pilih menu upload file, dan upload semua file website yang telah dibuat ke dalam folder public_html,
   setelah itu masuk ke menu database manager dan dibuat database baru pada 000webhost.com, setelah membuat database copy nama, user, dan password database yang baru dibuat, dan pindahkan ke variabel yang ada pada db_con.php
   setelah semua telah dilakukan website dapat diakses dengan database yang berfungsi sehingga website menjadi dinamis.
   
2. Pilih penyedia hosting web yang menurut Anda paling cocok untuk aplikasi web Anda. Berikan alasan Anda.
   Saya melakukan hosting di 000webhost.com dikarenakan mudah untuk diimplementasikan dan tidak memungut biaya apapun,
   selain itu diberikan layanan database juga yang tidak dimiliki pada beberapa hostingan lain yang gratis seperti layanan hosting pada github.
 
3. Bagaimana Anda memastikan keamanan aplikasi web yang Anda host?
   Pada web yang di hosting di 000webhost.com menggunakan HTTPS dengan menggunakan sertifikat SSL untuk enkripsi data yang dikirimkan antara server dan klien. Ini penting untuk melindungi data sensitif, seperti informasi login.
 
4. Jelaskan konfigurasi server yang Anda terapkan untuk mendukung aplikasi web Anda.
   Implementasi sertifikat SSL/TLS untuk memastikan koneksi aman antara server dan pengguna,
   digunakan HTTPS untuk mengamankan data yang ditransmisikan antara klien dan server.
   Menggunakan Web Server Nginx.
