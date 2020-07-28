<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}
$_SESSION['toggle']=false;

// THIS WILL TAKE THE REQUEST SEND BY THE ADD NEW PLAN FORM
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'partition/_dbconnect.php';
    $amount=$_POST['num'];
    $people = $_POST['num2'];
    $email=mysqli_real_escape_string($conn,$email);
    $_SESSION['people']=$people;
    $_SESSION['amount']=$amount;
    $sql  = "INSERT INTO `budget`(`email` ,`initial_budget`,`no_of_people`) VALUES ('$email','$amount','$people')";
    $result=mysqli_query($conn,$sql);
    if($result){
        header("location:plan_details.php");
    }
    else{
        echo "Cannot Stored in the database";
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
    <link href="css/nav_plan.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

    <!-- HEADER -->

    <?php include "partition/_navbar.php" ?>

    <!-- HEADER ENDS-->
    <!-- FORM FOR CREATING NEW PLAN -->
    <div class="container-fluid decor_bg">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel">
                    <div class="panel-heading">
                        <h4>Create New Plan</h4>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="/new_plan.php" method="POST">
                            <div class="form-group">
                                <label for="num">Initial Budget</label>
                                <input type="number" class="form-control" placeholder="Initial Budget(Ex: 4000)"
                                    name="num" id="num" required>
                            </div>
                            <div class="form-group">
                                <label for="num2">How many people you want to add in your page?</label>
                                <input type="number" class="form-control" placeholder="No of people" name="num2"
                                    id="num2" required>
                            </div>
                            <button type="submit" name="submit"
                                class="btn btn-block btn-outline-success btn-default">
                                    <!-- <a href="plan_details.php"> -->
                                        Next
                                    <!-- </a> -->
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- FORM FOR CREATING NEW PLAN ENDS-->
    </div>

    <!-- FOOTER -->

    <?php include "partition/_footer.php" ?>

    <!-- FOOTER ENDS -->

</body>

</html>