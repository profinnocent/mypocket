<?php
session_start();

include("functions.php");
include("connection.php");

$user_data = $_SESSION['user_name'];

isAdmin($user_data);


if (isset($_POST['add'])) {

    //Declare variables
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_DEFAULT);
    //


    //Validate user inputs
    if (!empty($user_name) && !empty($password)) {

        //Check if user is already in DB
        $sql = "select user_name from user where user_name='$user_name'";

        $sql_result = mysqli_query($conn, $sql);

        echo $sql_result;

        if ($sql_result) {
            echo "Username already exists. Please chose anotehr user_name.";
        } else {

            $user_id = uniqid();
            $account_no = uniqid("10", true);
            
            //Prepre query
            $query = "insert into users (user_id, user_name, password,account_no) values('$user_id', '$user_name', '$password', '$account_no')";

            //Query DB
            $result = mysqli_query($conn, $query);

            if ($result) {
                $_SESSION['signup_success'] = "New user succesfully created";

                header("Location: admin.php");
            } else {
                echo "Username already exist. Please chose another username.";
            }
        }
    } else {

        echo "Please fill in btoh username and password";
    }
} else {

   // echo 'Post not set';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div id="box">
        <form method="post">
            <img src="images/approved.png" alt="logo">

            <div style="font-size: 20px; margin: 10px; color: white;">Add New User</div>
            <input id="text" type="text" name="user_name" placeholder="Username" autocomplete="off"><br><br>
            <input id="text" type="password" name="password" placeholder="Password" autocomplete="off"><br><br>
            <input id="button" type="submit" name="add" value="Add"><br><br>
            <a href="admin.php">Back</a>
        </form>
    </div>
</body>

</html>