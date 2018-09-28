# Progetto-sd1

Progetto per sistemi distribuiti 1 che simula il pattern RCP( Remote procedure Call) utilizzando il broker di messagistica RabbitMQ

**Requisiti:**

- Web Server Apache o simili

- PHP 5.6 o superiori

- Composer

- Database MYSQL

- Server RabbitMQ

**Installazione:**

- Clonare il progetto all'interno della relativa cartella in base al web server utilizzato
- Eseguire il comando **'composer install'** all'interno della cartella del progetto
- Creare un nuovo database chiamato **rabbit** utilizzando il file **rabbit.sql** all'interno del progetto
- Modificare il file **config.php** con i parametri di configurazione per la connessione al database
- Assicurarsi di avere un Server RabbitMQ in esecuzione sulla porta 5672

