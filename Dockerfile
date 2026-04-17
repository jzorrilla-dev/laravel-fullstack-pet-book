# ============================================
# Stage 1: Frontend Builder (Node.js)
# ============================================
FROM node:22-alpine AS frontend-builder

WORKDIR /app

COPY package.json pnpm-lock.yaml* ./

RUN corepack enable && pnpm install --frozen-lockfile

COPY . .

RUN pnpm build

# ============================================
# Stage 2: Production (PHP + Nginx)
# ============================================
FROM php:8.4-fpm

ARG uid=1000
ARG user=laravel

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libzip-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libpq-dev \
        supervisor \
        nginx \
    && docker-php-ext-install zip pdo pdo_pgsql pgsql mbstring exif pcntl bcmath gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY uploads.ini /usr/local/etc/php/conf.d/uploads.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user \
    && mkdir -p /home/$user/.composer \
    && chown -R $user:$user /home/$user

WORKDIR /var/www

COPY . /var/www

RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

RUN composer install --optimize-autoloader --no-dev --no-interaction --no-scripts

COPY --from=frontend-builder /app/public/build /var/www/public/build

RUN chown -R www-data:www-data /var/www/public/build

COPY nginx.conf /etc/nginx/sites-available/default

RUN mkdir -p /etc/nginx/sites-enabled \
    && ln -sf /etc/nginx/sites-available/default /etc/nginx/sites-enabled/default \
    && mkdir -p /etc/supervisor/conf.d/

COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

COPY entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80 9000

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]