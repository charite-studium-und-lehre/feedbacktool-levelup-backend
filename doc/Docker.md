## Development with Docker

- Go into docker folder `cd docker_config`
- Copy the default docker environment file `cp .env.example .env`
- Pull app image to avoid building it (which takes some time and memory): as superuser: `docker-compose pull app`
- Start environment with `docker-compose up -d` (as superuser)
- Migrate DB on first start with `docker-compose exec -T app php bin/console d:mi:mi` (as superuser)
- Go to `http://localhost:8080/login`
- Login with `max@mustermann.de` and `secret`

Login:

- Go to `http://localhost:8080/api/stammdaten` to verify you are logged in

Test demo data (no login needed)

- Test demo data on Backend: `http://localhost:8080/api/meilensteine?demo=1`
- Test demo data on Frontend: `http://localhost:3000/dashboard?demo`

### Re-build app image

Sometimes one needs to re-build the image (update PHP composer dependencies) (as superuser):

```shell-script
docker-compose build
```

or, with the proxy env variable used (inside the Charité network)

```shell script
docker-compose build --build-arg http_proxy
```

### TODO
- provide "real" test data (not demo data) (csv-files from test folder) for dummy users
- prepare for production (clean files and folders, no additional dummy servies, volumes etc.)
