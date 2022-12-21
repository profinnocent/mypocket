<?php
session_start();

include("functions.php");
include("connection.php");



if (isset($_POST['submit'])) {

    //Declare variables
    $user_name = cleanData($_POST['user_name']);
    $password = cleanData($_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);
    //

    // Ensure no one can register with any user name that containes the word 'admin'
    if($user_name == 'Admin'){

        $message = "You can not use this username.";
        header('Location: signup.php?message='.$message);
        exit;
    }

    //Validate user inputs
    if (!empty($user_name) && !empty($password)) {

        //Check if user is already in DB
        $sql = "select user_name from user where user_name='$user_name'";

        $sql_result = mysqli_query($conn, $sql);

        // echo $sql_result;

        if ($sql_result) {
            echo "Username already exists. Please chose anotehr user_name.";
        } else {

            $user_id = uniqid();
            $account_no = rand(1000000000, 9999999999);

            //Prepre query
            $query = "insert into users (user_id, user_name, password, account_no) values('$user_id', '$user_name', '$password','$account_no')";

            //Query DB
            $result = mysqli_query($conn, $query);

            if ($result) {
                $_SESSION['signup_success'] = "New user succesfully created";

                header("Location: login.php");
                return false;
            } else {
                echo "Username already exist. Please chose another username.";
            }
        }
    } else {

        echo "Please fill in btoh username and password";
    }
} else {

    //echo 'Post not set';
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

            <div style="font-size: 20px; margin: 10px; color: white;">Sign Up</div>
            <input id="text" type="text" name="user_name" placeholder="Username"><br><br>
            <input id="text" type="password" name="password" placeholder="Password"><br><br>
            <input id="button" type="submit" name="submit" value="Sign Up"><br><br>
            <a href="login.php">Back to Login</a>
        </form>
    </div>
</body>

</html>