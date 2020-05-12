# Server-Installation

Genauere Konfiguration von Apache und Installation auf Ubuntu ist bei Bedarf an der Charité verfügbar.

### PHP-FPM innerhalb von Apache verwenden:

```shell scribt
apt install php7.4-fpm
apt remove libapache2-mod-php
a2enmod proxy
a2enmod proxy_http
a2enmod proxy_fcgi
a2enconf php7.4-fpm
a2dismod php7.4
a2dismod mpm_prefork
a2enmod mpm_worker
```

PHP-FPM-Konfiguration

```ini
pm = dynamic

; The number of child processes to be created when pm is set to 'static' and the
; maximum number of child processes when pm is set to 'dynamic' or 'ondemand'.
; This value sets the limit on the number of simultaneous requests that will be
; served. Equivalent to the ApacheMaxClients directive with mpm_prefork.
; Equivalent to the PHP_FCGI_CHILDREN environment variable in the original PHP
; CGI. The below defaults are based on a server without much resources. Don't
; forget to tweak pm.* to fit your needs.
; Note: Used when pm is set to 'static', 'dynamic' or 'ondemand'
; Note: This value is mandatory.
pm.max_children = 100

; The number of child processes created on startup.
; Note: Used only when pm is set to 'dynamic'
; Default Value: min_spare_servers + (max_spare_servers - min_spare_servers) / 2
pm.start_servers = 5

; The desired minimum number of idle server processes.
pm.min_spare_servers = 3

; The desired maximum number of idle server processes.
pm.max_spare_servers = 10

; The number of seconds after which an idle process will be killed.
; Note: Used only when pm is set to 'ondemand'
; Default Value: 10s
;pm.process_idle_timeout = 10s;

; The number of requests each child process should execute before respawning.
; This can be useful to work around memory leaks in 3rd party libraries. For
; endless request processing specify '0'. Equivalent to PHP_FCGI_MAX_REQUESTS.
; Default Value: 0
pm.max_requests = 300
```



### Benötigte PHP-Pakete in Ubuntu:

```shell script
apt install php7.4-fpm php7.4-cli php-apcu php-apcu-bc php7.4-mysql php7.4-ldap php7.4-mbstring php-imagick php7.4-gettext php7.4-xml php7.4-gd  php7.4-zip php7.4-bz2 php7.4-curl php7.4-intl
```

### PHP-Konfiguration in Ubuntu

Anlegen der Datei :

    /etc/php/7.X/fpm/conf.d/levelup-php.ini

```ini
; Sondereinstellungen der php.ini


; Zeitzonen setzen (sonst kommen viele Warnings)
date.timezone = "Europe/Berlin"

; OPC OPCache config
; The OPcache shared memory storage size.
; see http://php.net/manual/de/opcache.configuration.php
opcache.memory_consumption=250
opcache.max_accelerated_files=5000

; performance and other limits
max_execution_time = 600
memory_limit = 1050M
post_max_size = 64M
upload_max_filesize = 40M
max_file_uploads = 100
session.gc_maxlifetime = 10800

; Matomo statistics requirements:
always_populate_raw_post_data = -1
```



