Projet 5 : Créez votre premier blog en PHP

1. Clone the repo from Github.
2. Run `composer install`.
3. Create _config/db.php_ from _config/db.php.dist_ file and add your DB parameters. Don't delete the _.dist_ file, it must be kept.

```php
define('APP_DB_HOST', 'your_db_host');
define('APP_DB_NAME', 'your_db_name');
define('APP_DB_USER', 'your_db_user_wich_is_not_root');
define('APP_DB_PWD', 'your_db_password');
```

4. Install MySQL and import `Portfolio.sql` in your SQL server,

5. Run the internal PHP webserver with `php -S localhost:8000`.
6. Go to `localhost:8000` with your favorite browser.
7. Starting:
   Once on the application, all you have to do is create an admin account and change the status to status = 1 by default, the created status is 3.
   Then you just have to log in.

8. Project developed in procedural PHP.
9. Libraries used:
   "guzzlehttp/psr7": "^2.0",
   "twig/twig": "^3.3",
   "altorouter/altorouter": "^2.0",
   "swiftmailer/swiftmailer": "^6.0"

You will find them at: https://packagist.org/
