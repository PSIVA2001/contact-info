# Contacts Listing Dashboard

A simple contact listing dashboard built with Symfony 4.4. This dashboard allows you to create, view, update, and delete contacts.

## Requirements

Before you get started, ensure you have the following software installed on your system:

- PHP 7.1 or higher
- Symfony 4.4
- Composer (PHP package manager)

## Cloning the project

Clone the repository to your local machine:

   git clone https://github.com/PSIVA2001/contact-info.git
   
## Install project dependencies using Composer:

    composer install
    
## Install yarn:

    yarn install

## Create the database schema:

Configure your Symfony environment. You'll need to set up your database connection and Email in .env and .env.test file.

    php bin/console doctrine:database:create
    
    php bin/console doctrine:schema:update --force

## Unit Testing

This project includes unit tests to ensure its reliability and maintainability. You can run the unit tests using the following command:
    
    php bin/phpunit
