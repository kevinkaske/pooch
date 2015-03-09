# pooch
A simple lightweight PHP framework

##About
Pooch is a simple, small (around 200 lines of code) PHP framework. Pooch is able to stay tiny by being built to use the amazing 
[MysqliDb](https://github.com/joshcam/PHP-MySQLi-Database-Class) database class and built in PHP functionality (for templating). 
This framework focuses on convention over configuration. It abuses global varibles as a nessisary evil to keep code as light and 
simple as possible. It works great for prototyping small to medium sized web applications.

Who should use this framework? Anyone that wants to get an application up and running quickly and focus on their code and not the 
framework. If you want a small, light, quick framework and don't mind being tied to MySQL, this framework could be what you have been 
looking for.

##Installation
###Installation Process (Detailed Overview)
Installation of pooch is through [composer](https://getcomposer.org). You simply need to create a directory and create a composer.json file with the following 
contents:
```json
{
	"minimum-stability": "dev",
	"require": {
		"kevinkaske/pooch": "dev-master"
	}
}
```
Alternativly you can simply download the contents of [this file](https://raw.githubusercontent.com/kevinkaske/pooch/master/setup/base/composer.json) 
to your application dir.

Then run `composer install`. Composer will then install the dependant libraries.

Now we need to setup the project. Run the following command `php vendor/kevinkaske/pooch/setup.php`. Congratulations... Your 
project is now ready to go. 

Everything is ready to go except for the database connection library. Since MysqliDb is not avalible for install via composer, 
we will need to install it to the lib directory. Simply download 
[this file](https://raw.githubusercontent.com/joshcam/PHP-MySQLi-Database-Class/master/MysqliDb.php) to the lib directory.

Welcome to pooch! 

###Installation Example (OSX or Linux)
The following commands will create a pooch application for an application named "scooby"
```shell
mkdir scooby
cd scooby
curl -O https://raw.githubusercontent.com/kevinkaske/pooch/master/setup/base/composer.json
composer install
php vendor/kevinkaske/pooch/setup/new_application.php
cd lib
curl -O https://raw.githubusercontent.com/joshcam/PHP-MySQLi-Database-Class/master/MysqliDb.php
```

##Getting Started
Coming Soon :-)