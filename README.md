# Conestoga College - Mobile Solutions Development
## Web Design and Development Principles (PROG8166 )

### Requirements to run the system:
* Webserver (Apache/Nginx/...)
* PHP 8.3
* MySQL 8

### How to run the system
1. Configure the webserver to point to the root of this project (where the index.php file is located)
2. Make sure that your server's rewrite module is enabled so that the .htaccess file can overwrite the settings
3. Create the database, there is a MySQL Workbench file (https://www.mysql.com/products/workbench/) in the /doc directory. If you wish, there is a . SQL file in /doc/SQL Files/
4. Environment created, database imported and running, you need to adjust the database access settings in the db_conection.php file within /app/Library/
5. Open the browser and type in the URL defined for the project.

![System demo](screenshot.gif)
