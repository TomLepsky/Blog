# Dev образ
FROM nginx:1.17-alpine as dev
# Копируем конфиги Nginx
COPY /api/docker/nginx/blog.conf /etc/nginx/conf.d/default.conf
COPY /api/docker/nginx/nginx.conf /etc/nginx/nginx.conf

# Prod образ
FROM dev as prod
RUN mkdir -p /api/public
# копируем ассеты
#COPY ./assets /api/public
