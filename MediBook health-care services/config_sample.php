//first you need to create your database and the related tables
//create a php file called "config" in which you will copy and edit the following code to create connection to the database

<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');//database user is "root" by default unless you changed it
define('DB_PASS', 'PASSWORD');//replace "PASSWORD" with your database password
define('DB_NAME', 'DATABASE');//replace "DATABASE" with the name of your database

//enables exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // Optionally set charset
    // $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    // Optionally log the error
    // error_log('Database connection failed: ' . $e->getMessage());
    echo '<div style="color: red; font-weight: bold; text-align: center; margin-top: 40px;">Sorry, we are experiencing technical difficulties. Please try again later.</div>';
    exit();
}