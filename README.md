# Pooch
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
The following commands will create a pooch application for an application named "pound"
```shell
mkdir pound
cd pound
curl -O https://raw.githubusercontent.com/kevinkaske/pooch/master/setup/base/composer.json
composer install
php vendor/kevinkaske/pooch/setup/new_application.php
cd lib
curl -O https://raw.githubusercontent.com/joshcam/PHP-MySQLi-Database-Class/master/MysqliDb.php
```

##Getting Started
###Database Setup
We are now ready to hook the database up. You can either use a GUI tool like MySQL Workbench or the MySQL CLI. To create a DB named 
"pound" using the CLI type the following:
```shell
mysql -u root -p
CREATE DATABASE pound;
```

You will then need to update the config files to point at this new database. Update the database connection details in both 
config/config.php and phinx.yml files.

###Database Migrations
Database migrations give you a way of keeping track of changes to your database schema in source control. This way you can keep your 
various database environment in sync.

Let's create a table for our new dog pound app called "dogs". We use the following command to create a migration:
```shell
php vendor/bin/phinx create CreateDogs
```

This will create a file in the migrations folder with a time stamp and the name CreateDogs. This will look something like
20151113201209_create_dogs.php. You will then need to edit the contents of the file. You can find more information on how 
the Phinx migration files work [here](http://docs.phinx.org/en/latest/). For now we will just edit the file to look like the 
following: 
```php
<?
use Phinx\Migration\AbstractMigration;

class CreateFriends extends AbstractMigration{
  public function change(){
    $users = $this->table('dogs');
    $users->addColumn('name', 'string')
          ->addColumn('age', 'string')
          ->save();
  }
?>
```

Now let's run this migration and add the "dogs" table to the database. Run `php vendor/bin/phinx migrate` from the command line to run 
this migration.

###Controllers and Views
Ok... We have a place to store the dogs that are in the dog pound. How are we going to allow people to view, add, and update these dogs? 
We need to create a dogs controller and views to go along with those views.

Create a blank text document at controllers/dogs_controller.php. In this file put the following code:
```php
<?
class DogsController extends ApplicationController{
  function index(){
    //Create an array to hold values to pass to view
    $values = array();
    
    //Get all of the dogs in DB
    $values['dogs'] = $this->db->get("dogs");
    
    //Send array to view
    $this->values = $values;
  }
}
?>
```

Create a blank text document at views/dogs/index.php with the following code:
```php
<?
  foreach ($view_data['dogs'] as $dog) {
    echo $dog['name'].'<br>';
  }
?>
```

Now adding a new record to the database table will make it appear when you navigate to your application.

How does the application know what controller and view to call? The application takes apart the URL and uses the last 1 or 2 components 
in the URL to determine the Controller and Action to call. Example: http://localhost/dogs/show would call the show function in the dogs 
controller. If there is no action passed in via the URL, it defaults to index. Once the function has been called everything will be 
displayed using the layout and view. The layout defaults to "application.php" (This can be changed in the action function). The view 
defaults to /views/controller_name/action_name.php. Example: http://localhost/dogs/show would use the /views/dogs/show.php view file.

RESTful routes are a good way to keep your application organized. Pooch, however, does not force your application to be RESTful. 

This is just a quick overview of a few of the inner workings of the Pooch framework. We are working on more detailed documentation.