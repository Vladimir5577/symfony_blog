Install symfony globally:
------------------

	$ wget https://get.symfony.com/cli/installer -O - | bash
	It will create file in the folder in the home directory
		.symfony/bin/symfony
	Copy this file in
	$ sudo cp symfony /user/local/bin/

// =============================================

Install symfony:

	$ symfony new my_project

Check requirements:

	$ symfony check:req

Run symfony on php server:
	$ php -S 127.0.0.1:8000 -t public/   --- not good

// ====================================================

Run symfony on symfony server:
---------------

	$ symfony serve

	$ symfony serve -d 	     --- to run on background
	$ symfony server:status  --- to see status
	$ symfony server:stop	 --- stop server

    or another way on php:

	$ php bin/console server:run
    $ php bin/console server:start	 --- to run in the background
    $ php bin/console server:status  --- to see status
    $ php bin/console server:stop    --- to stop server

    in browser type 127.0.0.1:8000
    or
    localhost:8000

// ====================================================

Install dependencies:
----------

	$ composer require annotations
	$ composer require template
	$ composer require debug  --- debug panel
	$ composer require make  --- for make command
	$ composer require serializer  --- for json
    $ composer require symfony/asset  --- for asset (images, files, ....)
    $ composer require symfony/validator doctrine/annotations   --- validation
    $ composer require knplabs/knp-paginator-bundle


// ========================================================

To see every available commands:

    $ php  bin/console
    or 
    $ symfony console

Make controller:

    $ php bin/console make:controller HomeController

To see autowiring:

    $ php bin/console debug:autowiring

// ========================================================

Database
-----------

Install:

    $ composer require symfony/orm-pack
    $ composer require symfony/maker-bundle --dev

    Then put credentials in .env

Create database:

    $ php bin/console doctrine:database:create   --- it will create database that from .env

Create entity (model):

    $ php bin/console make:entity   --- then answer on questions

Create the database table / schema (migration):

    $ php bin/console make:migration

Migrate (to the database):

    $ php bin/console doctrine:migrations:migrate

Check migrations:

    $ symfony console doctrine:migrations:list

Query in the command line:

   $ ./bin/console doctrine:query:sql "SELECT * FROM user"


// ==========================================================

Auth.
-------
    $ composer require symfony/security-bundle

Create User class:

    $ php bin/console make:user
        then answer on questions.

    Then add property name to User class:
        $ php bin/console make:entity
            then answer on questions
                > User
                ....

    $ php bin/console make:migration
    $ php bin/console doctrine:migrations:migrate

Install auth dependencies:
    In documentation: https://symfony.com/doc/current/security/form_login_setup.html

    $ composer require security
    $ php bin/console make:auth
        then answer on questions.

To see routes in console:

    $ ./bin/console debug:router

Add authentication in config/packages/security.yaml
    Uncommented line - { path: ^/admin, roles: ROLE_ADMIN }

// --------------------------------------------------------

Api auth.
------------

Make entity:

    $ ./bin/console make:entity
        > ApiToken
            > string
            > 255
            > no
        > expiresAt
            > datetime
            > no
        > user
            > relation
            > User
            > ManyToOne
            > yes
            > yes

Make migration and run:

    $ ./bin/console make:migration
    $ ./bin/console doctrine:migration:migrate

Select data in console:

    $ ./bin/console doctrine:query:sql "SELECT * FROM api_token"

Make auth:

    $ ./bin/console make:auth
        > 0
        > ApiTokenAuthenticator
        > 1

// ==========================================================

Validation.
---------------

    $ composer require symfony/validator doctrine/annotations

Then add to entity rules, and check it in controller.

Clear cache:

    $ php bin/console cache:clear

// ==========================================

Check global variable:

    $ symfony var:export --multiline


// ==========================================

Admin panel.
--------------

Install:

    $ symfony composer req "admin:^3"

Make directory for admin controllers:

    $ mkdir src/Controller/Admin/

Create dashboard:

    $ symfony console make:admin:dashboard
        > then use answers by default
        it will create /src/Controllers/Admin/DashboardController
        Then type in the browser /admin --- to open dashboard

Generate CRUD for the entity:

    $ symfony console make:admin:crud
        choose an entity then answer yes on rest questions

To give an access for user to admin panel --- type in the database roles: ["ROLE_ADMIN"]

// ==========================================
// ==========================================
