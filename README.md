# A Laravel application with SQL database

## Project description

An educational project to create simple CRUD system
for some Fake University to manage its general students' data.

## Conditions of the task

Create an application that inserts/updates/deletes data in the database using eloquent and laravel framework. Use PostgreSQL DB.

Models have to includes next field

1. Group:
  * name
2. Student:
  * group_id
  * first_name
  * last_name
3. Course:
  * name
  * description

Create relation MANY-TO-MANY between tables STUDENTS and COURSES.

Create a laravel application:

* Create migrations that create db scheme
* Write seeds that generate test data:
  * 10 groups with randomly generated names. The name should contain 2 characters, hyphen, 2 numbers
Create 10 courses (math, biology, etc);
  * 200 students. Take 20 first names and 20 last names and randomly combine them to generate students.

***NOTE:*** Randomly assign students to groups. Each group could contain 
from 10 to 30 students. It is possible that some groups will be without 
students or students without groups. Randomly assign from 1 to 3 courses 
for each student.

Create pages that:

* Find all groups with less or equals student count.
* Find all students related to the course with a given name.
* Add new student
* Delete student by STUDENT_ID
* Add a student to the course (from a list)
* Remove the student from one of his or her courses
* Add REST-api and swagger.

## Installation notes

1. Clone the repository

After cloning type the next commands:

  ```cd < Laravel folder >```

  ```git checkout task9-sql```

2. Configure the Laravel:

  run command:

```sh ./first_start.sh```

***NOTE:*** The script will ask about user's password because it run sudo for some command.

Command will create the ```.env``` file and will generate the application key.

To check works just type in browser *localhost:5000*.

**IMPORTANT:** Copy the ```.env.example``` file to the ```.env``` and specify all the needed settings data.

3. Set proper DB user and password in ```.env``` file:

- URL: localhost:5000 
- DB settings for .env:
    * DB_CONNECTION=pgsql
    * DB_HOST=db
    * DB_PORT=5432
    * DB_DATABASE=college
    * DB_USERNAME=<username>
    * DB_PASSWORD=<password>

***NOTE:*** DB works on 5432 port:

Add DB data:

```docker exec -it app php artisan migrate --seed```

or

```docker exec -it app php artisan migrate:fresh --seed```

4. Start with Laravel.

```docker exec -it app php artisan serve```

To check the result go to URL: [localhost:5000](http://localhost:5000)

5. To use the pgAdmin go to URL: [localhost:5050](http://localhost:5000)

```
  user: <DB_USERNAME>@local.net
  password: <DB_PASSWORD>
```

6. To do complex tests do command in terminal (*at first one must cd to the project's dir*):

```docker exec -it app php artisan test```

7. To go to API page just use the URL: [http://localhost:5000/api/v1/documentation](http://localhost:5000/api/v1/documentation)
