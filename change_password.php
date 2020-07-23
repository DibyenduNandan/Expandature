<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}
$err=false;
$showerror=false;

// THIS WILL TAKE THE POST REQUEST SEND BY THE FORM IN THIIS PAGE

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partition/_dbconnect.php';
    $password = md5($_POST['pass']);
    $npassword = $_POST['npass'];
    $repassword = $_POST['repass'];
    $email=mysqli_real_escape_string($conn,$_SESSION['email']);
    $Sql= "SELECT `password` FROM `expandature`.`users` WHERE email='$email'";
    $result=mysqli_query($conn,$Sql);
    $row=mysqli_fetch_assoc($result);
    if(password_verify($password,$row['password'])){
        if(strcmp($npassword,$repassword)==0){
            $hash=password_hash(md5($npassword), PASSWORD_DEFAULT);
            $sql  = "UPDATE `users`SET `password` = '$hash' WHERE `email`='$email'";
            $result=mysqli_query($conn,$sql);
            $err="Password changed";
            $_SESSION['err']=$err;
            header("location:welcome.php");
        }
        else{
            $showerror="Please correctly enter confirm password";
        }
    }
    else
    {
        $showerror="Password dosenot matched! Please enter correct password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup | Life Style Store</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color: #e7e6e6;">

    <!-- HEADER -->

    <?php include "partition/_navbar.php" ?>

    <!-- HEADER -->

    <!-- This error message will be shown when password cannot be changed successfully -->

    <?php
        if($showerror)
            {
                echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                        <strong>Error!</strong>'.$showerror.'
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>';
            }
    ?>

    <!-- Start of main content of the page i.e: Password changing form -->

    <div id="content" style="min-height: 571px;">
        <div class="container-fluid decor_bg" id="login-panel">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel" style="border-radius: 10px;">
                        <div class="panel-heading" style="text-align: center; border-bottom:1px solid #d3cfcf;">
                            <h4>Change Password</h4>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="/final/change_password.php" method="POST">
                                <div class="form-group">
                                    <label for="pass">Old Password:</label>
                                    <input type="password" class="form-control" minlength="6"
                                        placeholder="Old Password" name="pass" id="pass" required>
                                </div>
                                <div class="form-group">
                                    <label for="npass">New Password:</label>
                                    <input type="password" class="form-control" minlength="6"
                                        placeholder="New Password (Min: 6 charecters)" name="npass" id="npass" required>
                                </div>
                                <div class="form-group">
                                    <label for="repass">Confirm New Password:</label>
                                    <input type="password" class="form-control" minlength="6"
                                        placeholder="Re-type New Password" name="repass" id="repass" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-block"
                                    style="background-color: #056e58db; color: white;">Change</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Start of main content of the page i.e: Password changing form -->
    <!-- FOOTER -->
    <?php include "partition/_footer.php" ?>

    <!-- FOOTER -->
</body>

</html>