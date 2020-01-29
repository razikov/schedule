# Schedule

Приложение для управления расписанием

# Установка

1. git clone https://github.com/razikov/schedule.git
2. cd ./schedule
3. composer install
4. yarn install
5. развернуть БД и настроить веб-сервер
6. настроить приложение:
    * скопировать и настроить ./config/_local.sample.php в ./config/_local.php
    * скопировать ./config/index.sample.php в ./web/index.php
7. ./yii migrate
8. ./yii rbac/init
9. ./yii rbac/create-admin-user
10. use it!