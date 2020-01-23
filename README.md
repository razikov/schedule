# Schedule

Приложение для управления расписанием

# Установка

1. git clone https://github.com/razikov/schedule.git
2. cd ./schedule
3. composer install
4. yarn install
5. развернуть БД и настроить доступ в ./config/_local.php пример есть в ./config/_local.sample.php
5. ./yii migrate
6. ./yii rbac/init
7. ./yii rbac/create-admin-user
8. use it!