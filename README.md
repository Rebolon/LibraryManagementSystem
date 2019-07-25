# Library Management System

## Installation

 * setup your database
 * change DATABASE_URL in .env (or better, in your sever environment)
 * change APP_ENV in .env to prod (same as above)
 * composer install
 * npm install
 * npm run dev (in prod use npm run production)
 * setup you webserver or use symfony cli, or `php -S localhost:80 -t public`

## Components inside

### Backend
 * php 7.3
 * symfony 4.3
 * api-platform: build API REST and GraphQL
   * doctrine
   * symfony/validator
 * webonyx/graphql-php: graphQl supports for api-platform
 * sensio/framework-extra-bundle: for the ParamConverter and automatic transformation before entering the Controller
 * doctrine migrations: keep the database up to date with required modification from code
 * symfony/property-info: get automatic validation from Doctrine annotation (https://symfony.com/blog/new-in-symfony-4-3-automatic-validation)
 * symfony/proxy-manager-bridge: get lazy services (https://symfony.com/doc/4.2/service_container/lazy_services.html)
 * symfony/maker-bundle: use make for building/updating entity per example
 * symfony/bridge-phpunit: unit testing
 * symfony/panther: functional testing
 
### Frontend 
 * symfony/webpack-encore-bundle: webpack4 for symfony with twig helpers
 * api-admin: frontend for CRUD management based on api platform resources
 * node-sass
 * sass-loader@^7.0.1
 * typescript 
 * ts-loader@^5.3.0 

## Authentification

HTTP Basic has been selected with a token generation and a ttl of [look at services.yaml:login_token_ttl] seconds 
This is quite easier than JWT, maybe better perf if we can trust https://jolicode.com/blog/why-you-dont-need-jwt
* username is the email of the user
* password is the apiToken of the user returned by the login route

The frontend must keep username/token in localStorage to call the api 
