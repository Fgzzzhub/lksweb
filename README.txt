Portal Destinasi & Kearifan Lokal Tegal

Cara Install (XAMPP/Laragon)
1) Copy folder project ke web root (contoh: C:\xampp\htdocs\lksv1).
2) Buat database MySQL bernama "tegal_portal".
3) Import file database.sql melalui phpMyAdmin atau CLI.
4) Edit file app/config.php:
   - DB_HOST, DB_PORT, DB_NAME, DB_USER, DB_PASS
   - BASE_URL kosong untuk built-in server, atau /lksv1 untuk Apache
5) Jalankan PHP built-in server dari folder project:
   - php -S localhost:8000 -t .
6) Pastikan folder assets/uploads bisa ditulis oleh server.
7) Buka browser: http://localhost:8000/

Akun Admin
- Username: admin
- Password: admin123

Catatan
- Semua asset (Bootstrap, ikon, font) sudah tersimpan lokal.
- Form kontak menyimpan data ke tabel messages.
- CRUD admin menggunakan CSRF token sederhana.
