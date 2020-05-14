# Backend-Framework LevelUp

Dokumentation siehe [./docs](./docs)

## Development with Docker

- Go into docker folder `cd docker_config`
- Pull all needed images (especially to avoid building the app image): `docker-compose pull`
- Start environment with `docker-compose up -d`
- Migrate DB on first start with `docker-compose exec -T app php bin/console d:mi:mi`
- Go to `http://localhost:8080/login`
- Login with `max@mustermann.de` and `secret`

### TODO
- connect with frontend
- provide demo data (csv-files from test folder) for dummy users