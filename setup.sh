echo "Установка приложения..."
docker-compose create -d --build
sh ./start.sh
echo "Настройка окружения"
docker exec test_machaon_app bash -c "composer install ; cp .env.example .env ; php artisan key:generate ; php artisan migrate"
echo "Установка завершена"