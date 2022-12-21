<?php
session_start();

include("connection.php");
include("functions.php");

$userdata = isLoggedIn($conn);

$id = $_GET['deleteid'];

if($id == 35){
    $_SESSION['delete-message'] = "Sorry you have no authorisation to delete this user";
    header("location: admin.php");
}else{
    $query = "delete from users where id=$id";

$result = mysqli_query($conn, $query);

if($result){
    $_SESSION['delete-message'] = "User deleted successfully";
    header("Location: admin.php");
}else{
    die("Failed to delete");
}

}

?>