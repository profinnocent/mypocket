<?php
session_start();

include("functions.php");
include("connection.php");

if(isset($_POST['submit'])){

    //Declare password to hold user inputs
    $user_name = cleanData($_POST['user_name']);
    $password = cleanData($_POST['password']);

    //Prepapre query
    $query = "select * from users where user_name = '$user_name'";

    //Execute Query on DB
    $result = mysqli_query($conn, $query);

    //Format result
    if(mysqli_num_rows($result) > 0){

        //First convert the result into a searchable associative array
        $user_data = mysqli_fetch_assoc($result);
        $password2 = $user_data['password'];


        if(password_verify($password, $password2 )){

            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['user_name'] = $user_data['user_name'];


           
            //Differentiate user from admin
            if($user_data['user_name'] === "Admin"){
                header("location: admin.php");
            }else{
                header("location: index.php");
            }

        }else{
            echo "User details you supplied are not correct";
        }

    }else{
        echo "User was not found. Pls check the info youn supplied or register";
    } 


}else{
    // echo "POST is not set";
}


//Display success message from password reset page
if(isset($_SESSION['reset_success_message'])){

    echo $_SESSION['reset_success_message'];
    unset($_SESSION['reset_success_message']);
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
                <div style="font-size: 20px; margin: 10px; color: white;">Login</div>
                <br><br>
                <input id="text" type="text" name="user_name" placeholder="Username"><br><br>
                <input id="text" type="password" name="password" placeholder="Password"><br><br>
                <input id="button" type="submit" name="submit" value="login"><br><br>
                <a href="signup.php">Click to  SignUp</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="reset.php">Forget password?</a>
            </form>
        </div>
        <br><br>


        <?php 
        if(isset($_SESSION['signup_success'])){
        echo $_SESSION['signup_success'];
        unset($_SESSION['signup_success']);
        }
        $getmessage = $_GET['message'];
        echo `div.w3-alert <w3-alert-success>
            if(isset($getmessage)){
                <p>echo $getmessage</p>
            }
        </w3-alert-success>`;
        ?>
   </body>
   </html>