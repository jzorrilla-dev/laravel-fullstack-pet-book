#!/bin/bash

# Script de construcción para Render.com

echo "🚀 Iniciando proceso de construcción..."

# Copiar .env.example a .env
echo "📝 Configurando variables de entorno..."
cp .env.example .env

# Generar clave de aplicación
echo "🔑 Generando clave de aplicación..."
php artisan key:generate --force

# Instalar dependencias de Composer
echo "📦 Instalando dependencias de PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Instalar dependencias de NPM y compilar assets
echo "🎨 Compilando assets..."
npm ci
npm run build

# Optimizar configuración
echo "⚙️ Optimizando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache


# Crear enlace simbólico para almacenamiento
echo "🔗 Configurando almacenamiento..."
php artisan storage:link

echo "✅ Proceso de construcción completado con éxito!"