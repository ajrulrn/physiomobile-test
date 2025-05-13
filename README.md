## Requirements
- You need **[Docker](https://www.docker.com/)** to run this application or install **[PHP](https://php.net)** version 8.3.20 manually

## Installation
1.  Clone this repository
	```
	git clone https://github.com/ajrulrn/physiomobile-test.git
	cd physiomobile-test
    ```
2.  Create a copy of the environment variable
	```
	cp .env.example .env
	```
3.	Setup your configuration database
	```
	DB_HOST=127.0.0.1
	DB_NAME=physiomobile
	DB_USER=postgres
	DB_PASS=postgres
	DB_PORT=5432
	```
4.  Run app
	```
    # using php
    composer install
	php artisan key:generate
	php artisan access-key:generate
	php artisan migrate
    php artisan serve
    
    # using docker
	docker compose -f docker-compose.dev.yml up -d
	docker exec app php artisan key:generate
	docker exec app php artisan access-key:generate
	```

## API Documentation
You can access this [link](https://documenter.getpostman.com/view/17651746/2sB2jAcUJ7) for documentation.