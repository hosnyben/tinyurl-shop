# TinyURL Shop test
Hello thank you for your time reviewing my test. I would like first mention some details first.
- I couldn't have time to create a form to create new product / category. However to perform that I've set "Swagger OpenAPI" so you can perform your queries as you wish.
- I managed to seed 50M records in my machine to test performance. That application is cache based (redis). The first http request will be perfomed in DB. However the others will be loaded from cache level.
- When you update a record (Category / Product) it will dispatch a job in the queue to clear the cache of up to date datas. I didn't have time enough but I was looking to have a scheduled job to generate cache without the firt http request.
- Please do not hesitate to reach out to me for more details

## Requirements 
- PHP 8.x
- Laravel 11

## Installation 
You are not required to install php in your machine. All you have to do is to install [Docker](https://www.docker.com/ "Docker") in your machine.


#### Set up the application
The application is out-of-the-box app. All you have to do is to run the following commands in the root folder. And you will have a ready application:
```bash
# Copy .env.example file to .env
cp .env.example .env

# Create api server in detach mode
docker compose up -d

# Generate app key
docker exec -it tinyurl_api php artisan key:generate

# Migrate database
docker exec -it tinyurl_api php artisan migrate

# Seed the database
docker exec -it tinyurl_api php artisan db:seed
```

By running the `docker compose up -d` command. You will run the following containers (services):
- tinyurl_api : Api server
- tinyurl_queue : Queue worker
- mysql : Mysql Database
- redis : Redis database for cache
- nginx : Nginx server to access to the application 

#### Shut down the application
Stoping the docker server is reversible as necessary datas as stored in binding volumes. you can stop the server by running the following command.
```bash
# Stop the server
docker compose down
```

## Testing the application
You may test two sides, the frontend and the backend. I gave more importance to backend as Mr. Patton Luca asked.

First please `docker compose up -d`.

#### Backend
After seeding the databse you may perform all CRUD operations directly through your browser by openning the "Swagger OpenAPI" web page in this url : http://localhost:7001/api/documentation#/

#### Frontend
You may take a look at the front-end by running the following command `npm run dev` in root directory than open this url http://localhost:7001/.

**P.S. :** I made Infinite scrolle for pagination requests

Thank you :)