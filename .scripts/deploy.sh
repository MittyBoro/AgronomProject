#!/bin/bash
set -e

echo  "Deployment started ..."

# Войти в режим обслуживания или вернуть true
# если уже находится в режиме обслуживания
(php artisan down) || true

# Извлечь последнюю версию приложения
git checkout main
git pull origin main

# Установить зависимости composer
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Установить зависимости npm
npm ci

# Скомпилировать ресурсы npm
npm run build

# Очистить старый кэш
php artisan clear-compiled

# Заново создать кэш
php artisan optimize

# Запустить миграцию базы данных
php artisan migrate --force

# Выйти из режима обслуживания
php artisan up
php artisan queue:restart

echo  "Deployment done!"
