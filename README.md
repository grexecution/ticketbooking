# Course Dashboard
### Installation instructions
#### Copy and set database credentials
```bash
cp .env.example .env
```
#### Set base permissions
```bash
chmod 755 /var/www/html /var/www/html/public \
  && chmod 644 /var/www/html/public/index.php \
  && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
```
#### Run initial commands:
```bash
composer install
php artisan migrate
php artisan key:generate
php artisan storage:link
```
#### To run Laravel's local development server:
```bash
php artisan serve
```
#### Dashboard cron:
```bash
php /home/ploi/dashboard.thegreg.io/artisan schedule:run
```
