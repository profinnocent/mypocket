<?php
session_start();

include("functions.php");
include("connection.php");

$user_data = isLoggedIn($conn);

if($user_data['image'] === null){
    $userpix = "images/folders.png";
}else{
    $userpix = $user_data['image'];
}

//Handle Deposit transaction
if(isset($_POST['deposit'])){

    if(!empty($_POST['amount'])){
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_INT);
    $amount = cleanData($amount);
    $amount = abs($amount);

    $newBalance = $user_data['account_bal'] + $amount;
    $id = $user_data['id'];
    
    $sql = "update users set account_bal=$newBalance where id=$id";

    $result = mysqli_query($conn, $sql);

    if($result){
        header("Refresh: 1");
        echo "Updated User account balance successfully";
        
    }else{
        echo "Update unsuccessful, please your entry again";
    }

    }else{
        echo "Please input a valid amount";
    }

}else{
   // echo "Deposit is not set";
}


//Handle Withdraw transaction
if(isset($_POST['withdraw'])){

    if(!empty($_POST['amount'])){
    $amount = filter_var($_POST['amount'], FILTER_VALIDATE_INT);
    $amount = abs($amount);

    //Check for sufficient balance
    if($user_data['account_bal'] < $amount){ 
        echo "You dont have sufficient Account Balance to make this transaction";
    }else{
        $newBalance = $user_data['account_bal'] - $amount;
    $id = $user_data['id'];
    
    //Update DB with newBalance
    $sql = "update users set account_bal=$newBalance where id=$id";

    $result = mysqli_query($conn, $sql);

    if($result){
        header("Refresh: 1");
        echo "Updated User account balance successfully";
    }else{
        echo "Update unsuccessful, please your entry again";
    }
    }   
    

    }else{
        echo "Please input a valid amount";
    }


}else{
    //echo "Deposit is not set";
}

?>

<!DOCTYPE html>
   <html lang="en">
   <head>
       <meta charset="UTF-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <title>PHP LOGIN</title>
<link rel="stylesheet" href="css/style.css">
   </head>
   <body>
        <div id="box">

            <form method="post">
            <img src="images/approved.png" alt="logo">

                <div style="font-size: 20px; margin: 10px; color: white;">Home</div>
                <h1 style="text-align:center ;">Welcome to your Dashboard</h1><br>

                <img id="propix" src="data:image/jpg;base64,<?php echo base64_encode($userpix) ?>" alt="+" style="border-radius: 50%; background-color:aquamarine">
                <a href="upload_file.php">Upload Picture</a>
                <br>
                <h3>Hello, <span class="username"><?php echo $user_data['user_name'] ?></span> </h3><br>
                <a href="logout.php">Log Out</a>
<br>
                <div class="account">
                <div class="display">
                    <h5>Account balance:</h5>
                    <div>
                    <span><b>N </b></span><span id="balance"><?php echo number_format($user_data['account_bal'],2) ?></span>
                    </div>
                    <br><br>
                    <div>
                    <input type="number" name="amount" id="amount" placeholder="Enter Amount">
                    </div>
                    <br>
                    <div>
                    <button type="submit" id="depbtn" name="deposit">Deposit</button>
                    <button type="submit" id="witbtn" name="withdraw">Withdraw</button>
                    </div>
                </div>

            </div>
            </form>
          
        </div>
   </body>
   </html>