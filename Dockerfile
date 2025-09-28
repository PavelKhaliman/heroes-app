# syntax=docker/dockerfile:1.7

############################################
# Stage: node assets build
############################################
FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY vite.config.js ./vite.config.js
COPY public ./public
# Build frontend assets (laravel-vite-plugin)
RUN npm run build

############################################
# Stage: composer dependencies
############################################
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-progress --optimize-autoloader --no-scripts

############################################
# Stage: php base with extensions
############################################
FROM php:8.2-fpm-alpine AS php-base

# Install system deps
RUN apk add --no-cache bash icu-dev libpq-dev libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev libzip-dev zip git curl netcat-openbsd

# Install PHP extensions (pdo_pgsql, intl, gd, opcache, zip, mbstring)
RUN docker-php-ext-configure intl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" intl pdo pdo_pgsql gd opcache zip mbstring

# Configure PHP (production-ish)
COPY --link ./docker/php/php.ini /usr/local/etc/php/conf.d/99-app.ini

WORKDIR /var/www

############################################
# Stage: app code assembly
############################################
FROM php-base AS app-code
WORKDIR /var/www

# Copy application code
COPY . .

# Remove files not needed in runtime image and clear stale caches
RUN rm -rf node_modules tests .git .github \
    && rm -f bootstrap/cache/*.php || true

# Copy vendor from composer stage
COPY --from=vendor /app/vendor ./vendor

# Copy built assets into public/build
RUN mkdir -p public/build
COPY --from=assets /app/public/build ./public/build

# Ensure storage and cache directories exist with proper permissions
RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Production optimize (will be re-run at start too)
RUN php artisan config:clear || true \
    && php artisan route:clear || true

############################################
# Stage: PHP-FPM runtime image
############################################
FROM php-base AS app
WORKDIR /var/www

# Copy prepared code
COPY --from=app-code /var/www /var/www

# Entrypoint to run migrations and caches
COPY --link ./docker/app/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 9000
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-F"]

############################################
# Stage: Nginx runtime image
############################################
FROM nginx:1.27-alpine AS web
WORKDIR /var/www

# Upgrade base packages to include latest security fixes
RUN apk upgrade --no-cache || true

# Copy public content only
COPY --from=app-code /var/www/public /var/www/public

# Nginx config
COPY --link ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --link ./docker/nginx/conf.d/app.conf /etc/nginx/conf.d/default.conf

EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
