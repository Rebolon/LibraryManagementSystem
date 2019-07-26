# Information

## Entity
* check integer field: transform them into Enum Table that will be retreived throught GraphQL to be used in FrontEnd app
* add default values
* add missing constraints on properties (don't forget that nullabe, type, unique and length are mutualized with Doctrine annotations)
* add domain constraint like this: a pet numberId is uniq only inside a company !

## React Admin
* check all forms: default values, constraints system, 
* change reference: /api/resource/id by their name (or any other getter with id inside: [id] name per example)
* move on 0.6.4+ when issue is fixed https://github.com/api-platform/admin/issues/185

## Security
* add user table
* add roles
* add authentification (JWT or something easier like here https://jolicode.com/blog/why-you-dont-need-jwt)
* add a script to create first user (for first install this is cool): maybe just add a migration
