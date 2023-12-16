# Juan Verrel Tanuwijaya, 121140072, RA, UAS Pemrograman Web 

Website (hosting) : https://data-makanan-121140072.000webhostapp.com/ 

(website akan menampilkan pesan dangerous website ketika diakses, untuk masuk kedalam website klik detail dan klik "visit this unsafe website")

Username : Admin

Password : 123456

# UAS Pemrograman Web

## Bagian 1: Client-side Programming

Dibuat website dengan dua halaman. Halaman pertama digunakan untuk login (`index.php`), dan halaman kedua untuk manajemen data makanan CRUD (`makanan.php`).

Pada halaman login, sediakan formulir untuk input login pengguna. Pada halaman manajemen, dibuat dua formulir untuk menambah dan mengedit data. Menggunakan DOM JavaScript Form akan muncul ketika tombol "Tambah Data" atau "Edit Data" diklik.
```script
function formTambah() {
                    if (!formActiveNow) {
                        document.querySelector(".tambah-data").classList.remove("hidden");
                        formActiveNow = document.querySelector(".tambah-data");
                    }
                    else if (formActiveNow != document.querySelector(".tambah-data")) {
                        document.querySelector(".tambah-data").classList.remove("hidden");
                        formActiveNow.classList.add("hidden");
                        formActiveNow = document.querySelector(".tambah-data");
                    } else {
                        formActiveNow.classList.add("hidden");
                        formActiveNow = null;
                    }
                }

                function formEdit() {
                    if (!formActiveNow) {
                        document.querySelector(".edit-data").classList.remove("hidden");
                        formActiveNow = document.querySelector(".edit-data");
                    }
                    else if (formActiveNow != document.querySelector(".edit-data")) {
                        document.querySelector(".edit-data").classList.remove("hidden");
                        formActiveNow.classList.add("hidden");
                        formActiveNow = document.querySelector(".edit-data");
                    } else {
                        formActiveNow.classList.add("hidden");
                        formActiveNow = null;
                    }
                }
```

Formulir pada halaman manajemen memiliki lima input dengan tipe yang berbeda, yaitu teks, radio, pilihan, dan checkbox. Setelah input data, data akan ditampilkan dalam tabel yang dilengkapi dengan fitur filter berdasarkan jenis makanan dan fitur penghapusan data.

Sebelum memproses data input ke file PHP, validasi data dengan JavaScript menggunakan fungsi `validasiForm()` untuk memastikan tidak ada input yang kosong. Tampilkan peringatan di website jika ada input yang kosong.
```script
function validasiForm() {
                    // Ambil nilai dari setiap input
                    var id = document.getElementsByName("id")[0].value;
                    var nama = document.getElementsByName("nama")[0].value;
                    var kehalalan = document.querySelector('input[name="kehalalan"]:checked');
                    var jenis = document.getElementById("jenis").value;
                    var ciri = document.querySelectorAll('input[name="ciri[]"]:checked');

                    // Validasi setiap input
                    if (id.trim() === "") {
                        alert("Id Makanan harus diisi");
                        return false;
                    }

                    if (nama.trim() === "") {
                        alert("Nama harus diisi");
                        return false;
                    }

                    if (!kehalalan) {
                        alert("Kehalalan harus dipilih");
                        return false;
                    }

                    if (jenis === "-- Pilih Jenis --") {
                        alert("Jenis Makanan harus dipilih");
                        return false;
                    }

                    if (ciri.length === 0) {
                        alert("Minimal harus memilih satu Ciri Makanan");
                        return false;
                    }

                    // Jika semua validasi berhasil
                    return true;
                }
```

## Bagian 2: Server-side Programming

Dibuat lima file PHP utama untuk menangani proses data antara website dan database:

1. `login.php`: Verifikasi pengguna untuk login dan akses ke halaman manajemen (metode POST).
2. `tambahdata.php`: Tambahkan input data makanan dari website ke database (metode POST).
3. `editdata.php`: Perbarui data yang sudah dimasukkan berdasarkan ID yang dipilih (metode POST).
4. `hapusdata.php`: Hapus data berdasarkan ID yang diberikan (metode GET).
5. `ambildata.php`: Ambil data dari database untuk ditampilkan di website (metode GET).

## Bagian 3: Manajemen Database

Query konfigurasi database:

```sql
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

INSERT INTO `users` (`username`, `password`) VALUES ('admin', '123456');

ALTER TABLE `makanan`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);
COMMIT;
```

## Query Script PHP:

### login.php
```php
$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
```
### tambahdata.php
```php
$sql = "INSERT INTO makanan (id, nama, kehalalan, jenis, ciri) VALUES ('$id', '$nama', '$kehalalan', '$jenis', '$ciri')";
```
### editdata.php
```php
$sql = "UPDATE makanan SET nama='$nama', kehalalan='$kehalalan', jenis='$jenis', ciri='$ciri' WHERE id='$id'";
```
### hapusdata.php
```php
$sql = "DELETE FROM makanan WHERE id='$del'";
```
### ambildata.php
```php
// Tanpa filter
$sql = "SELECT * FROM makanan";
// Dengan filter
$sql = "SELECT * FROM makanan WHERE jenis = '$filterJenis'";
```
### Bagian 4: State Management

Dibuat sebuah session pada page index.php(page login) yang digunakan untuk menyimpan pesan error ketika melakukan login seperti "User Name is Required", "Password is required", dan "Incorrect Username or Password"

session disimpan dengan variabel  $_SESSION['error'], dan akan dirender pada page login jika terjadi kesalahan, $_SESSION['error'] akan dihapus ketika user keluar dari index.html(page login).
```php
<?php if (isset($_SESSION['error'])) { ?>
            <p class="error">
                <?php echo $_SESSION['error']; ?>
            </p>
            <?php unset($_SESSION['error']); ?>
        <?php } ?>
```

Dibuat juga cookie menggunakan javascript dengan nama "user_id" yang berdurasi 30 hari, cookie berada pada index.php dan makanan.php,
pada index.php akan dibuat cookie baru dengan nama "user_id" ketika user sudah terverifikasi saat melakukan login melalui script login.php, dengan kode:
```script
document.addEventListener("DOMContentLoaded", function () {
            const loginForm = document.querySelector('form');

            loginForm.addEventListener('submit', function (event) {
                event.preventDefault();

                const username = document.getElementsByName("username")[0].value;
                const password = document.getElementsByName("password")[0].value;

                fetch('login.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: new URLSearchParams({
                        'username': username,
                        'password': password,
                    }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Set cookie dan redirect
                            document.cookie = "user_id=" + encodeURIComponent(data.user_id) + "; expires=" + new Date(new Date().getTime() + 30 * 24 * 60 * 60 * 1000).toUTCString() + "; path=/";
                            window.location.href = 'makanan.php';
                        } else {
                            // Jika gagal
                            window.location.href = 'index.php';
                        }
                    });
            });
        });
```

selain itu pada index.php juga akan dilakukan pengecekan cookie menggunakan fungsi checkCookie(), jika ditemukan cookie "user_id" maka user akan diarahkan ke makanan.php(page manajemen),
```script
function checkCookie() {
            var userIdCookie = getCookie('user_id');
            if (userIdCookie) {
                window.location.href = 'makanan.php';
            }
        }

        function getCookie(name) {
            var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }
```

sedangkan pada makanan.php juga dilakukan pengecakan cookie menggunakan fungsi checkCookie(), jika tidak ditemukan cookie"user_id" maka user akan diarahkan ke index.php(page login) dan tidak dapat mengakses makanan.php sampai berhasil melakukan login,
```script
function checkCookie() {
                    var userIdCookie = getCookie('user_id');
                    if (!userIdCookie) {
                        window.location.href = 'index.php';
                    }
                }

                function getCookie(name) {
                    var match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
                    return match ? match[2] : null;
                }
```

jika user mengklik tombol logout pada makanan.php akan dipanggil fungsi "logout()" dimana cookie "user_id" akan dihapus dan user akan diarahkan ke index.php.
```script
 function logout() {
                    document.cookie = 'user_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                    window.location.href = 'index.php';
                }
```

### Bagian Bonus: Hosting Aplikasi Web

## 1. Apa langkah-langkah yang Anda lakukan untuk meng-host aplikasi web Anda?
1. Akses 000webhost.com.
2. Buat akun baru.
3. Klik "Create Website" dan pilih plan yang free.
4. Masukkan nama website dan password.
5. Pilih menu "Upload File" dan upload semua file website ke folder public_html.
6. Masuk ke menu "Database Manager", buat database baru, catat nama, user, dan password database, dan update variabel di db_con.php.
7. Website dapat diakses dengan database yang berfungsi.
   
## 2. Pilih penyedia hosting web yang menurut Anda paling cocok untuk aplikasi web Anda. Berikan alasan Anda.
   Saya melakukan hosting di 000webhost.com dikarenakan mudah untuk diimplementasikan dan tidak memungut biaya apapun,
   selain itu diberikan layanan database juga yang tidak dimiliki pada beberapa hostingan lain yang gratis seperti layanan hosting pada github.
 
## 3. Bagaimana Anda memastikan keamanan aplikasi web yang Anda host?
1. Implementasi HTTPS dengan sertifikat SSL untuk enkripsi data.
2. Penggunaan HTTPS untuk melindungi data sensitif selama transmisi.
3. Penggunaan Web Server Nginx.
4. Menggunakan cookies ketiak login untuk mencegah user yang belum login mengakses page manajemen.
 
## 4. Jelaskan konfigurasi server yang Anda terapkan untuk mendukung aplikasi web Anda.
1. Implementasi sertifikat SSL/TLS untuk koneksi aman.
2. Penggunaan HTTPS untuk enkripsi data transmisi.
3. Menggunakan Web Server Nginx.
