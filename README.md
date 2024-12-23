## Installation

Clone repository
```bash
git clone https://github.com/berzins92/home-assignment.git
```

Go to project folder and heck if `master` branch is up to date
```bash
cd home-assignment
git pull origin main
```
___
### Environment
The app uses `8000` port for nginx and `3306` for database.\
Make sure, that other containers are not listening to these ports.\
You can change ports in `.env.example` file.
```bash
APP_PORT=8000
DB_PORT=3306
```
In .env.example file, there is default database connection configuration. Adjust it or use default (no action needed).
```bash
DB_DATABASE=lande-task
DB_USERNAME=laravel
DB_PASSWORD=secret
DB_ROOT_PASSWORD=root
```
___

### Build
Make sure, that Docker is opened and run
```bash
cp .env.example .env
docker compose build
docker-compose up -d
```

Install composer dependencies
```bash
docker-compose exec lande-task composer install 
```

Generate laravel key
```bash
docker-compose exec lande-task php artisan:key generate 
```

Run migrations
```bash
docker-compose exec lande-task php artisan migrate 
```

Clear configuration cache
```bash
docker-compose exec lande-task php artisan optimize 
```

Generate API documentation (optional)
```bash
docker-compose exec lande-task php artisan l5-swagger:generate
```
___
Test if page is working and you see phpinfo
```bash
https://localhost:8000
```

### Testing
Optional, but recommended to run tests
```bash
docker-compose exec lande-task php artisan test
```

### Final notes
Task built for https://github.com/lande-finance/test-task \
Any feedback would be appreciated.
