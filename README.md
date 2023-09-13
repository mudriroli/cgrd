# cgrd

## Install-Run instructions
- cd into the environment directory
- Run `docker compose up --build`
- Inside the `php` docker container run `composer install` where the composer.json is located
- Create a `.env` file next to the `.env.example` with these credentials:
  -  DATABASE=cgrd
  -  DATABASE_USER=admin
  -  DATABASE_PASSWORD=test
- Connect to the database with a client and run the sql script called `cgrd-db-structure.sql`, located inside the environment directory to create the database structure and have the given user in the users table
- App should be available on `localhost:8080`