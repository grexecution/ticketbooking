# Ticket Booking
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
php artisan migrate --seed
php artisan key:generate
php artisan storage:link
```
#### To run local web server:
```bash
php artisan serve
```
#### To run auto rebuilding Vue mode:
```bash
npm run watch
```
#### To generate production assets:
```bash
npm run prod
```
