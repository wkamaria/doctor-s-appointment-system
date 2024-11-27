<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Doctor</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (isset($_SESSION["user"])) {
        if ($_SESSION["user"] == "" || $_SESSION['usertype'] != 'a') {
            header("location: ../login.php");
        }
    } else {
        header("location: ../login.php");
    }

    // Import database
    include("../connection.php");

    if ($_POST) {
        $name = $_POST['name'];
        $nic = $_POST['nic'];
        $spec = $_POST['spec'];
        $email = $_POST['email'];
        $tele = $_POST['Tele'];
        $location = $_POST['location']; // New field
        $hospital = $_POST['hospital']; // New field
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        
        if ($password == $cpassword) {
            $error = '3';
            $result = $database->query("SELECT * FROM webuser WHERE email='$email';");
            if ($result->num_rows == 1) {
                $error = '1';
            } else {
                $sql1 = "INSERT INTO doctor (docemail, docname, docpassword, docnic, doctel, specialties, location, hospital) 
                         VALUES ('$email', '$name', '$password', '$nic', '$tele', '$spec', '$location', '$hospital');";
                $sql2 = "INSERT INTO webuser (email, usertype) VALUES ('$email', 'd')";
                
                $database->query($sql1);
                $database->query($sql2);

                $error = '4';
            }
        } else {
            $error = '2';
        }
    } else {
        $error = '3';
    }

    header("location: doctors.php?action=add&error=" . $error);
    ?>
</body>
</html>
