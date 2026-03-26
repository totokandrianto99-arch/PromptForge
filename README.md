<<<<<<< HEAD
# Laporan Pembuatan Website

## PromptForge AI – AI Prompt Generator

### 1. Pendahuluan

PromptForge AI adalah aplikasi web berbasis Laravel yang dibuat untuk membantu pengguna menghasilkan prompt AI secara otomatis. Aplikasi ini memungkinkan pengguna menuliskan ide singkat, kemudian sistem akan menghasilkan prompt yang lebih lengkap dan profesional menggunakan teknologi AI.

Website ini dibuat untuk mempermudah proses pembuatan prompt yang biasanya digunakan pada berbagai layanan AI seperti generator teks, generator gambar, atau chatbot.

---

### 2. Tujuan Pembuatan Sistem

Tujuan utama pembuatan website PromptForge AI adalah:

1. Mempermudah pengguna membuat prompt AI berkualitas.
2. Menghemat waktu dalam menyusun prompt yang detail.
3. Menyediakan riwayat prompt yang pernah dibuat.
4. Memberikan antarmuka sederhana agar mudah digunakan.

---

### 3. Teknologi yang Digunakan

Website ini dibangun menggunakan beberapa teknologi berikut:

Backend

* Laravel (PHP Framework)

Frontend

* Blade Template Engine
* Tailwind CSS
* Alpine.js
* JavaScript

AI API

* OpenRouter API

Database

* MySQL

Server Development

* Laragon / PHP Local Server

---

### 4. Fitur Utama Sistem

#### 1. User Authentication

Pengguna dapat:

* Register akun
* Login
* Logout
* Mengedit profil

#### 2. AI Prompt Generator

Pengguna dapat:

* Menuliskan ide atau topik prompt
* Memilih gaya prompt (creative, professional, futuristic)
* Menghasilkan prompt AI secara otomatis

#### 3. Typing Animation

Hasil prompt akan muncul dengan efek pengetikan otomatis agar terlihat seperti AI sedang menulis.

#### 4. Copy Prompt

Pengguna dapat menyalin prompt yang dihasilkan dengan satu klik.

#### 5. Prompt History

Setiap prompt yang dihasilkan akan disimpan ke database sehingga pengguna dapat melihat riwayat prompt sebelumnya.

---

### 5. Struktur Sistem

Beberapa bagian utama pada project:

app/Http/Controllers
Berisi controller yang mengatur logika aplikasi.

resources/views
Berisi tampilan halaman website menggunakan Blade.

routes/web.php
Berisi daftar route atau alamat URL aplikasi.

database/migrations
Berisi struktur tabel database.

.env
Berisi konfigurasi aplikasi seperti koneksi database dan API key.

---

### 6. Cara Menjalankan Website

Jika menerima project dalam bentuk file ZIP, lakukan langkah berikut:

#### 1. Extract File

Ekstrak file ZIP ke folder server lokal, misalnya:

laragon/www/promptforge

#### 2. Install Dependency

Buka terminal pada folder project lalu jalankan:

composer install

#### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`

Kemudian edit bagian berikut:

DB_DATABASE=promptforge
DB_USERNAME=root
DB_PASSWORD=

Tambahkan juga API key:

OPENROUTER_API_KEY=your_api_key
OPENROUTER_MODEL=google/gemma-3n-e2b-it:free

#### 4. Generate Application Key

php artisan key:generate

#### 5. Migrasi Database

php artisan migrate

#### 6. Jalankan Server

php artisan serve

Kemudian buka browser:

http://localhost:8000

---

### 7. Cara Menggunakan Website

1. Buka halaman website.
2. Daftar akun baru atau login.
3. Masuk ke halaman Dashboard.
4. Masukkan ide prompt pada kolom input.
5. Pilih gaya prompt yang diinginkan.
6. Klik tombol "Generate Prompt".
7. Sistem akan menampilkan prompt yang dihasilkan AI.
8. Gunakan tombol "Copy Prompt" untuk menyalin hasil.
9. Prompt yang dibuat akan otomatis tersimpan di riwayat.

---

### 8. Kesimpulan

Website PromptForge AI berhasil dibuat sebagai aplikasi pembuat prompt AI berbasis web. Sistem ini memanfaatkan teknologi Laravel dan integrasi API AI untuk menghasilkan prompt secara otomatis.

Dengan antarmuka yang sederhana dan fitur riwayat prompt, aplikasi ini dapat membantu pengguna dalam membuat prompt yang lebih efektif dan profesional.

---

### 9. Saran Pengembangan

Beberapa pengembangan yang dapat dilakukan di masa depan:

* Menambahkan fitur pencarian prompt.
* Menambahkan fitur penghapusan riwayat.
* Menambahkan kategori prompt.
* Menambahkan dark mode.
* Menambahkan streaming response AI seperti chatbot.

---

© PromptForge AI
=======
# PromptForge
>>>>>>> 30032fe17934a08f531c182cad6abc69b5e25acd
