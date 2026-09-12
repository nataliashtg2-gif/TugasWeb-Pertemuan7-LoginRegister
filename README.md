# Authly — Tugas Web Pertemuan 7

Sistem Login/Register menggunakan PHP Native dan file JSON.

## Fitur
- Register + validasi nama, email, password
- `filter_var()` untuk validasi email
- `password_hash()` dan `password_verify()`
- Penyimpanan `data/users.json`
- Cek duplikasi email
- Session login + dashboard terproteksi
- Logout dengan `session_destroy()`
- Sanitasi output dengan `htmlspecialchars()`
- Pesan error/sukses
- Bonus Remember Me (mengingat email, bukan password)
- Bonus Edit Profile
- Responsive CSS

## Jalankan di XAMPP
1. Salin folder ini ke `C:\xampp\htdocs\`
2. Buka XAMPP Control Panel.
3. Start **Apache**. MySQL tidak diperlukan.
4. Buka `http://localhost/TugasWeb-Pertemuan7-LoginRegister/`

## Akun demo
Email: `natalia@example.com`  
Password: `Demo12345!`

Password demo disimpan dalam bentuk hash, bukan plain text.

## Struktur
```text
TugasWeb-Pertemuan7-LoginRegister/
├── index.php
├── login.php
├── register.php
├── dashboard.php
├── profile.php
├── logout.php
├── config/functions.php
├── data/users.json
├── data/.htaccess
├── assets/css/style.css
└── README.md
```

## Pengujian
- Register akun baru
- Duplikasi email
- Email tidak valid
- Password < 8 karakter
- Login benar/salah
- Akses dashboard tanpa login
- Edit profile
- Logout
- Periksa password di JSON berupa hash
