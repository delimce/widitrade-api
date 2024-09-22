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

