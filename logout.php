<?php
session_start();


    session_unset();

    session_destroy();

    $message = "You have been logged out successfully";
    header("Location: login.php");


?>