init:
	docker-compose exec -u sail laravel.test php artisan migrate:fresh

fresh:
	docker-compose exec -u sail laravel.test php artisan migrate:fresh --seed

clear:
	docker-compose exec -u sail laravel.test php artisan migrate:fresh

demo-data:
	docker-compose exec -u sail laravel.test php artisan migrate:seed
