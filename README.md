# Тестовое задание

Rest Api User

## Установка

1. Клонируйте репозиторий на свой компьютер
2. Запустите докер контейнер (убедитесь что у вас отключены сервисы apache и mysql)

```shell
docker compose up -d
```

3. Переименуйте .env.example в .env
4. Перейдите в контейнер securitm_api
5. Установите все зависимости с помощью

```shell
composer install
```

4. Сгенерируйте ключ приложения с помощью команды

```php
php artisan key:generate
```

6. Выполните миграции с помощью команды

```php
php artisan migrate
```

7. Выполните сиды с помощью команды

```php
php artisan db:seed
```
