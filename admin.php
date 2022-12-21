<?php
session_start();

include("functions.php");
include("connection.php");

// $user_data = isLoggedIn($conn);
$user_data = $_SESSION['user_name'];

//$id = 1;
isAdmin($user_data);


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/w3css.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

</head>

<body>
    <?php
    if (isset($_SESSION['delete-message'])) {
        echo $_SESSION['delete-message'];
        unset($_SESSION['delete-message']);
    }

    if (isset($_SESSION['update-message'])) {
        echo $_SESSION['update-message'];
        unset($_SESSION['update-message']);
    }
    ?>
    <div id="box">

        <form method="post" class="w3-container w3-padding">
            <img src="images/approved.png" alt="logo">

            <div style="font-size: 20px; margin: 10px; color: white;">Admin Dashboard</div>
            <div class="adbtn">
                <button id="button" ><a href="adduser.php" class="w3-text-black">Add User</a></button><br><br>
                <!-- <button id="button" class="w3-margin-left w3-margin-right"><a href="index.php">Home</a></button><br><br> -->
                <button id="button"><a href="adminlogout.php" class="w3-text-black">Logout</a></button><br><br>
            </div>
        </form>
    </div>
    <br>

<?php 
$dbquery = "SELECT account_bal FROM users";

$dbresult = mysqli_query($conn, $dbquery);

if($dbresult){

    $count = mysqli_num_rows($dbresult);

    // $dbData = mysqli_fetch_assoc($dbresult);

    $tamount = 0;

    while ($row = mysqli_fetch_assoc($dbresult)){
        $tamount += $row['account_bal'];
    }

}

?>

    <div class="stats w3-row-padding w3-center" style="width: 100%;">
        <div class="stats1 noofusers w3-container w3-green w3-padding w3-round w3-margin w3-col" style="width: 28%;">
       <span><img src="./images/approved.png" alt="pix"></span>     
            <span>
                <h3><?php echo $count?></h3>
                <h6>No of Users</h6>
            </span>

        </div>
        <div class="stats1 totalamount w3-container w3-orange w3-padding w3-round w3-margin w3-col" style="width: 28%;">
        <img src="./images/folders.png" alt="pix">
            <span>
                <h3>N<?php echo number_format($tamount, 0)?></h3>
                <h6>Total Savings</h6>
            </span>

        </div>
        <div class="stats1 profit w3-container w3-yellow w3-padding w3-round w3-margin w3-col" style="width: 28%;">
        <img src="./images/approved.png" alt="pix">
            <span>
                <h3>N<?php echo number_format(($tamount * 0.15), 0)?></h3>
                <h6>Total Profit</h6>
            </span>

        </div>
    </div>

    <div id="chartContainer" style="height: 200px; width: 50%;">


    </div>

    <br>

    <div class="result" style="padding: 20px;">
        <table class="w3-table-all w3-responsive">
            <thead>
                <tr class="w3-light-blue">
                    <th>ID</th>
                    <th>USER ID</th>
                    <th>USER NAME</th>
                    <th>PASSWORD</th>
                    <th>DATE</th>
                    <th>ACCT NO</th>
                    <th>ACCT BAL</th>
                    <th>OPERATION</th>

                </tr>
            </thead>

            <?php
            //Fetch all users from the db
            $sql = "SELECT * FROM users";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_assoc($result)) {

                    if ($row['id'] != 35) {

                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['user_name'] . "</td>";
                        echo "<td>" . substr($row['password'], 30) . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['account_no'] . "</td>";
                        echo "<td>" . $row['account_bal'] . "</td>";
                        echo "<td>";
            ?>

                        <button id="button"><a href="edit.php?editid=<?php echo $row['id'] ?>">Edit</a></button>
                        <button id="button" style="background-color:red"><a href="delete.php?deleteid=<?php echo $row['id'] ?>">Delete</a></button>


                        <!-- echo "<button id='editbtn button'><a href='edit.php?editid='.$row['id'].>Edit</a></button>";
                echo "<button id='delbtn button'><a href='delete.php?deleteid=$id'>Delete</a></button>"; -->

            <?php
                        echo "</td></tr>";
                    }
                }
            } else {
                echo "Query failed : " . mysqli_error($conn);

                echo "<tr><td>{$row['id']}</td>";

                echo "</tr>";
            }

            ?>

        </table>

    </div>


    <?php

    $dataPoints = array(
        array("y" => 100, "label" => "Jan"),
        array("y" => 120, "label" => "Feb"),
        array("y" => 180, "label" => "Mar"),
        array("y" => 380, "label" => "Apr"),
        array("y" => 490, "label" => "May"),
        array("y" => 620, "label" => "Jun"),
        array("y" => 1034, "label" => "Jul")
    );

    ?>

    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "SUMMARY SCOREBOARD"
                },
                axisY: {
                    title: "No of Users"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "#,##0.## tonnes",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();

        }
    </script>
</body>

</html>