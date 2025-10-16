FROM php:8.2-fpm

# Argumentos para configuración
ARG user=laravel
ARG uid=1000

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    nodejs \
    npm \
    nginx \
    supervisor

# Limpiar cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd

# Obtener Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario del sistema
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Establecer directorio de trabajo
WORKDIR /var/www

# Copiar código de la aplicación
COPY . /var/www

# Establecer permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache


# Instalar dependencias de Composer
RUN composer install --optimize-autoloader --no-dev

# Instalar dependencias de NPM y compilar assets
RUN npm install && npm run build

# Configurar Nginx
COPY nginx.conf /etc/nginx/sites-available/default
RUN ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/

# Configurar Supervisor para ejecutar PHP-FPM y Nginx
RUN mkdir -p /etc/supervisor/conf.d/
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# === PASOS NUEVOS PARA EJECUTAR MIGRACIONES AL INICIO ===
# Copiar script de entrada y darle permisos de ejecución
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Exponer puertos
EXPOSE 80
EXPOSE 9000

# Definir el punto de entrada: ESTO se ejecuta primero al arrancar el contenedor.
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
# El CMD es ahora ignorado.
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]