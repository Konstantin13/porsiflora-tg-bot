# Porsiflora TG Bot

## Технологии

- Backend: Laravel 12 (PHP 8.2+)
- Frontend: React + TypeScript (Vite)
- Основной способ запуска: Laravel Sail (Docker), зап

## Как запустить backend (Docker / Sail)

1. Установить PHP-зависимости:
```bash
composer install
cp .env.example .env
```
2. Поднять контейнеры:
```bash
./vendor/bin/sail build
./vendor/bin/sail up -d # дважды в первый раз, нужен running
```

4. Сгенерировать ключ приложения:
```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
```

Приложение будет доступно по адресу `http://localhost:8080`.

## Как запустить обычный докер (не протестировано)
В корне проекта выполните:

cp .env.example .env
docker compose up -d --build
docker compose exec app composer install
docker compose exec app php artisan key:generate

После этого приложение будет на http://localhost:8080 (порт из APP_PORT), БД MySQL на 3307 (из FORWARD_DB_PORT).

Если нужен фронт (Vite), запустите еще:

docker compose run --rm node npm install
docker compose up -d node

Остановка:

docker compose down

## Как запустить frontend

1. Установить Node-зависимости через Sail:
```bash
./vendor/bin/sail npm install
```
2. Запустить Vite dev-сервер через Sail:
```bash
./vendor/bin/sail npm run dev -- --host 0.0.0.0 --port 5173
./vendor/bin/sail npm run build
```

## Как сидятся тестовые данные

В проекте есть сидер `database/seeders/ShopOrderTestSeeder.php`.

Он:
- создает 2 тестовых магазина;
- создает по 5 тестовых заказов на каждый магазин.

Также есть сид `database/seeders/DatabaseSeeder.php` - он создает тествого пользователя 
логин admin
пароль admin

Запуск сидов:
```bash
./vendor/bin/sail artisan db:seed
```

## Как прогнать тесты

./vendor/bin/sail artisan test tests/Feature/TelegramIntegrationApiTest.php

## Реальная Telegram-отправка или мок-режим
в .env TELEGRAM_MOCK, если true, то мок, иначе реальная отправка

## список допущений/упрощений

- Не используются очереди, отправка телеграм синхронная
- тесты только те что указаны
- авторизация для api роутов временно отключена (нужна настройка)
