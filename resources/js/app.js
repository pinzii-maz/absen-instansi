import "./bootstrap";

// Import file CSS utama (untuk Tailwind) dan file login.css kustom Anda
import "../css/app.css";
import "../css/login.css"; // <-- Tambahkan baris ini

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();
