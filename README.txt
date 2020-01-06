/******************************************************\
 *                                                    *
 *          Contact Application v1.0                  *
 *         Released date : 30/12/2019                 *
 * Author : William Bertin - will.bertin@outlook.com  *
 *                                                    *
/******************************************************\

Requirements
PHP        : ^7.4
Symfony    : ^4.4
phpMyAdmin : 4.9.2
mysqlnd    : 7.4.0

How to start the project
1.   Unzip the project
2.   On the directory of the project, run bash console and run the command line : symfony server:start (you have to installed Symfony to do this step)
2.1. Url to download symfony : https://symfony.com/download (choose version 4 minimum)
3.   Run your mysql server (information to connection must be root:root, if you want to change this, edit .env file on root directory project)
4.   On the directory of the project, run bash console and run the command line : php bin/console doctrine:database:create
5.   Run on your browser the followed url : http://127.0.0.1:8000/contact/


Troubleshooting : 
If u have trouble in runnning application, clean the vendor/ directory and run the command followed : composer update

In other case of troubleshooting, please contact the author of the application