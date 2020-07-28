#! /bin/sh

/var/www/levelup/bin/console cache:clear

# Copy all public files to shared volume to provide for nginx
## Delete all files from webroot
cd /shared/app-webroot && rm -rf ..?* .[!.]* *
## Copy files
cp -R /var/www/levelup/public/. /shared/app-webroot

exec /usr/local/bin/docker-php-entrypoint php-fpm
