<?php
session_start();

include("functions.php");
include("connection.php");

$user_data = isLoggedIn($conn);

isAdmin($user_data);


//Get user id from url
$id = $_GET['editid'];
//echo $id;

$queryid = "select * from users where id=$id";

$resultid = mysqli_query($conn, $queryid);

if($resultid){
    $userdetails = mysqli_fetch_assoc($resultid);

    //Userdetails from url id
$uid = $userdetails['id'];
$uuserid = $userdetails['user_id'];
$uname = $userdetails['user_name'];
$upass = $userdetails['password'];
$uacctno = $userdetails['account_no'];
$uacctbal = $userdetails['account_bal'];

}


if (isset($_POST['save'])) {

    //Declare variables
    $acctbalance = $_POST['account_bal'];
    //$password = $_POST['password'];
    //$password = password_hash($password, PASSWORD_DEFAULT);



    //Validate user inputs
    if (!empty($acctbalance)) {

        //Check if user is already in DB
        $sql = "update users set account_bal=$acctbalance where id='$uid'";

        $sql_result = mysqli_query($conn, $sql);


        if ($sql_result) {
            $_SESSION['update-message'] = "User updated successfully";

        } else {
            $_SESSION['update-message'] = "Failed to update user" . mysqli_error($conn);
        }

        header("Location: admin.php");


    } else {

        echo "Please enter a valid account balance";
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

            <div style="font-size: 20px; margin: 10px; color: white;">Edit User</div>
            <input id="text" type="number" name="id" placeholder="id" value=<?php echo $uid ?> disabled><br><br>
            <input id="text" type="text" name="user_id" placeholder="Username" value=<?php echo $uuserid ?> disabled><br><br>

            <input id="text" type="text" name="user_name" placeholder="Username" value=<?php echo $uname ?> disabled><br><br>
            <input id="text" type="password" name="password" placeholder="Password" value=<?php echo $upass ?> disabled><br><br>
            
            <input id="text" type="number" name="account_no" placeholder="Account Number" value=<?php echo $uacctno ?> disabled><br><br>
            <input id="text" type="number" name="account_bal" placeholder="Account Balance" value=<?php echo $uacctbal ?>><br><br>

            <input id="button" type="submit" name="save" value="Save"><br><br>
            <a href="admin.php">Back to Adminpage</a>
        </form>
    </div>
</body>

</html>