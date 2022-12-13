# News-Parser-Scraper
symfony php app for scraping news off from news sorces


# start the application with this Docker command

- docker-compose up -d

# PORT = 8001 default 



# Tech Stack

- Symfony 5.4
- Php 7.4
- Mysql
- Bootstrap 5.1
- Docker (docker-compose)
- RabbitMQ

# Design
The application uses a CLI COMMAND to pass a 
- news source url
- wrapperSelector
- titleSelector
- descriptionSelector
- imageSelector

through the console manually or using the CRON server which takes CLI COMMAND VIA A BATCH SCRIPT.
The CRON server BATCH SCRIPT content can be updated tp parser the desired news source

eg. symfony console parse-news-source "https://dataquestio.github.io/web-scraping-pages/simple.html" "section.main .content" "h1" "p" "img"

# Rabbitmq is used with symfony messeager to transfer and queue messages

# USERS
The application has two roles ADMIN/MODERATOR 
two test users are already added in the test database attached to it.
The database is a mysql( free tier) on AWS RDS SERVER.

- ADMIN ROLE 

email: fiifigemini@gmail.com
password: Gemini



- MODERATOR ROLE 

email: eugene@gmail.com
password: Gemini

