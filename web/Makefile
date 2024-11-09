initialize:
	docker-compose up -d
	docker-compose exec php composer install
	npm install
	npm run dev
	docker-compose exec php cp .env.example .env
	docker-compose exec php php artisan key:generate
	docker-compose exec php php artisan storage:link
	docker-compose exec php php artisan migrate

run:
	docker-compose up -d

db_seed:
	docker-compose exec php php artisan db:seed

test:
	docker-compose exec php php artisan test
