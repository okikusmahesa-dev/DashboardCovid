# Untuk Masuk ke MySql:
./vendor/bin/sail mysql

# Untuk dump table covid_total.sql ke directory database:
./vendor/bin/sail exec mysql mysqldump -u root -p laravel covid_total > database/covid_total.sql
