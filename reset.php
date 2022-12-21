<?php
session_start();

//include("functions.php");
include("connection.php");

//Display error from password reset page
if(isset($_SESSION['reset_error_message'])){
    echo $_SESSION['reset_error_message'];

    echo "<br><br>";

    unset($_SESSION['reset_error_message']);
}

$newpassword = "";

if(isset($_POST['submit'])){

    //Declare password to hold user inputs
    $user_name = $_POST['user_name'];
    
    //Prepapre query
    $query = "select * from users where user_name = '$user_name'";

    //Execute Query on DB
    $result = mysqli_query($conn, $query);

    //Format result
    if($result && mysqli_num_rows($result) > 0){

        //First convert the result into a searchable associative array
        $user_data = mysqli_fetch_assoc($result);

        //echo $user_data['password'] . "<br><br>";

        $userResetPass = $user_data['password'];

        $userResetPass1 = substr($userResetPass, 11);

        //echo $userResetPass1 . "<br><br>";

        $userResetPass2 = strrev($userResetPass1);

        echo "This is your OTP reset code : " . $userResetPass2 . "<br><br>";

        echo "Copy the One-time password reset code and go to the Change Password page.<br><br><br>";


        // if($user_name == $user_data['user_name'] && password_verify($password, $user_data['password'])){

        //     $_SESSION['user_id'] = $user_data['user_id'];
        //     header("location: index.php");

        // }else{
        //     echo "User details you supplied are not correct";
        // }

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

                <div style="font-size: 20px; margin: 10px; color: white;">Reset Password</div>
               <p>Enter your Username to get a password reset code.</p>
                <input type="text" name="user_name" placeholder="Enter Username">
                <br><br>
                <input id="button" type="submit" name="submit" value="Reset"><br><br>
                <a href="login.php">Back to Login</a>
                <br/><br>            
                <a href="reset2.php">Go to Change Password</a>

            </form>
        </div>
   </body>
   </html>