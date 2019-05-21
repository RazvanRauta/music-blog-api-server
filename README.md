## music-blog-api-server
Symfony 4.2 based api server

## Install

#### Define database(MySql) connection in `.env` file line 27:

`DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name`

#### then run the following commands in terminal
````
composer install

php bin/console make:migration

php bin/console doctrine:migrations:migrate

php bin/console doctrine:fixtures:load -q **to load dummy data**

````

#### Use to start the server:

`php -S 127.0.0.1:8000 -t public`

#### To see the api endpoints go to:

#### http://localhost:8000/api


###### Created by Razvan Rauta
