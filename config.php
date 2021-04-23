<link rel="stylesheet" href="css/style.css">
<?php

// Iblog gegevens database

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'roeman');
define('DB_PASSWORD', 'roeman123');
define('DB_NAME', 'login');

// Proberen verbinding te maken

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false)
{
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>
