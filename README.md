# pooch
A simple lightweight MVC PHP framework

##About
Pooch is a simple and small php framework. It focuses on convention over configuration. It abuses global varibles to keep code as light 
and simple as possible. It works great for small to medium web applications. Pooch uses the amazing MysqliDb database class because 
it is so simple.

Who should use this framework? Small teams that want to build web applications quickly on the LAMP stack. Pooch reuses as much of the 
built in PHP language functionality as possible to keep the framework small.

##Installation
###Installation Process (details)
Installation of pooch is through [composer](https://getcomposer.org). You simply need to create a directory and create a composer.json file with the following 
contents:
```json
{
	"require": {
		"kevinkaske/pooch": "master"
	}
}
```
Alternativly you can simply download the contents of [this file](https://raw.githubusercontent.com/kevinkaske/pooch/master/setup/composer.json) 
to your application dir.

Then run `composer install`. Composer will then install the dependant libraries.

Now we just need to setup the project. Run the following command `php vendor/kevinkaske/pooch/setup.php`. Congratulations... Your 
project is now ready to go. Welcome to pooch! 

###Installation Example (OSX or Linux)
The following commands will create a pooch application for an application named "scooby"
```shell
mkdir scooby
cd scooby
curl https://raw.githubusercontent.com/kevinkaske/pooch/master/setup/composer.json
composer install
php vendor/kevinkaske/pooch/setup/setup.php
```

##Getting Started
Coming Soon :-)