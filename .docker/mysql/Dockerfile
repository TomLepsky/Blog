FROM mysql:8.0
# Копируем дамп который выполнится при первой инициализации контейнера
COPY ./.docker/mysql/startup /docker-entrypoint-initdb.d
