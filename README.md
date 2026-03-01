# e-Beli Setup Instructions (XAMPP)

Aplikasi ini sekarang dikonfigurasi menggunakan **MySQL/MariaDB** (bawaan XAMPP) karena lebih stabil dan biasanya sudah aktif secara default.

## Langkah-langkah Persiapan:

### 1. Aktifkan MySQL di XAMPP
- Buka **XAMPP Control Panel**.
- Klik tombol **Start** pada baris **Apache**.
- Klik tombol **Start** pada baris **MySQL**.

### 2. Buat Database `e_beli`
- Buka browser dan pergi ke: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Klik menu **New** di sebelah kiri.
- Masukkan nama database: `e_beli`.
- Klik tombol **Create**.

### 3. Jalankan Migrasi Tabel
Buka terminal (PowerShell atau CMD) di folder `c:\xampp\htdocs\e-beli`, lalu jalankan perintah ini untuk membuat tabel otomatis:
```bash
php spark migrate
```

### 4. Jalankan Aplikasi
Akses aplikasi melalui browser di: [http://localhost/e-beli/public/](http://localhost/e-beli/public/)
(Atau jika menggunakan `php spark serve`, gunakan [http://localhost:8080/](http://localhost:8080/))

---

## Masalah Umum & Solusi:

**Error: "The required PHP extension 'mysqli' is not loaded"**
1. Buka XAMPP Control Panel.
2. Klik **Config** pada Apache -> **PHP (php.ini)**.
3. Cari `extension=mysqli` (pastikan tidak ada tanda `;` di depannya).
4. Simpan dan Restart Apache.

**Error: "Database 'e_beli' not found"**
- Pastikan Anda sudah membuat database dengan nama `e_beli` di phpMyAdmin seperti pada langkah ke-2.
