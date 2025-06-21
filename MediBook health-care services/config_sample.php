//first you need to create your database and the related tables
//create a php file called "config" in which you will copy and edit the following code to create connection to the database

<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');//database user is "root" by default unless you changed it
define('DB_PASS', 'PASSWORD');//replace "PASSWORD" with your database password
define('DB_NAME', 'DATABASE');//replace "DATABASE" with the name of your database

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}