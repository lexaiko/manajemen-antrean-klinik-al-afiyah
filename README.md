# 🏥 Manajemen Antrean Klinik Al-Afiyah

**Manajemen Antrean Klinik Al-Afiyah** adalah aplikasi web berbasis Laravel yang dirancang untuk mendigitalisasi proses antrean pasien, pendaftaran, dan penjadwalan dokter di Klinik Al-Afiyah. Proyek ini bertujuan meningkatkan efisiensi layanan serta memberikan pengalaman yang lebih terstruktur dan profesional bagi pasien maupun petugas medis.

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11-red?style=flat&logo=laravel">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38bdf8?style=flat&logo=tailwindcss">
  <img src="https://img.shields.io/badge/PHP-8.3-777bb4?style=flat&logo=php">
  <img src="https://img.shields.io/badge/MySQL-8-blue?style=flat&logo=mysql">
  <img src="https://img.shields.io/github/license/lexaiko/manajemen-antrean-klinik-al-afiyah">
</p>

---

## ✨ Fitur Utama

- ✅ **Login Multi-Role**: Admin & petugas dengan hak akses terpisah  
- 📋 **Manajemen Data Pasien**: Tambah, ubah, dan lihat riwayat kunjungan  
- 🩺 **Jadwal Dokter Dinamis**: Tambah dan kelola jadwal praktik dokter  
- 📊 **Dashboard Statistik**: Laporan harian jumlah pasien & antrean  
- 🔔 **Pemanggilan Antrean**: Sistem antrean real-time (manual/semi-otomatis)  
- 💡 **UI Responsif**: Tampilan clean, modern, dan mobile-friendly  

---

## 🛠️ Stack Teknologi

| Layer       | Teknologi                    |
|-------------|------------------------------|
| Backend     | Laravel 11, PHP 8.3          |
| Frontend    | Tailwind CSS, Flowbite UI    |
| Database    | MySQL                        |
| Tools       | Laravel Vite, Eloquent ORM   |
| Dev Tools   | VS Code, Postman, Git        |

---

## 🚀 Instalasi Lokal

```bash
# 1. Clone repo
git clone https://github.com/lexaiko/manajemen-antrean-klinik-al-afiyah.git
cd manajemen-antrean-klinik-al-afiyah

# 2. Install dependency
composer install
npm install && npm run dev

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Atur koneksi database lalu migrate
php artisan migrate --seed

# 5. Jalankan server
php artisan serve
