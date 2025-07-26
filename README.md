<<<<<<< HEAD

# Aplikasi Pembayaran Listrik Pascabayar

Aplikasi ini dirancang untuk membantu proses pencatatan, pengelolaan, dan pembayaran listrik pascabayar bagi pelanggan PLN. Sistem ini mencakup manajemen pelanggan, penggunaan listrik bulanan, tagihan, pembayaran, serta akses petugas dan agen.

## 📌 Fitur Utama

- ✅ Input dan manajemen data pelanggan
- ✅ Pencatatan penggunaan listrik (meter awal dan akhir)
- ✅ Perhitungan dan pembuatan tagihan otomatis
- ✅ Proses pembayaran dan pencatatan biaya admin
- ✅ Sistem login untuk admin, petugas, dan agen
- ✅ Riwayat pembayaran & status tagihan

## 🛠️ Teknologi yang Digunakan

- **Bahasa Pemrograman:** PHP
- **Framework:** CodeIgniter 3 (CI3)
- **Database:** MySQL
- **Tampilan Antarmuka:** HTML, CSS, Bootstrap
- **Server Lokal:** XAMPP / Laragon

## 🗃️ Struktur Database

Database bernama `pln_pascabayar` terdiri dari beberapa tabel utama:
- `level`, `user`, `petugas`, `agen` — untuk login & akses
- `pelanggan`, `tarif`, `penggunaan`, `tagihan`, `pembayaran` — untuk proses utama pembayaran listrik

File SQL tersedia: `pln_pascabayar.sql`

## ⚙️ Cara Install dan Menjalankan

1. **Clone repository atau unduh ZIP**
    ```bash
    git clone https://github.com/username/Aplikasi-Pembayaran-Listrik-Pascabayar.git
    ```

2. **Import database**
   - Buka **phpMyAdmin**
   - Buat database baru: `pln_pascabayar`
   - Import file `pln_pascabayar.sql`

3. **Sesuaikan konfigurasi database**
   - Buka: `application/config/database.php`
   - Edit bagian:
     ```php
     'hostname' => 'localhost',
     'username' => 'root',
     'password' => '',
     'database' => 'pln_pascabayar',
     ```

4. **Jalankan di browser**
   - Akses melalui: `http://localhost/pascabayar/public` atau `http://localhost/pascabayar/index.php` (tergantung struktur)

## 🔐 Login Default

| Role    | Username | Password |
|---------|----------|----------|
| Admin   | admin    | admin    |
| Petugas | petugas1 | 123456   |
| Agen    | agen1    | agen123  |

*Catatan: Data login bisa diubah di tabel `user`, `petugas`, atau `agen`.*

## 👨‍💻 Kontributor

- Teuku Rangga — Backend & Database

## 📄 Lisensi

Proyek ini bebas digunakan untuk kebutuhan pembelajaran, tugas akhir, atau pengembangan lebih lanjut. Jangan lupa beri kredit jika digunakan.

---

*Terima kasih telah menggunakan aplikasi ini!*
=======
# pascabayar
Tugas Serkom Skema Analisis Program
>>>>>>> 300b734e7d6bacd16c987181d5659079dfe00316
