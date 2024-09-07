#!/bin/bash
set -e

echo  "Deployment started ..."

# Войти в режим обслуживания или вернуть true
# если уже находится в режиме обслуживания
(php artisan down) || true
echo "Application is not running"

# Извлечь последнюю версию приложения
git checkout main
git pull origin main
echo "Last version deployed"

# Установить зависимости composer
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader
echo "Composer dependencies installed"

# Установить зависимости npm
npm ci
echo "Node dependencies installed"

# Скомпилировать ресурсы npm
npm run build
echo "Node resources builded"

# Очистить старый кэш
php artisan clear-compiled

# Заново создать кэш
php artisan optimize
echo "Cache cleaned"

# Запустить миграцию базы данных
php artisan migrate --force
echo "Database migrated"

# Выйти из режима обслуживания
php artisan up

echo  "Deployment done!"
