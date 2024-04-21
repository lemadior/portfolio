# Installation notes

1. Clone the repository

  After cloning type the next commands:

  _**cd < Laravel folder >**_

  _**git checkout task9-sql**_

2. Configure the Laravel:

run command:

_**sh ./first_start.sh**_

  NOTE: The script will ask about user's password because it run sudo for some command.

        Command will create the .env file and generate the application key.

        To check works just type in browser localhost:5000

  IMPORTANT: Copy the .env.example file to the .env and specify all needed data

3. Start with Laravel
    - URL: localhost:5000
    - DB: works on 5432 port
    - DB settings for .env:
        DB_CONNECTION=pgsql
        DB_HOST=db
        DB_PORT=5432
        DB_DATABASE=college
        DB_USERNAME=<username>
        DB_PASSWORD=<password>

4. To check the result go to URL: localhost:5000

5. Set proper DB user and password in .env file and do command

  _**docker exec -it app php artisan migrate --seed**_

or

  _**docker exec -it app php artisan migrate:fresh --seed**_

6. To use the pgAdmin go to URL: localhost:5050

  user: <DB_USERNAME>@local.net
  password: <DB_PASSWORD>

7. To do complex tests do command:

_**docker exec -it app php artisan test**_

8. To go to API page use the URL: http://localhost:5000/api/v1/documentation
