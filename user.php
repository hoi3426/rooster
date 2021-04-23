<?php

session_start();
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
    body{ font: 14px sans-serif; text-align: center; }
    </style>

<div class="page-header">

        <!-- Print gebruikersnaam -->

        <h1>Welkom <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
    </div>

    <?php
echo date('d/m/Y H:i:s');

?>
    <br>

    <!-- Uitlog button -->

<p><a href="logout.php" class="btn btn-danger">Uitloggen</a></p>