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

##### Issues:

* PHP composer libraries are not up to date
* Solution

```
# Increase php CLI memory limit
nano /etc/php7/php.ini     # Suche nach memory_limit, Einstellen auf 1000000000

# Only in Charité: Define Proxy:
export http_proxy=http://proxy.charite.de:8080
export https_proxy=http://proxy.charite.de:8080
export ftp_proxy=http://proxy.charite.de:8080
export no_proxy="localhost,127.0.0.1,*.charite.de,charite.de"

# Update dependencies
bin/install.sh
```



/etc/php7/php.ini

### TODO
- provide "real" test data (not demo data) (csv-files from test folder) for dummy users
- prepare for production (clean files and folders, no additional dummy servies, volumes etc.)
