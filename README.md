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


## database structure

The database is a sqlite database and has the following tables:
![Database Structure](https://github.com/delimce/widitrade-api/blob/main/docs/database_er.png?raw=true)


## Api documentation
![API Documentation](https://github.com/delimce/widitrade-api/blob/main/docs/api_endpoints.png?raw=true)

### endpoints list

- GET /api/status: This endpoint is used to check the status of the API 
- GET /api/content: This endpoint is used to get all the content (use attribute filter) [*]
- GET /api/content/{id}: This endpoint is used to get a single content by UUid [*]
- POST /api/content: This endpoint is used to create a new content [*]
- PUT /api/content/{id}: This endpoint is used to update a content BY UUid [*]
- DELETE /api/content/{id}: This endpoint is used to delete a content by UUid [*]
- POST /api/content/{id}/rate: This endpoint is used to rate a content by UUid (0-5) [*]
- POST /api/content/{id}/favorite: This endpoint is used to set content as favorite by UUid [*]
- GET /api/content/favorite: This endpoint is used to get all the user's favorite contents [*]
- GET /api/user: This endpoint is used to get the user details using a token [*]
- POST /api/upload: This endpoint is used to upload a file (image/video) to the server, and then use filepath in the content creation (media files)
- POST /api/register: This endpoint is used to create a new user
- POST /api/login: This endpoint is used to login a user a get a jwt token

[*] the endpoints that require authentication, need to have the Authorization header with the token value
example:
```Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1aWQiOiIxM2FiOTY0My0zOGZkLTRmY2UtOWNiYS1mMjdjMGM1NGRlYmQiLCJlbWFpbCI6ImpkaG9lQGVtYWlsLmNvbSIsImNyZWF0ZWQiOjE3MjY4NDM3MDR9.WXi8CJVwk6o1BkfWhmIMdfwsj7sRuscim9WMoFsQqRU```

### api base code structure
This Api was build using hexagonal architecture, so the code is divided in the following layers:
- Application: This layer contains the application services, that are used to interact with the domain layer
- Domain: This layer contains the domain entities, value objects, and repositories interfaces
- Infrastructure: This layer contains the infrastructure services, like the database, the file system, the jwt, contracts implementations, etc

### bundle contexts
- Shared: This bundle contains the shared code, focus in infrastructure, like the base controller, the base service, the base repository, ORM foundations etc
- Api: This bundle contains the api business logic, uses user's cases objects, and the api specific services

### POSTMAN COLLECTION
You can find the postman collection in the following link: (note: environment file is not included)
[Widitrade Postman Collection](https://github.com/delimce/widitrade-api/blob/main/docs/widitrade-api.postman_collection.json)