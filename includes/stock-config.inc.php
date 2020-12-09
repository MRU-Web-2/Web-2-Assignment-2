<?php
// set error reporting on to help with debugging
error_reporting(E_ALL);
ini_set('display_errors', '1');

// you may need to change these for your own environment
define('DBCONNECTION',  getenv('MYSQL_DSN'));
define('DBUSER', getenv('MYSQL_USER'));
define('DBPASS',  getenv('MYSQL_PASSWORD'));

// auto load all classes so we don't have to explicitly include them
spl_autoload_register(function ($class) {
  $file = 'lib/' . $class . '.class.php';
  if (file_exists($file))
    include $file;
});
