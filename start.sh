echo "Запуск..."

set -a
. ./.env
set +a
docker-compose up -d
echo "Контейнер запущен: http://127.0.0.1:$APP_PORT"