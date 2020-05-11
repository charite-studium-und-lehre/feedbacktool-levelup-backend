# Deployment

### Lokale Installation:

Aufrufen von  [firstInstall.sh](../bin/firstInstall.sh) instaliert alles, was man zum lokalen Ausführen eine Symfony-Umgebung braucht

Aufrufen von  [devInstall.sh](../bin/devInstall.sh) installiert Tools zur Entwicklung

### Installation auf Server oder lokal

Aufruf von [install.sh](../bin/install.sh) lädt [Composer](https://getcomposer.org/) herunter und installiert/aktualisiert alle Abhängigkeiten

### Konfiguration über dotenv  [.env](../.env) 

Initial kann die Datei  [.env.dist](../.env.dist) nach  [.env](../.env) kopiert werden.

Hier trägt man die **Umgebung** der aktuellen Installation ein (dev/test/prod) und setzt ein **APP_SECRET** (wichtig für Sicherheitsfeatures von Symfony)

Wichtig ist die Konfiguration der DB nach dem Schema:

`DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`

### Anlegen einer Datenbank

Es muss eine MySQL-DB mit entsprechendem Nutzer angelegt werden. Die Zugangsdaten müssen in .env eingetragen werden

### Anlegen und Aktualisieren der DB-Struktur

Ausführen von 

```shell script
bin/console doctrine:migrations:migrate
# oder Kurzform
bin/console d:mi:mi
```

erstellt die DB-Struktur bzw ändert sie auf die neueste vorhandene Version durch die Ausführung von Doctrine-Migrations.

Dies wird in  [install.sh](../bin/install.sh) automatisch mit erledigt.

### Start der Anwendung

Lokal: `bin/symfony serve`

Server: Einbindung des public-Ordners in Apache

Genauere Konfiguration von Apache und Installation auf Ubuntu ist bei Bedarf an der Charité verfügbar