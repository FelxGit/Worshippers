INSTALLATION GUIDE

Docker engine version (4.28)

STEPS TO RUN THE PROJECT
Clone this repo from this url
https://github.com/FelxGit/community

- Navigate to the community folder

CMD
- docker-compose up -d

------------------
SETTING UP BACKEND

RUN
  - docker-compose run php_lv bash
  - composer install
  - php artisan migrate --seed
  - php artisan passport:install

------------------------
SETTING UP FRONTEND
CMD
  - docker-compose run node_lv install