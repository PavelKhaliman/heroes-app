# Руководство: Администратор и Заказчик

## Назначение проекта
Веб‑платформа клана/сообщества с разделами: информация, регламент, заявки, списки (coslist), форум (разделы/подразделы/ответы с вложениями), галерея (фото/скриншоты/другое), гайды (по регионам), ссылки/контакты, социальные реакции (комментарии, лайки), пользовательские уведомления и личный кабинет.

## Для Заказчика: функции и возможности
- Главная/информационные разделы:
  - Публичные страницы «Клан», «Информация», «Регламент», «События», «Контакты/Ссылки».
- Заявка в клан:
  - Подача заявки (форма), хранение статуса, уведомления о решении.
- Форум:
  - Просмотр разделов/подразделов, треды, ответы с вложениями, пагинация.
  - Авторизованные пользователи — создание/редактирование/удаление своих ответов.
- Галерея:
  - Фото/Скриншоты/Прочее: загрузка, редактирование, просмотр, пагинация.
- Гайды:
  - Разделы East/North/West/Central/Other: CRUD гайдов (для авторизованных), публичный просмотр.
- Соц. функционал:
  - Комментарии, лайки (toggle), уведомления в аккаунте.
- Личный кабинет:
  - Просмотр уведомлений, комментариев, своих фото; изменение профиля, пароля; загрузка аватара.

## Для Администратора: панель и операции
- Доступ: `/admin` (требуется роль admin/moderator, см. middleware `role:admin,moderator`).
- Пользователи:
  - Список/просмотр/обновление/удаление.
- Ссылки (контакты):
  - Создание/обновление карточек ссылок.
- Информация/Регламент (клан):
  - Создание/редактирование карточек контента.
- Coslist:
  - Персональные/гильдейские записи: создание/удаление.
- Заявки в клан:
  - Список, просмотр, изменение статуса, удаление.
- Форум:
  - Разделы/подразделы: создание/редактирование/удаление.

## Учётные записи
- Создание admin пользователя (пример):
```
cd /srv/heroes-app
docker compose --env-file .deploy.env -f docker-compose.prod.yml exec -T app \
  php artisan tinker --execute="App\\Models\\User::updateOrCreate(['email'=>'admin@mail.ru'],['name'=>'Admin','password'=>bcrypt('admin')])"
```
- Присвоение роли (если предусмотрена колонка `role`):
```
docker compose --env-file .deploy.env -f docker-compose.prod.yml exec -T app \
  php artisan tinker --execute="App\\Models\\User::where('email','admin@mail.ru')->update(['role'=>'admin'])"
```

## Доступ и роли
- Гости:
  - Публичные страницы доступны; действия (комментарии/лайки/создание контента) запрещены.
- Авторизованные пользователи:
  - ЛК, публикация в галерее/гайдах, комментарии/лайки.
- Админ/Модератор:
  - Раздел `/admin` (пользователи, форум, контент).

## Деплой, окружения и инфраструктура
- Образы Docker:
  - `app` (php-fpm + Laravel + pdo_pgsql): билд из `Dockerfile` (stage `app`).
  - `web` (nginx): отдача `public`, прокси на `app:9000`.
  - `db` (postgres:16-alpine).
- Компоновка: `docker-compose.prod.yml` (сервисы: db, app, web).
- Конфигурация Nginx в контейнере: `docker/nginx/nginx.conf` и `docker/nginx/conf.d/app.conf`.
- CI/CD (GitHub Actions): `.github/workflows/deploy.yml`
  - Билд и пуш образов в GHCR.
  - SSH деплой на VDS в `/srv/heroes-app`.
  - Файл окружения на VDS: `.deploy.env`.

### Переменные окружения (.deploy.env)
Пример валидного файла (каждая переменная — с новой строки, без пробелов слева):
```
APP_IMAGE=ghcr.io/<owner>/heroes-app:<sha>
WEB_IMAGE=ghcr.io/<owner>/heroes-web:<sha>
APP_URL=http://<domain-or-ip>
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx=
DB_DATABASE=heroes
DB_USERNAME=heroes
DB_PASSWORD=secret
WEB_PORT=80
```
Важно:
- `APP_KEY` — строго формата `base64:<…>` длиной 32 байта после декодирования.
- Для безопасности не публикуйте Postgres наружу (не маппить порт 5432).

### Старт/перезапуск на VDS
```
cd /srv/heroes-app
# с env-файлом
docker compose --env-file .deploy.env -f docker-compose.prod.yml up -d --force-recreate
# статус и логи
docker compose --env-file .deploy.env -f docker-compose.prod.yml ps
docker compose --env-file .deploy.env -f docker-compose.prod.yml logs --tail=80 app web db
```

### Миграции/кэши
```
docker compose --env-file .deploy.env -f docker-compose.prod.yml exec -T app sh -lc '
php artisan migrate --force &&
php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan cache:clear &&
php artisan config:cache && php artisan route:cache && php artisan view:cache
'
```

## Обслуживание и резервное копирование
- Бэкап БД (внутри хоста VDS):
```
docker compose --env-file .deploy.env -f docker-compose.prod.yml exec -T db \
  pg_dump -U "$DB_USERNAME" -d "$DB_DATABASE" -Fc > backup_$(date +%F_%H%M).dump
```
- Восстановление:
```
docker compose --env-file .deploy.env -f docker-compose.prod.yml exec -T db \
  pg_restore -U "$DB_USERNAME" -d "$DB_DATABASE" --clean --if-exists < backup_xxx.dump
```
- Медиа (файлы): том `storage` на хосте/в compose.

## Типовые проблемы и решения
- 502 Bad Gateway на :8080
  - `web` не достучался до `app:9000`. Проверить `ps`, логи `web`, `app`, доступ `nc -vz app 9000` из контейнера `web`.
- 500 Server Error на `/`
  - Проверить `storage/logs/laravel.log` в контейнере `app`.
  - Часто: неверный `APP_KEY` → заменить на валидный, пересобрать кэши.
- БД перезапускается/не инициализируется
  - Проверьте `.deploy.env` — строки `DB_*` должны быть на отдельных строках, без пробелов слева.
  - Удалить том `heroes-app_pgdata` и поднять стек заново.

## Безопасность
- Хранить секреты только в GitHub Secrets и `.deploy.env` на VDS (права 600).
- Не публиковать `.deploy.env` в репозиторий.
- Закрыть внешний доступ к Postgres (UFW deny 5432, без публикации порта). 
- Регулярно обновлять образы (в workflow уже настроено).

## Обновление кода
- Через CI/CD:
```
git add . && git commit -m "deploy" && git push origin main
# Далее Actions соберёт и задеплоит автоматически
```
- Ручное обновление (в крайнем случае):
```
ssh root@<vds>
cd /srv/heroes-app
set -a && . .deploy.env && set +a
git fetch --depth=1 origin main && git checkout -f FETCH_HEAD
docker compose --env-file .deploy.env -f docker-compose.prod.yml up -d --pull always --force-recreate
```

## Контакты поддержки
- Ответственный администратор: укажите ФИО/ник/канал связи.
- Каналы связи: email/телеграм/чат.

---
Документ можно расширять: добавляйте внутренние регламенты, SLA, расписание бэкапов, чек‑листы релизов и приёмки.
