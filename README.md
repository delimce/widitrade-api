# widitrade content api
This is the content api for widitrade. It is a RESTful API that provides content for the widitrade website. The content is stored in a sqlite database and is served to the website via this API. The API is built using PHP 8.2 and symfony 6.4

## Pre requisites
- git scm installed
- docker & docker-compose installed

## Installation
1. Clone the repository
```git clone https://github.com/delimce/widitrade-api.git ```
2. Change directory to the project root
```cd widitrade-api```
3. Build the docker containers
```docker-compose up -d --build```
4. To validate everything is working, do launch this url in your browser
```http://localhost:8000/api/status```

## Common issues
- If you get a 500 error, it is likely that the database has not been created. You can create the database by running the following command
```docker-compose exec php bin/console doctrine:migrations:migrate```
- Database could be created as read only, you can change the permissions by running:
```sudo chown -R $USER:$USER var``` or ```sudo chmod -R 777 var/data.db```

## Api documentation
