# Backend-Framework LevelUp

Dokumentation siehe [./docs](./docs)

## Development with Docker

- Start environment with `docker-compose up -d`
- Migrate DB on first start with `docker-compose exec -T app php bin/console d:mi:mi`
- Go to `http://localhost:8080/login`
- Login with `max@mustermann.de` and `secret`