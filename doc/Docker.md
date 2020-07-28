## Development with Docker

- Go into docker folder `cd docker_config`
- Copy the default docker environment file `cp .env.example .env`
- Pull app image to avoid building it (which takes some time and memory): `docker-compose pull app`
- Start environment with `docker-compose up -d`
- Migrate DB on first start with `docker-compose exec -T app php bin/console d:mi:mi`
- Go to `http://localhost:8080/login`
- Login with `max@mustermann.de` and `secret`
- Go to `http://localhost:8080/api/stammdaten` to verify you are logged in

### TODO
- connect with frontend
- provide demo data (csv-files from test folder) for dummy users
- prepare for production (clean files and folders, no additional dummy servies, volumes etc.)
