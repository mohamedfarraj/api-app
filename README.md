## Download Project

- use Git
```sh
git clone git@github.com:mohamedfarraj/api-app.git
```
- Or Download

- open project folder


## Install Project

- Install Dependencies

Run 
```sh
composer install
```

- Environment Configuration 
```sh
php -r "file_exists('.env') || copy('.env.example', '.env');"
```

update your .env configuration file

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

- Generate a new APP KEY
```sh
php artisan key:generate
```

- Migrate Database
```sh
php artisan migrate
```


## Run Project

```sh
php artisan migrate
```

## Postman Collection

postman collection in project folder name
```sh
Api App.postman_collection.json
```
- Note Please set "Accept" : "application/json" in request header 


