<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}
$_SESSION['toggle']=false;
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    include 'partition/_dbconnect.php';
    $title=$_POST['title'];
    $date1 = $_POST['date'];
    $date2 = $_POST['date2'];
    $i=1;
    $d=[];
    while($i<=$_SESSION['people']){
        $people=$_POST["per$i"];
        $d[$i]=$people;
        $i=$i+1;
    }
    $sql='SELECT `sno` FROM `budget` WHERE `initial_budget`="'.$_SESSION['amount'].'"';
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result)){
        $sql2='SELECT * FROM `budget_details` WHERE `sno`="'.$row['sno'].'"';
        $s=$row['sno'];
        $result2=mysqli_query($conn,$sql2);
        $row1=mysqli_fetch_assoc($result2);
        if($row1==0){
            $a=serialize($d);
            $sql3  = "INSERT INTO `budget_details`(`sno` ,`title`,`from_dt`,`to_dt`,`person`) VALUES ('$s','$title','$date1','$date2','$a')";
            $result3=mysqli_query($conn,$sql3);
            if($result3){
                header("location:welcome.php");
            }
            else{
                echo "Cannot Stored in the database";
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
    <link href="css/nav_plan.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

    <!-- HEADER -->
    <?php include "partition/_navbar.php" ?>
    <!-- HEADER ENDS -->
    <!-- THIS IS THE FORM WHICH WILL TAKE PLAN DETAILS -->
    <div class="container-fluid decor_bg">
        <div class="row">
            <div class="col-md-5" style="margin-left: 27%;">
                <div class="panel">
                    <div class="panel-body">
                        <form role="form" action="/final/plan_details.php" method="POST">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" placeholder="Enter Title(Ex: Trip to Goa)"
                                    name="title" id="title" required>
                            </div>
                            <div class="cont" style="display: flex; font-weight: lighter;">
                                <div class="form-group" style="min-width: 50%; margin-right: 2%;">
                                    <label for="date" style="display: block;">From</label>
                                    <input type="date" name="date" id="date" style="min-width: 95%;" required>
                                </div>
                                <div class="form-group" style="min-width: 50%;">
                                    <label for="date2" style="display: block;">To</label>
                                    <input type="date" name="date2" id="date2" style="min-width: 95%;" required>
                                </div>
                            </div>
                            <?php
                            $i=1;
                            echo '
                                    <div class="cont" style="display: flex;">
                                        <div class="form-group" style="min-width: 60%; margin-right: 4%;">
                                            <label for="num">Initial Budget</label>
                                            <input type="number" class="form-control" placeholder="'.$_SESSION['amount'].'"
                                                name="num" id="num" style="min-width: 95%;" readonly>
                                        </div>
                                        <div class="form-group" style="min-width: 30%;">
                                            <label for="num2">No of peoples</label>
                                            <input type="number" class="form-control" placeholder="'.$_SESSION['people'].'" name="num2"
                                                id="num2" style="min-width: 75%;" readonly>
                                        </div>
                                    </div>
                                 ';
                                while($i<=$_SESSION['people']){
                                    echo '<div class="form-group">
                                            <label for="per'.$i.'">Person'.$i.'</label>
                                            <input type="text" class="form-control" placeholder="Person'.$i.' Name"
                                                name="per'.$i.'" id="per'.$i.'" required>
                                        </div>';
                                    $i=$i+1;
                                }
                            ?>
                            <button type="submit" name="submit" class="btn btn-block btn-outline-success btn-default"><a
                                    href="plan_details.php">Submit</a></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- THIS IS THE FORM WHICH WILL TAKE PLAN DETAILS ENDS-->
    <!-- FOOTER -->
    <?php include "partition/_footer.php" ?>
    <!-- FOOTER ENDS -->
</body>

</html>