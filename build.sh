#!/bin/bash

echo "🚀 Iniciando proceso de construcción..."

# Solo generar APP_KEY si no está configurada (primera vez en nuevo entorno)
echo "🔑 Verificando APP_KEY..."
if [ -z "$APP_KEY" ]; then
    echo "⚠️  APP_KEY no encontrada en Variables de Entorno. Generando..."
    php artisan key:generate
else
    echo "✅ APP_KEY ya configurada en Variables de Entorno, omitiendo..."
fi

# Instalar dependencias de Composer
echo "📦 Instalando dependencias de PHP..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Instalar y compilar assets con pnpm
echo "🎨 Compilando assets con pnpm..."
pnpm install
pnpm build

# Optimizar configuración
echo "⚙️ Optimizando configuración..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Crear enlace simbólico para almacenamiento
echo "🔗 Configurando almacenamiento..."
php artisan storage:link

echo "✅ Proceso de construcción completado con éxito!"
