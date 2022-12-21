<?php
session_start();

//include("functions.php");
include("connection.php");

//$newpassword = "";

if(isset($_POST['submit'])){

    //Declare password to hold user inputs
    $user_code = $_POST['user_code'];
    $user_name = $_POST['user_name'];
    $user_new_password = $_POST['user_new_password'];
    $user_new_password2 = $_POST['user_new_password2'];

    echo $user_name . "<br>";
    
    //Prepapre query
    $query = "select password from users where user_name = '$user_name'";

    //Execute Query on DB
    $result = mysqli_query($conn, $query);

    //Format result
    if($result && mysqli_num_rows($result) > 0){

        //First convert the result into a searchable associative array
        $user_data = mysqli_fetch_assoc($result);

        //print_r($user_data['password']);

        echo "<br><br>";

        $user_data1 = substr($user_data['password'], 11);

        $user_data2 = strrev($user_data1);


        //Compare and cofirm if reset code is correct for the user
        if($user_data2 === $user_code){

            $user_new_passwordx = password_hash($user_new_password, PASSWORD_DEFAULT);

            $queryset = "update users set password='$user_new_passwordx' where user_name='$user_name' ";

            $result2 = mysqli_query($conn, $queryset);

           if($result2){

                $_SESSION['reset_success_message'] = "Password successfully updated. You can login now with your new password.";

                header("Location: login.php");
            }

        }else{
            echo "Rassowrd reset code is invalid, please reset again.";

            $_SESSION['reset_error_message'] = "Rassowrd reset code is invalid, please reset again.";

            header("Location: reset.php");
        }

    }else{
        echo "Sorry, your Username was not found.";
    } 


}else{
    //echo "POST is not set";
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

                <div style="font-size: 20px; margin: 10px; color: white;">Change Password</div>
               <p>Enter your one-time code and your new password.</p>
                <input type="text" name="user_code" placeholder="Enter reset code">
                <br><br>
                <input type="text" name="user_name" placeholder="Enter Username">
                <br><br>
                <input type="text" name="user_new_password" placeholder="Enter new password">
                <br><br>
                <input type="text" name="user_new_password2" placeholder="Confirm new password">
                <br><br>
                <input id="button" type="submit" name="submit" value="Change"><br><br>
                <a href="login.php">Back to Login</a>
            </form>
        </div>
   </body>
   </html>