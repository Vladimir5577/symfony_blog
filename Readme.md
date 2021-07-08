# Symfony Blog

This is a simple symfony blog.

## Intallation

```bash
composer install
```
Then put your credentials in .env file

Load fixtures:

```bash
./bin/console doctrine:fixtures:load
```

## Run project

```bash
symfony serve
```

In fixtures there ara 3 user, everyone has a password 123. 
```bash
bob@bob.com    --- admin
mike@mike.com  --- user
jack@jack.com  --- user
```
To enter in admin panel:

```bash
Login to web site with credentials:
bob@bob.com  --- login
123			 --- password

Then type
/admin
```