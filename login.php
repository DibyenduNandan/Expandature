<?php
$login=false;
$showerror=false;

// THIS WILL TAKE THE REQUEST SEND BY THE LOGIN FORM

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partition/_dbconnect.php';
    $email=$_POST['email'];
    $password = md5($_POST['pass']);
    $sql  = 'SELECT * FROM users  where email="'.mysqli_real_escape_string($conn,$email).'"';
    $result=mysqli_query($conn,$sql);
    $num=mysqli_num_rows($result);
    if($num ==1){
        while($row=mysqli_fetch_assoc($result))
        {
            if(password_verify($password,$row['password']))
            {
            $login=true;
            session_start();
            $_SESSION['err']=false;
            $_SESSION['toggle']=false;
            $_SESSION['loggedin']=true;
            $_SESSION['email']=$email;
            header("location:welcome.php");
            }
            else
            {
                $showerror="Password donot match";
            }
        }
    }
    else
    {
        $showerror="Your account is not created Please create it before login Or If you have signed in please enter correct mail id";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Life Style Store</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color: #e7e6e6;">

    <!-- HEADER -->

    <?php include "partition/_navbar.php" ?>

    <!-- HEADER ENDS -->

    <!-- THIS IS THE ERROR MESSAGE WHICH WILL BE SHOWN IF LOGIN FORM DOSENOT SUCCESSFULLY SUBMITTED -->

    <?php
    if($login){
        echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
                <strong>Success!</strong> Your accoint is now created and you can login
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
              </div>';
    }
    if($showerror){
    echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
            <strong>Error!</strong>'.$showerror.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
    }
    ?>

    <!-- THIS IS THE ERROR MESSAGE WHICH WILL BE SHOWN IF LOGIN FORM DOSENOT SUCCESSFULLY SUBMITTED ENDS-->

    <!-- FORM BODY STARTS -->

    <div id="content" style="min-height: 571px;">
        <div class="container-fluid decor_bg" id="login-panel">
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel">
                        <div class="panel-heading" style="text-align: center; border-bottom:1px solid #d3cfcf;">
                            <h4>LOGIN</h4>
                        </div>
                        <div class="panel-body">
                            <form role="form" action="/login.php" method="POST">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" placeholder="Email"
                                        name="email" id="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="pass">Password:</label>
                                    <input type="password" class="form-control" minlength="6"
                                        placeholder="Password" name="pass" id="pass" required>
                                </div>
                                <button type="submit" name="submit" class="btn btn-block"
                                    style="background-color: #11742edb; color: white;">Login</button>
                            </form>
                        </div>
                        <div class="panel-footer">
                            <p>Don't have an account? <a href="signup.php">Click here to Sign Up</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FORM BODY ENDS -->

    <!-- FOOTER -->

    <?php include "partition/_footer.php" ?>

    <!-- FOOTER ENDS -->
</body>

</html>