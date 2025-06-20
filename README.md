# Project Name

Symfony home work.

## Table of Contents

1. [Description](#description)
2. [Installation](#installation)

## Description

1. Create Symfony application (use LTS version)
2. Setup Docker or Lando (as a bonus);
3. Install SonataAdminBundle with ORM
4. Create “User” entity that implements UserInterface and PasswordAuthenticatedUserInterface;
5. Create “Article” entity with fields:
   1. title (string)
   2. body (text)
   3. author (ManyToOne, User)
   4. createdAt (datetime)
   5. updatedAt (datetime)
6. Implement Doctrine lifecycle callbacks for the “Article” entity to populate createdAt and updatedAt fields;
7. Create Sonata admin section to manage “Article” entity (CRUD):
   1. In list show all columns except “body”;
   2. Filters for all columns;
8. Install API Platform;
9. Create API endpoints for “Article” entity:
   1. GET collection
   2. GET single
   3. POST
   4. PUT
   5. PATCH
   6. DELETE
10. Create a public Git repository, commit your code there and share a link.

## Installation

1. docker compose up --build // Build and spin up PHP, nginx, mysql
2. symfony server:start // start symfony app
3. symfony console doctrine:database:create // create DB
4. symfony console doctrine:migrations:migrate // create entities as asked from task
5. symfony console app:create-user -pass --email // custom command to create user
