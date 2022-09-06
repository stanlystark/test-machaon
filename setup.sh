echo "Установка приложения..."
docker-compose create -d --build
sh ./start.sh
echo "Установка Composer"
docker exec -it -d test_machaon_app composer install
echo "Копирование настроек окружения"
docker exec -it -d test_machaon_app cp .env.example .env
echo "Генерация ключа"
docker exec -it -d test_machaon_app php artisan key:gen
echo "Запуск миграции"
docker exec -it -d test_machaon_app php artisan migrate
echo "Установка завершена"