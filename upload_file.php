<?php
session_start();

include("functions.php");
include("connection.php");

$user_data = isLoggedIn($conn);
$uid = $user_data['id'];

//echo "user id is : " . $user_data['id'];

if (isset($_POST['upload'])) {

    if ($_FILES['file']['size'] !== 0) {

        $imageTypes = array('jpg','jpeg', 'png', 'gif', 'pdf');

        if(in_array(strtolower(explode('.', $_FILES['file']['name'])[1]), $imageTypes)){
        $fileName = cleanData($_FILES['file']['name']);
        $fileTempName = $_FILES['file']['tmp_name'];
        $fileType = explode('/', $_FILES['file']['type'])[1];
        $fileSize = $_FILES['file']['size'];
        $fileError = $_FILES['file']['error'];


        $fileCoreName = explode(".", $fileName)[0];
        $fileExtension = strtolower(explode(".", $fileName)[1]);

        $imageblob =addslashes(file_get_contents($fileTempName));
        //echo $imageblob;
        // echo $fileName . "<br>";
        // echo $fileTempName . "<br>";
        // echo $fileType . "<br>";
        // echo $fileSize . "<br>";
        // echo $fileCoreName . "<br>";
        // echo $fileExtension . "<br>";
        // echo $fileError . "<br>";


        $fileNewPath = "uploads/" . $fileCoreName . uniqid() . "." . $fileExtension;

        // echo $fileNewPath . "<br>";
        // //echo pathinfo($fileNewPath, 0);
        // echo "<br>";
        // echo pathinfo($fileNewPath, PATHINFO_DIRNAME);
        // echo "<br>";
        // echo pathinfo($fileNewPath, PATHINFO_BASENAME);
        // echo "<br>";
        // echo pathinfo($fileNewPath, PATHINFO_FILENAME);
        // echo "<br>";
        // echo pathinfo($fileNewPath, PATHINFO_EXTENSION);
        // echo "<br>";
        // echo basename($fileNewPath);
        // echo "<br>";
        // echo dirname($fileNewPath);


        //Upload the file into the upload folder
               //move_uploaded_file($fileTempName, $fileNewPath);


        //Convert image to blob and insert into DB
        //$profilePix = addslashes(file_get_contents($fileNewPath));
       // echo $imageblob;

        $pixquery = "update users set image='$imageblob' where id=$uid";
        $pixresult = mysqli_query($conn, $pixquery);

        if($pixresult){
            echo "Profile picture successfully updated for this user";
        }else{
            echo "Profile picture failed to updated for this user";
        }

        }else{
            echo "Failed: only jpg, jpeg, gif and pdf are allowed";
        }
    } else {
        echo "Please attach a file";
    }
} else {
    echo "Failed. Issue with upload button code or name";
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
        <form method="post" enctype="multipart/form-data">
            <img src="images/approved.png" alt="logo">
            <div style="font-size: 20px; margin: 10px; color: white;">Upload File</div>
            <br><br>
            <input id="file" type="file" name="file"><br><br>
            <input id="button" type="submit" name="upload" value="Upload"><br><br>
            <a href="index.php">Go Back</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <!-- File Preview -->
            <div class="filepreview">
                <img src="<?php echo $fileNewPath ?>" alt="" width="200px" height="100px">
            </div>
        </form>
    </div>
    <br><br>



</body>

</html>