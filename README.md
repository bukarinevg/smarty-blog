# Smarty Blog

PHP 8.4+ · Smarty · MySQL

## Start

```bash
cp .env.example .env
docker compose up --build -d
docker compose exec php composer install
docker compose exec php npm install
docker compose exec php npm run scss:build
docker compose exec php composer migrate
docker compose exec php composer migrate:seed
```

If the migration command fails with `Connection refused`, wait about a minute for MySQL to finish initializing and run
the migration again.

Open:

- http://localhost:8080
- http://localhost:8888 (phpMyAdmin)

## Routes

- `/`
- `/category/show/{id}`
- `/article/show/{id}`
