#!/bin/bash
# entrypoint.sh: Script que se ejecuta al iniciar el contenedor.

echo "Esperando 5 segundos para asegurar que la BBDD de Render esté activa..."
# Esta pausa es crucial para evitar errores de conexión si la BBDD de Render 
# (que es un servicio separado) aún se está inicializando.
sleep 5

echo "Ejecutando migraciones de Laravel..."
# Usamos 'php' porque el PATH ya debería estar configurado.
php artisan migrate --force

# Iniciar el proceso principal del contenedor (Supervisor)
echo "Iniciando servicios Nginx y PHP-FPM con Supervisor..."
# El comando 'exec' reemplaza el proceso actual del script con el supervisor, 
# asegurando que las señales de apagado de Docker funcionen correctamente.
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
