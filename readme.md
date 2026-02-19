# Porsiflora TG Bot

## Технологии

- Backend: Laravel
- Frontend: React + TypeScript (через Vite)
- Запуск окружения: Laravel Sail

## Как запустить

1. Поднять контейнеры:
```bash
./vendor/bin/sail up -d
```
2. Установить JS-зависимости (в контейнере):
```bash
./vendor/bin/sail npm install
```
3. Запустить dev-сборку фронта:
```bash
./vendor/bin/sail npm run dev
```
4. Приложение доступно по адресу Laravel (обычно `http://localhost`).

## Логика фронтенда

- Единая точка входа фронта: `resources/js/app.tsx`.
- Основные модули:
  - `resources/js/components/AppRoot.tsx` — роутинг по типу страницы.
  - `resources/js/bootstrap.ts` — чтение bootstrap-данных из `window.__APP_DATA__`.
  - `resources/js/types/page-data.ts` — типы данных страниц.
  - `resources/js/pages/LoginPage.tsx` — экран авторизации.
  - `resources/js/pages/DashboardPage.tsx` — экран дашборда.
  - `resources/js/styles/common.ts` — общие стили интерфейса.
- Laravel рендерит `resources/views/app.blade.php` для страниц:
  - `/login`
  - `/dashboard`
- В Blade в `window.__APP_DATA__` передаются bootstrap-данные (страница, csrf, ошибки, действия форм).
- React выбирает компонент страницы по полю `page`:
  - `login` -> форма входа (POST на `route('login.store')`)
  - `dashboard` -> кнопка выхода (POST на `route('logout')`)

## Взаимосвязи Laravel <-> React

1. Роут в `routes/web.php` собирает данные страницы и отдает `view('app')`.
2. `resources/views/app.blade.php`:
   - подключает Vite-бандл `resources/js/app.tsx`;
   - сериализует данные в `window.__APP_DATA__`.
3. `resources/js/app.tsx` читает bootstrap-данные и рендерит нужную React-страницу.

## Важные ограничения разработки

- Команды Laravel выполнять через Sail (`./vendor/bin/sail artisan ...`).
- Команды Node/NPM выполнять только через Sail (`./vendor/bin/sail npm ...`).
- Миграции в проекте не редактируются, только добавляются новыми файлами.
- `php artisan migrate` не запускается автоматически в рамках разработки изменений.
