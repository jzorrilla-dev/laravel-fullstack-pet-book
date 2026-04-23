import "./bootstrap";
import Alpine from "alpinejs";
import zxcvbn from "zxcvbn";

// Make zxcvbn available globally
window.zxcvbn = zxcvbn;

// Inicializar Alpine.js
window.Alpine = Alpine;
Alpine.start();
