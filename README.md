Openclassroom-P5

Welcome in your blog php.

{<img src="https://api.codeclimate.com/v1/badges/85b1f6e4963a0243f02c/maintainability" />}[https://codeclimate.com/github/thomasop/monBlog/maintainability]

Prerequisite:
Download Wamp, Xampp or Mamp.

Clone
Go to htdocs directory (or www).

Make a clone with git clone <https://github.com/thomasop/Creez-votre-premier-blog-en-PHP.git and cd Creez-votre-premier-blog-en-PHP> folder.

Install composer with composer install and init the projet with composer init in Creez-votre-premier-blog-en-PHP

Init autoload in Creez-votre-premier-blog-en-PHP in composer.json with 'composer dump-autoload'.

Init swift mailer and twig via composer with 'composer require "swiftmailer/swiftmailer:^6.0"' and 'composer require "twig/twig:^2.0"'.


You can create datebase in PHPMyAdmin with db.sql.
In Class Manager(App/manager/) put 
DBHOST ('mysql:host=localhost;dbname=YOUR NAME;charset=utf8'), 
DBUSER('root'), 
DBPASS('root' or '' for wamp).

For send Email in Home page create a Gmail and in treatment.php put your Username(setUsername()) and Password(setPassword()) in transport and you can edit message if you want.