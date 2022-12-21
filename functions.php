<?php

function isLoggedIn($conn){
    if(isset($_SESSION['user_id'])){

        //Assign the user session id to a variable
        $id = $_SESSION['user_id'];

        //Design the query
        $query = "SELECT * FROM users WHERE id = '$id'";

        //Query the DB
        $result = mysqli_query($conn, $query);

        //Check if any result returned
        if($result){

            //Convert the result into an associative array so we can be able to search it
            $user_data = mysqli_fetch_assoc($result);
            //$_SESSION['user_name'] = $user_data['user_name'];
            return $user_data;
        }
        

    }else{

        $message = "Plaese login first.";
        header("Location: login.php?message=".$message);

    }
}


//Protect Admin page
function isAdmin($ud){
    if($ud != "Admin"){

        session_unset();
        session_destroy();
        header("Location: index.php");

    }
}


//Clean data inputs
function cleanData($data){
    $dataOut = htmlspecialchars($data);
    $dataOut = stripslashes($dataOut);
    $dataOut = strip_tags($dataOut);
    $dataOut = trim($dataOut);

    return $dataOut;
}

