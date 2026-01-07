---

<div align="center">

# Sistem Inventaris Gudang

### PT Rizky Badai

<img src="https://readme-typing-svg.demolab.com?font=Inter&size=22&pause=900&color=6366F1&center=true&vCenter=true&width=760&lines=Sistem+Inventaris+Gudang+Berbasis+Web;Laravel+%2B+React+%2B+Docker;Clean+Architecture+%7C+Scalable;Initial+Setup+untuk+Uji+Praktik" />

<br/>

<img src="https://img.shields.io/badge/Laravel-REST%20API-ef4444?style=for-the-badge&logo=laravel&logoColor=white"/>
<img src="https://img.shields.io/badge/React-Frontend-3b82f6?style=for-the-badge&logo=react&logoColor=white"/>
<img src="https://img.shields.io/badge/Docker-Environment-0ea5e9?style=for-the-badge&logo=docker&logoColor=white"/>
<img src="https://img.shields.io/badge/MySQL-Database-f59e0b?style=for-the-badge&logo=mysql&logoColor=white"/>

<br/>

<img src="https://img.shields.io/github/actions/workflow/status/ahr-ahr/sistem-inventaris-gudang-pt-rizky-badai/ci.yml?style=flat-square&label=CI%2FCD"/>
<img src="https://img.shields.io/badge/Status-Initial%20Setup-facc15?style=flat-square"/>
<img src="https://img.shields.io/badge/Scope-Uji%20Praktik-22c55e?style=flat-square"/>

<br/><br/>

<img src="https://komarev.com/ghpvc/?username=ahr-ahr&label=Repository%20Views&color=6366F1&style=flat" />

</div>

---

## Tentang Project

**Sistem Inventaris Gudang** adalah aplikasi web buat ngatur data barang gudang biar rapi, terpusat, dan gampang dikembangin.
Project ini fokus ke **arsitektur yang bersih**, **backend dan frontend nyambung rapi**, serta **environment yang konsisten** pakai Docker.

Repo ini masih di tahap **initial setup** dan dipakai sebagai pendukung **Uji Praktik (Uprak)**.

---

## Kenapa Project Ini Dibuat?

Project ini lahir dari masalah yang sering kejadian di gudang dan di workflow development.

**Catatan manual itu ribet**
Data gampang ke-skip, susah dilacak, dan rawan salah input.

**Data kepisah bikin nggak efisien**
Barang masuk, keluar, dan stok sering nyebar di banyak tempat.

**Project harus siap tumbuh**
Struktur dari awal disiapin biar gampang nambah fitur tanpa bongkar total.

**Environment beda = masalah klasik**
Docker dipakai biar semua developer jalan di setup yang sama, tanpa drama.

---

## Tech Stack

| Layer       | Teknologi               |
| ----------- | ----------------------- |
| Backend     | Laravel (REST API)      |
| Frontend    | React                   |
| Database    | MySQL 8                 |
| Environment | Docker & Docker Compose |

---

## Arsitektur Sistem (Animated)

<div align="center">

<svg width="760" height="300" viewBox="0 0 760 300" xmlns="http://www.w3.org/2000/svg">
  <style>
    .box {
      fill:#0b1220;
      stroke:#6366F1;
      stroke-width:2;
      rx:12;
    }
    .text {
      fill:#E5E7EB;
      font-size:14px;
      font-family:Inter, Arial, Helvetica, sans-serif;
    }
    .arrow {
      stroke:#9CA3AF;
      stroke-width:2;
      fill:none;
      stroke-dasharray:6;
      animation: dash 2s linear infinite;
      marker-end:url(#arrowhead);
    }
    @keyframes dash {
      to { stroke-dashoffset: -12; }
    }
    .subtitle {
      fill:#9CA3AF;
      font-size:12px;
    }
  </style>

  <defs>
    <marker id="arrowhead" markerWidth="10" markerHeight="7" refX="10" refY="3.5" orient="auto">
      <polygon points="0 0, 10 3.5, 0 7" fill="#9CA3AF"/>
    </marker>
  </defs>

  <rect x="40" y="110" width="200" height="80" class="box"/>
  <text x="105" y="145" class="text">Frontend</text>
  <text x="120" y="165" class="subtitle">React</text>

  <rect x="280" y="110" width="200" height="80" class="box"/>
  <text x="350" y="145" class="text">Backend</text>
  <text x="335" y="165" class="subtitle">Laravel REST API</text>

  <rect x="520" y="110" width="200" height="80" class="box"/>
  <text x="585" y="145" class="text">Database</text>
  <text x="590" y="165" class="subtitle">MySQL 8</text>

  <path d="M240 150 H280" class="arrow"/>
  <path d="M480 150 H520" class="arrow"/>
</svg>

</div>

Frontend manggil backend lewat REST API, lalu backend ngurus data ke database.
Semua service dijalankan di satu environment Docker.

---

## Struktur Repository

<div align="center">

<img src="https://img.shields.io/badge/Architecture-Monorepo-6366F1?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Backend-Laravel-ef4444?style=for-the-badge&logo=laravel&logoColor=white"/>
<img src="https://img.shields.io/badge/Frontend-React-3b82f6?style=for-the-badge&logo=react&logoColor=white"/>
<img src="https://img.shields.io/badge/Environment-Docker-0ea5e9?style=for-the-badge&logo=docker&logoColor=white"/>

</div>

<br/>

<div align="center">

<svg width="760" height="260" viewBox="0 0 760 260" xmlns="http://www.w3.org/2000/svg">
  <style>
    .box {
      fill:#0b1220;
      stroke:#6366F1;
      stroke-width:2;
      rx:14;
    }
    .title {
      fill:#E5E7EB;
      font-size:15px;
      font-family:Inter, Arial;
    }
    .sub {
      fill:#94a3b8;
      font-size:12px;
      font-family:Inter, Arial;
    }
    .line {
      stroke:#6366F1;
      stroke-width:2;
      stroke-dasharray:6;
    }
  </style>

  <!-- Root -->

  <rect x="200" y="20" width="400" height="60" class="box"/>
  <text x="230" y="45" class="title">SISTEM-INVENTARIS-GUDANG-PT-RIZKY-BADAI</text>
  <text x="330" y="65" class="sub">Monorepo Structure</text>

  <!-- Lines -->

  <line x1="380" y1="80" x2="140" y2="120" class="line"/>
  <line x1="380" y1="80" x2="380" y2="120" class="line"/>
  <line x1="380" y1="80" x2="620" y2="120" class="line"/>

  <!-- Backend -->

  <rect x="40" y="120" width="200" height="70" class="box"/>
  <text x="90" y="150" class="title">backend/</text>
  <text x="70" y="170" class="sub">Laravel REST API</text>

  <!-- Frontend -->

  <rect x="280" y="120" width="200" height="70" class="box"/>
  <text x="330" y="150" class="title">frontend/</text>
  <text x="315" y="170" class="sub">React Application</text>

  <!-- Docker -->

  <rect x="520" y="120" width="200" height="70" class="box"/>
  <text x="545" y="150" class="title">docker-compose.yml</text>
  <text x="545" y="170" class="sub">Service Orchestration</text>

</svg>

</div>

---

## Getting Started

Semua yang kamu butuhin buat jalanin project ini ada di bawah.
Kalau poin-poin ini aman, project bisa langsung gas tanpa drama.

### Prasyarat

<table>
  <tr>
    <td><strong>Git</strong></td>
    <td>buat clone repo & ngatur versi kode</td>
  </tr>
  <tr>
    <td><strong>Docker</strong></td>
    <td>biar environment backend & frontend konsisten di semua device</td>
  </tr>
  <tr>
    <td><strong>Docker Compose</strong></td>
    <td>buat ngejalanin semua service sekaligus dengan satu perintah</td>
  </tr>
</table>

> Catatan:
> Kalau Docker udah ke-install, biasanya Docker Compose otomatis ikut.

---

### Quick Check

Pastikan semuanya udah siap sebelum lanjut:

```
git --version
docker --version
docker compose version
```

Kalau semua command di atas jalan tanpa error, berarti environment kamu aman.

---

### Clone Repo

```
git clone https://github.com/USERNAME/sistem-inventaris-gudang-pt-rizky-badai.git
cd sistem-inventaris-gudang-pt-rizky-badai
```

---

### Install Dependency Frontend

```
docker run --rm \
  -v "$(pwd)/frontend:/app" \
  -w /app \
  node:24 \
  npm install
```

### Install Dependency Backend

```
docker run --rm \
  -p 8000:8000 \
  -v "$(pwd)/backend:/var/www" \
  -w /var/www \
  composer \
  composer install
```

---

### Jalanin Project

```
docker compose up
```

---

### Akses Lokal

| Service     | URL                                            |
| ----------- | ---------------------------------------------- |
| Backend API | [http://localhost:8000](http://localhost:8000) |
| Frontend    | [http://localhost:5173](http://localhost:5173) |

---
## GitHub Stats

<div align="center">

<img src="https://github-profile-summary-cards.vercel.app/api/cards/profile-details?username=ahr-ahr&theme=tokyonight" />
<br/>
<img src="https://github-profile-summary-cards.vercel.app/api/cards/repos-per-language?username=ahr-ahr&theme=tokyonight" />
<img src="https://github-profile-summary-cards.vercel.app/api/cards/most-commit-language?username=ahr-ahr&theme=tokyonight" />

</div>

---

## Progress

<div align="center">

<img src="https://img.shields.io/badge/Fase-Foundation%20Selesai-22c55e?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Status-Siap%20Masuk%20Core-facc15?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Mode-Scale%20Ready-6366F1?style=for-the-badge"/>

</div>

<br/>

<div align="center">

<svg width="720" height="200" viewBox="0 0 720 200" xmlns="http://www.w3.org/2000/svg">
  <style>
    .track { fill:#1e293b; }
    .bar {
      fill:url(#grad);
      animation: load 2.5s ease-out forwards;
    }
    .glow {
      filter:url(#blur);
      animation: pulse 1.8s infinite;
    }
    .text { fill:#E5E7EB; font-size:16px; font-family:Inter, Arial; }
    .sub { fill:#94a3b8; font-size:13px; }
    @keyframes load {
      from { width:0; }
      to { width:360px; }
    }
    @keyframes pulse {
      0% { opacity:.4; }
      50% { opacity:.9; }
      100% { opacity:.4; }
    }
  </style>

  <defs>
    <linearGradient id="grad" x1="0" y1="0" x2="1" y2="0">
      <stop offset="0%" stop-color="#22c55e"/>
      <stop offset="100%" stop-color="#4ade80"/>
    </linearGradient>
    <filter id="blur">
      <feGaussianBlur stdDeviation="5"/>
    </filter>
  </defs>

  <!-- Track -->

  <rect x="20" y="40" width="680" height="28" rx="14" class="track"/>

  <!-- Bar (53%) -->

  <rect x="20" y="40" width="360" height="28" rx="14" class="bar"/>
  <rect x="20" y="40" width="360" height="28" rx="14" class="bar glow"/>

  <!-- Text -->

<h2 x="20" y="105" class="text">Progress Project</h2> <h2 x="20" y="132" class="sub">
53% — foundation, setup, arsitektur, dan CI/CD sudah beres </h2> </svg>

</div>

---

## Roadmap

<div align="center">

<img src="https://img.shields.io/badge/Fase%201-Foundation-22c55e?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Fase%202-Core%20System-facc15?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Fase%203-Stock%20Flow-6366F1?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Fase%204-Reporting-f59e0b?style=for-the-badge"/>

</div>

<br/>

<div align="center">

<svg width="760" height="240" viewBox="0 0 760 240" xmlns="http://www.w3.org/2000/svg">
  <style>
    .line {
      stroke:#6366F1;
      stroke-width:4;
      stroke-dasharray:10;
      animation: flow 3s linear infinite;
    }
    .dot { fill:#6366F1; }
    .dot-done { fill:#22c55e; }
    .dot-active {
      fill:#facc15;
      animation: pulse 1.6s infinite;
    }
    .text {
      fill:#E5E7EB;
      font-size:14px;
      font-family:Inter, Arial;
    }
    .sub {
      fill:#94a3b8;
      font-size:12px;
    }
    @keyframes flow {
      to { stroke-dashoffset:-20; }
    }
    @keyframes pulse {
      0% { r:7; opacity:.5; }
      50% { r:11; opacity:1; }
      100% { r:7; opacity:.5; }
    }
  </style>

  <!-- Line -->

  <line x1="80" y1="120" x2="680" y2="120" class="line"/>

  <!-- Foundation -->

  <circle cx="80" cy="120" r="7" class="dot-done"/>
  <text x="40" y="155" class="text">Foundation</text>
  <text x="35" y="175" class="sub">Selesai</text>

  <!-- Core -->

  <circle cx="280" cy="120" r="9" class="dot-active"/>
  <text x="245" y="155" class="text">Core System</text>
  <text x="235" y="175" class="sub">Fokus berikutnya</text>

  <!-- Stock Flow -->

  <circle cx="480" cy="120" r="7" class="dot"/>
  <text x="445" y="155" class="text">Stock Flow</text>

  <!-- Reporting -->

  <circle cx="680" cy="120" r="7" class="dot"/>
  <text x="645" y="155" class="text">Reporting</text>
</svg>

</div>

---

## Team

<div align="center">
<a href="https://github.com/ahr-ahr" target="_blank" style="text-decoration:none;">
  <div style="
    display:inline-block;
    width:260px;
    margin:12px;
    padding:20px;
    border-radius:16px;
    background:#0b1220;
    border:1px solid #6366F1;
    transition: transform .2s ease, box-shadow .2s ease;
  "
  onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(99,102,241,.35)'"
  onmouseout="this.style.transform='none'; this.style.boxShadow='none'"
  >
    <img src="https://avatars.githubusercontent.com/ahr-ahr" width="96" style="border-radius:50%;" />
    <h3 style="margin:12px 0 6px 0;">Ahmad Haikal Rizal</h3>

<img src="https://img.shields.io/badge/Backend%20%26%20DevOps-6366F1?style=flat-square&logo=laravel&logoColor=white"/>

<div style="margin-top:14px;">
  <a href="https://github.com/ahr-ahr">
    <img src="https://img.shields.io/badge/GitHub-000?style=flat-square&logo=github&logoColor=white"/>
  </a>
  <a href="https://twitter.com/USERNAME">
    <img src="https://img.shields.io/badge/Twitter-1DA1F2?style=flat-square&logo=twitter&logoColor=white"/>
  </a>
  <a href="https://instagram.com/USERNAME">
    <img src="https://img.shields.io/badge/Instagram-E4405F?style=flat-square&logo=instagram&logoColor=white"/>
  </a>
  <a href="https://facebook.com/USERNAME">
    <img src="https://img.shields.io/badge/Facebook-1877F2?style=flat-square&logo=facebook&logoColor=white"/>
  </a>
</div>

  </div>
</a>

<a href="https://github.com/USERNAME" target="_blank" style="text-decoration:none;">
  <div style="
    display:inline-block;
    width:260px;
    margin:12px;
    padding:20px;
    border-radius:16px;
    background:#0b1220;
    border:1px solid #22c55e;
    transition: transform .2s ease, box-shadow .2s ease;
  "
  onmouseover="this.style.transform='translateY(-6px)'; this.style.boxShadow='0 12px 24px rgba(34,197,94,.35)'"
  onmouseout="this.style.transform='none'; this.style.boxShadow='none'"
  >
    <img src="https://avatars.githubusercontent.com/USERNAME" width="96" style="border-radius:50%;" />
    <h3 style="margin:12px 0 6px 0;">Alifian Putra Wijaya</h3>
<img src="https://img.shields.io/badge/Frontend-22c55e?style=flat-square&logo=react&logoColor=white"/>

<div style="margin-top:14px;">
  <a href="https://github.com/USERNAME">
    <img src="https://img.shields.io/badge/GitHub-000?style=flat-square&logo=github&logoColor=white"/>
  </a>
  <a href="https://twitter.com/USERNAME">
    <img src="https://img.shields.io/badge/Twitter-1DA1F2?style=flat-square&logo=twitter&logoColor=white"/>
  </a>
  <a href="https://instagram.com/USERNAME">
    <img src="https://img.shields.io/badge/Instagram-E4405F?style=flat-square&logo=instagram&logoColor=white"/>
  </a>
  <a href="https://facebook.com/USERNAME">
    <img src="https://img.shields.io/badge/Facebook-1877F2?style=flat-square&logo=facebook&logoColor=white"/>
  </a>
</div>

  </div>
</a>

</div>

---

## Catatan

<div align="center">

<img src="https://img.shields.io/badge/Context-Ujian%20Praktik-6366F1?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Stage-Foundation-22c55e?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Focus-Architecture%20%26%20Integration-facc15?style=for-the-badge"/>

</div>

<br/>

<div align="center">

<svg width="720" height="120" viewBox="0 0 720 120" xmlns="http://www.w3.org/2000/svg">
  <style>
    .box {
      fill:#0b1220;
      stroke:#6366F1;
      stroke-width:2;
      rx:16;
    }
    .text {
      fill:#E5E7EB;
      font-size:15px;
      font-family:Inter, Arial;
    }
    .sub {
      fill:#94a3b8;
      font-size:13px;
    }
  </style>

  <rect x="20" y="20" width="680" height="80" class="box"/>

  <text x="40" y="55" class="text">
    Project ini dibuat sebagai bagian dari Ujian Praktik (Uprak).
  </text>
  <text x="40" y="78" class="sub">
    Fokus masih di setup, arsitektur, dan integrasi — bukan fitur produksi.
  </text>
</svg>

</div>

---

## License

<div align="center">

<img src="https://img.shields.io/badge/License-Academic%20Use-22c55e?style=for-the-badge"/>
<img src="https://img.shields.io/badge/Commercial-Not%20Allowed-f87171?style=for-the-badge"/>

</div>

<br/>

<div align="center">

<svg width="720" height="110" viewBox="0 0 720 110" xmlns="http://www.w3.org/2000/svg">
  <style>
    .box {
      fill:#020617;
      stroke:#22c55e;
      stroke-width:2;
      rx:16;
    }
    .text {
      fill:#E5E7EB;
      font-size:14px;
      font-family:Inter, Arial;
    }
  </style>

  <rect x="20" y="20" width="680" height="70" class="box"/>

  <text x="40" y="62" class="text">
    Project ini dipakai untuk pembelajaran dan kebutuhan akademik.
  </text>
</svg>

</div>

---