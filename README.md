# BileMo

Installation

1. Clone repository
2. run composer install command (use : composer install --no-dev --optimize-autoloader)
3. Configure .env file (or environement variable in your web server)
4. Create database with command : php bin/console doctrine:database:create
5. Apply migrations (use : php bin/console doctrine:migration:migrate)

If you want use demo data, add datas with the fixtures
1. Use command : php bin/console doctrine:fixtures:load
