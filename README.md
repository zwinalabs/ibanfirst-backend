# iBanFirst wallet visualisation

This project use iBanFirst API for "wallets" and their "financial movements" visualisation.

Technos Stack:
------------

- php
- symfony 5
- json
- javascript
- twig

Installation
------------

Open your console terminal. Assuming you have Git alrady installed. Clone the project to download its contents:
```bash
git clone https://github.com/zwinalabs/ibanfirst-backend.git
```
Move into your new project directory:<br>
```bash
cd ibanfirst-backend
```
If Composer is installed:
```bash
composer install
```
If Composer is not installed:
```bash
php composer.phar install
```

Configuration
------------

To change the API url/user or password got to the environment variables locatedat ".env" files and check the "###> API iBanFirst Ressources ###" section:
```bash
###> API iBanFirst Ressources ###
API_USERNAME=a00720d
API_PASSWORD=6KPPczga4H6pR+ZeMj+iQ5UpB0foUoO3hQWOjUiYkESU3HGLfXwc...
BASE_API_URL=https://sandbox2.ibanfirst.com/api
###< API iBanFirst Ressources ###
```

Getting started with tests
------------

To run the tests locally, we ran our test using  command from the terminal:
```bash
./bin/phpunit
```

To restructure things a little bit and automate this command by adding it to the scripts section within the composer.json file. we have added the test command to the scripts section:
```bash
{
    ...
    "scripts": {
        ...,
        "test": [
            "./bin/phpunit"
        ]
    }
}
```
test command will be available as :
```bash
composer test
```

To automate tests and CI with CircleCI. we haved created ".circleci" folder and inside this folder, we create a file named config.yml to setup an automated CI pipeline using CircleCI.


Run the Web application
------------

You can run the application locally using the following command:
```bash
php -S 127.0.0.1:8000 -t public/
```
or 
```bash
symfony server:start
```