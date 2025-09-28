# Pomodoro Timer — Laravel 10 + Vanilla JS + Bootstrap 5

A lightweight, production-ready Pomodoro timer built with **Laravel 10** (routing & view), **Vanilla JavaScript** (logic timer 100% client-side), dan **Bootstrap 5** (UI responsif). Tidak membutuhkan database atau backend logic —.

---

## 1) Project Overview

### Latar Belakang & Tujuan
Banyak pengguna kesulitan menjaga fokus dan ritme kerja: mudah terdistraksi, sulit mengukur waktu efektif, dan tidak ada umpan balik cepat ketika berpindah aktivitas. **Teknik Pomodoro** menawarkan siklus fokus singkat yang diikuti istirahat terjadwal untuk meningkatkan konsentrasi dan mencegah kejenuhan.

**Tujuan proyek ini:**
- Menyediakan **timer Pomodoro** yang sederhana, responsif, dan dapat langsung dipakai.
- Menghilangkan hambatan infrastruktur (**no DB, no backend jobs**) agar mudah dideploy di cPanel.
- Memberi **feedback jelas** (progress bar, toast, judul tab, beep, notifikasi desktop) untuk mendukung habit-forming.

### Permasalahan Spesifik & Relevansi
- **Context switching** dan **prokrastinasi** mengurangi deep work.
- Aplikasi Pomodoro yang berat sering memerlukan setup server/DB.
- Pengguna shared hosting butuh **aplikasi ringan** yang bisa jalan dengan **PHP 8.2+** tanpa dependency rumit.

### Pendekatan
- **Arsitektur minimalis**: Laravel hanya untuk routing & rendering **1 Blade** (UI). Seluruh logika timer berjalan di browser (JS).
- **Realtime feedback**: progress bar Bootstrap, judul tab menampilkan countdown, **Web Audio API** untuk beep, **Notifications API** (opsional) ketika sesi berakhir.
- **Kemudahan deploy**: cukup arahkan **Document Root** ke folder `public/`, pastikan PHP 8.2+, dan atur `index.php` jika app root berada di luar web root.

---

## 2) Technologies Used
- **PHP 8.2+ / Laravel 10**
  - Pada Routing dan Blade untuk view.
  - Laravel memudahkan struktur proyek, standar `.htaccess` untuk routing, dan kompatibel dengan cPanel.
- **Vanilla JavaScript (ES6)**
  - State machine Pomodoro (`focus`, `short`, `long`), timer `setInterval`, kontrol start/pause/reset/skip.
  - Beban kecil & mudah diintegrasi.
- **Bootstrap 5.3 + Bootstrap Icons (CDN)**
  - Komponen UI (pills, button, progress, toast) yang konsisten & responsif.
  - Styling cepat, tidak butuh build tool.
- **Web APIs**
  - **Web Audio API**: menghasilkan bunyi “beep” tanpa file audio eksternal.
  - **Web Notifications API**: notifikasi desktop ketika sesi berakhir (dengan izin pengguna).
  - **localStorage**: menyimpan pengaturan durasi, auto-start, dsb. agar persist di browser.
---

## 3) Features
- **Mode Pomodoro**: `Focus`, `Short Break`, `Long Break`.
- **Auto-cycle**: setelah `N` fokus (konfigurabel), otomatis masuk `Long Break`.
- **Kontrol**: Start/Pause, Reset (hard reset), Next.
- **Progress & Status**:
  - Progress bar Bootstrap.
  - Judul tab menampilkan countdown secara real time.
  - **Toast** ketika sesi berakhir (dengan pesan kontekstual).
- **Notifikasi & Audio**:
  - **Beep** via Web Audio API.
  - **Notifikasi desktop** opsional (dengan permission).
- **Preferensi**:
  - Durasi `Focus/Short/Long`, `Cycles → Long`, `Auto-start next`, `Beep`, `Desktop notification` → disimpan di `localStorage`.
- **Akses Cepat**:
  - Hotkeys: **Space** (Start/Pause), **→** (Skip).
- **UI/UX**:
  - Bootstrap 5, nav pills untuk ganti mode, badge warna sesuai mode, cards layout.
  - Simple dengan button yang mudah dipahami.
  - Responsive (Desktop/Mobile).
---

## 4) AI Support explanation
- **Draft awal & refactor** logika timer.
- **Perbaikan bug cepat** (mis. button reset tidak mengubah waktu/cycle, pemanggilan fungsi yang tidak ada, dsb.).
---

## Instalation
### 1. Clone the Repository
```sh
git clone https://github.com/yourusername/unibookstore.git
cd unibookstore
```

### 2. Install Dependencies
```sh
composer install
npm install
```

### 3. Configure the Environment
Copy the `.env.example` file and update database credentials:
```sh
cp .env.example .env
```
Edit `.env` and configure your database connection:
```
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Run Migrations & Seeders
```sh
php artisan migrate --seed
```

### 5. Serve the Application
```sh
php artisan serve
```
Then, open `http://127.0.0.1:8000` in your browser.
