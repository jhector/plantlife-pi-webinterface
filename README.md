# Web Interface part of the PlantLIFE project

The web interface running on the Raspberry PI to display the collected data from the sensors.

## Setting up the Raspberry PI
Install nginx and PHP 5
```
sudo apt-get install nginx
sudo apt-get install php5-fpm
```
Edit `sites-enabled/default` add `index.php` to the following line:
```
index index.html index.htm;
```
and uncomment the PHP handler
```
location ~ \.php$ {
[...]
}
```
Install MySQL server and client and mysqli support
```
sudo apt-get install mysql-server --fix-missing
sudo apt-get install mysql-client php5-mysql
```

This should be all that is required to get install the web interface.

## Setting up the database
Import the database layout by running:
```
mysql -u root -p < database_setup.sql
```
Enter your password and you should be good to go.

## Clone the repo
Clone the repo somewhere on your system, copy the content into `/var/www/html` and everything should be ready to go.
