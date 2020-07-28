<?php
$err=false;
$showerror=false;

// ACCEPTING THE REQUEST SENT FROM THE PAGE signup.php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    // CONNECTING TO THE DATABASE
    include 'partition/_dbconnect.php';
    // INITIALIZING THE VALUES POSTED BY THE FORM TO VARIABLES
    $username=$_POST['name'];
    $password = md5($_POST['pass']);
    $email = $_POST['email'];
    $number=$_POST['no'];
    $existSql= 'SELECT * FROM `expandature`.`users` WHERE email="'.mysqli_real_escape_string($conn,$email).'"';
    $result=mysqli_query($conn,$existSql);
    echo var_dump($result);
    $numExistRows=mysqli_num_rows($result);
    // CHECK WHETHER EMAIL ALREADY EXIT IN THE DB OR NOT
    if($numExistRows > 0)
    {
        $showerror="Email already exists";
    }
    // CHECKING VALIDATION OF PHONE NUMBER
    else if(strlen($number)>10)
    {
        $showerror="Enter valid phone number";
    }
    // CHECKING VALIDATION OF EMAIL
    else
    {
        $regex_email="/^([a-zA-Z0-9+-._%'=?#]+@+[a-z0-9.-]+(\.)+[a-z]{2,3})$/";
        if(!preg_match($regex_email,$email))
        {
            $showerror="Enter correct email address ";
        }
        else
        {
            if(filter_var($email,FILTER_VALIDATE_EMAIL))
            {
                $email=mysqli_real_escape_string($conn,$email);
                $hash=password_hash($password, PASSWORD_DEFAULT);
                $sql  = "INSERT INTO `users`(`name`,`email` ,`password`,`number`,`dt`) VALUES ('$username','$email','$hash','$number',current_timestamp())";
                $result=mysqli_query($conn,$sql);
                if($result)
                {
                    $err=true;
                }
                else
                {
                    // $showerror="Please Enter correct Name";
                    die($numExistRows);
                }
            }
            else
            {
                $showerror="Email is not valid";
            }
        }
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

    <!-- ADDING HEADER -->

    <?php include "partition/_navbar.php" ?>

    <!-- THIS IS ERROR MESSAGE WHICH WILL BE SHOWN IF THE SIGNUP FORM IS NOT SUBMITTED CORRECTLY -->

    <?php
        if($err)
            {
                echo '
                        <div class="alert alert-success alert-dismissible fade in" role="alert">
                            <strong>Success!</strong> Your account is now created and you can login
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';
            }
        if($showerror)
            {
                echo '
                        <div class="alert alert-danger alert-dismissible fade in" role="alert">
                            <strong>Error!</strong>'.$showerror.'
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    ';
            }
    ?>

    <!-- THIS IS ERROR MESSAGE WHICH WILL BE SHOWN IF THE SIGNUP FORM IS NOT SUBMITTED CORRECTLY -->

    <!-- START OF SIGNUP FORM -->

    <div id="content" style="min-height: 571px;">
        <div class="container-fluid decor_bg" id="login-panel">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel" style="border-radius: 10px;">
                        <div class="panel-heading" style="text-align: center; border-bottom:1px solid #d3cfcf;">
                            <h4>SIGN UP</h4>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="/signup.php" method="POST">
                                <div class="form-group">
                                    <label for="name">Name:</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" id="name"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" placeholder="Enter Valid Email"
                                        name="email" id="email" pattern="[A-Za-z0-9._%+-'#=?]+@[a-z0-9.-]+\.[a-z]{2,3})$" required>
                                </div>
                                <div class="form-group">
                                    <label for="pass">Password:</label>
                                    <input type="password" class="form-control" minlength="6"
                                        placeholder="Password (Min: 6 charecters)" name="pass" id="pass" required>
                                </div>
                                <div class="form-group">
                                    <label for="no">Phone Number:</label>
                                    <input type="number" class="form-control"
                                        placeholder="Enter Valid Phone Number (Ex: 8448444853)" name="no" id="no" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-block"
                                    style="background-color: #11742edb; color: white;">Sign Up</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- END OF SIGNUP FORM -->
    <!-- ADDING FOOTER -->

    <?php include "partition/_footer.php" ?>

    <!-- ADDING FOOTER -->
</body>

</html>