# Testumgebung

Durch ein bin/install.sh wurde schon PHPUnit zum Testen installiert.

Wichtig ist die Erstellung einer Test-DB.

Die Nutzerdaten müssen eingetragen werden in  [.env.test](../../.env.test) 

Anschließend wird die DB-Struktur gefüllt und bei Änderungen aktualisiert durch Ausführung von  [bin/executeTestMigrations.sh](../../bin/executeTestMigrations.sh)  

