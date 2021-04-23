<?php
session_start();
require ("config.php");

if (isset($_GET['did']))
{
    $delete_id = mysqli_real_escape_string($link, $_GET['did']);
    $sql = mysqli_query($link, "DELETE FROM reserveringen WHERE ID = '" . $delete_id . "'");
    if ($sql)
    {
        header("Location: welcome.php");
        die();
    }
    else
    {
        echo "ERROR";
    }
}
?>
