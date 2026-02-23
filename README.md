# Smarty Blog

PHP 8.4+ · Smarty · MySQL · без фреймворков

## Старт

```bash
docker compose up --build -d
docker compose exec php composer install
docker compose exec php composer migrate
docker compose exec php composer migrate:seed
docker compose exec php npm install
docker compose exec php npm run scss:build
```

Открыть:
- http://localhost:8080
- http://localhost:8888 (phpMyAdmin)

## Роуты

- `/`  
- `/category/show/{id}`
- `/article/show/{id}`
