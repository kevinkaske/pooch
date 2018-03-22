Pooch Website: [PoochHQ.com](http://www.poochhq.com)

# Pooch
A simple lightweight PHP framework. I created Pooch while building [Where I Give](http://whereigiveapp.com/), an application
to make it easy for none profit organizations to receive donations online.

## About
Pooch is a simple, small PHP framework. Pooch is able to stay tiny by being built to use the amazing
[MysqliDb](https://github.com/joshcam/PHP-MySQLi-Database-Class) database class and built in PHP functionality (for templating).
This framework focuses on convention over configuration. It abuses global variables as a necessary evil to keep code as light and
simple as possible. It works great for prototyping small to medium sized web applications and getting your idea into a functioning
product.

Who should use this framework? Anyone that wants to get an application up and running quickly and focus on their code and not the
framework. If you want a small, light, quick framework and don't mind being tied to MySQL, this framework could be what you have been
looking for.

## Installation
### Installation Process (Detailed Overview)
Installation of pooch is through [composer](https://getcomposer.org). You simply need to create a directory and create a composer.json
file with the following contents:
```json
{
	"minimum-stability": "dev",
	"require": {
		"kevinkaske/pooch": "dev-master"
	}
}
```
Alternatively you can simply download the contents of [this file](https://raw.githubusercontent.com/kevinkaske/pooch/master/setup/base/composer.json)
to your application dir.

Then run `composer install`. Composer will then install the dependent libraries.

Now we need to setup the project. Run the following command `php vendor/kevinkaske/pooch/setup/new_application.php`. Congratulations... Your
project is now ready to go.

Welcome to pooch!

### Installation Example (OSX or Linux)
The following commands will create a pooch application for an application named "pound"
```shell
mkdir pound
cd pound
curl -O https://raw.githubusercontent.com/kevinkaske/pooch/master/setup/base/composer.json
composer install
php vendor/kevinkaske/pooch/setup/new_application.php
```

## Getting Started
### Servers
####Built in PHP Server
A router.php file is included to let you serve your application from PHPs built in server. Simply run the following command
from the application's root directory:
```shell
php -S localhost:8000 router.php
```

#### Apache
A .htaccess file is included by default to route requests through index.php and remove index.php from the URL. If you are using a webserver besides Apache (Nginx for example) you will need to configure it to rewrite the URL and pass the request through index.php.

### Database Setup
We are now ready to hook the database up. You can either use a GUI tool like MySQL Workbench or the MySQL CLI. To create a DB named
"pound" using the CLI type the following:
```shell
mysql -u root -p
CREATE DATABASE pound;
```

You will then need to update the config files to point at this new database. Update the database connection details in both
config/config.php and phinx.yml files.

### Database Migrations
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

### Controllers and Views
We now have a place to store the dogs that are in the dog pound. How are we going to allow people to view, add, and update these dogs?
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

Now manually adding a new record (through a tool like Sequel Pro or MySQL Workbench) to the database table will make it appear
when you navigate to your application.

### Routing
How does the application know what controller and view to call? The application takes apart the URL and uses the last 1 or 2 components
in the URL to determine the Controller and Action to call. Example: http://localhost/dogs/show would call the show function in the dogs
controller.

Is this limiting? Yes. It does, however, make it very fast and easy to keep track of your routes. You will always know what controller
and action is being called.

If there is no action passed in via the URL, it defaults to index. Example: http://localhost/dogs would call the index function in the
dogs controller.

### Layout and Views
Once the correct action/function has been called everything will be displayed using first the layout and then the view. The layout
defaults to "application.php" (This can be changed in the action function). The view defaults to
/views/controller_name/action_name.php. Example: http://localhost/dogs/show would use the /views/dogs/show.php view file.

RESTful routes are a good way to keep your application organized. Pooch, however, does not force your application to be RESTful.
If you would like to call an action function display instead of show, go for it.

### More to Come
This is just a quick overview of a few of the inner workings of the Pooch framework. We are working on more detailed documentation.
