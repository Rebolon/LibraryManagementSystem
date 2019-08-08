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
* i get a 401 on POST HTTP for Companies per exemple
* Remove from menu the access to ROLE_ADMIN uri (users, companies) https://react-admin.com/docs/en/authorization.html#restricting-access-to-resources-or-views but i have no sample for instance
 
## Security
* add user table
* add roles
* add authentification (JWT or something easier like here https://jolicode.com/blog/why-you-dont-need-jwt)
* add a script to create first user (for first install this is cool): maybe just add a migration

+##Opened issues:
+* https://github.com/api-platform/admin/issues/185 : version of package admin
+* https://github.com/api-platform/admin/issues/193 : problem with autorization when login with user that only has ROLE_USER (which should work)
+* https://github.com/api-platform/api-platform/issues/1213 : same but on backend side
+All previous 3 issues should be reported to other projects: library or php-...
+* https://github.com/symfony/symfony/issues/33044 is the same issue on Symfony
