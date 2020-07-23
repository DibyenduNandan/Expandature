<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}
include 'partition/_dbconnect.php';
$email=mysqli_real_escape_string($conn,$_SESSION['email']);
$err=$_SESSION['err'];
$existSql= "SELECT * FROM budget where email='$email'";
$result=mysqli_query($conn,$existSql);
$numExistRows=mysqli_num_rows($result);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Expense</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <link href="css/view_plan2.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color: #e7e6e6;">

    <!-- HEADER -->

    <?php include "partition/_navbar.php" ?>

    <!-- HEADER -->

    <!-- ADDING NEW EXPENSE FORM STARTS -->

    <div class="con" style="margin:5%; min-height:90%;">
        <div class="col-md-16 col-md-offset-0">
            <div class="panel">
                <div class="panel-heading" style="text-align: center; border-bottom:1px solid #d3cfcf;">
                    <h4>Add New Expense</h4>
                </div>

                <!-- THIS IS THE ERROR MESSAGE WHICH WILL SHOW WHEN THE FORM CANNOT BE SUBMITTED -->

                <?php 
                    if(!empty($_GET['msg'])):?>
                <div class="alert alert-<?php echo $_GET['css_class']; ?> alert-dismissible fade in" style="margin: 1%;"
                    role="alert">
                    <?php echo $_GET['msg']; ?>
                    <span class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">&times;</span>
                </div>
                <?php endif;?>

                <!-- THIS IS THE END OF CODE OF ERROR MESSAGE WHICH WILL SHOW WHEN THE FORM CANNOT BE SUBMITTED -->

                <div class="panel-body">
                    <form role="form" action="View_Plan3.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" placeholder="Expance Name" name="title" id="title"
                                required>
                        </div>
                        <?php
                            echo '
                                    <div class="form-group" style="min-width: 50%; margin-right: 2%;">
                                        <label for="date" style="display: block;">Date</label>
                                        <input type="date" class="form-control" name="date" id="date" min="'.$_GET['Dat'].'" max="'.$_GET['Dat2'].'" style="min-width: 95%;" required>
                                    </div>
                                ';
                        ?>
                        <div class="form-group">
                            <label for="num">Amount Spent</label>
                            <input type="number" class="form-control" min="0" placeholder="Amount Spent" name="num"
                                id="num" required>
                        </div>
                        <input type="hidden" name="ord" id="ord" value="<?php echo $_GET['ord']; ?>">
                        <input type="hidden" name="no" id="no" value="<?php echo $_GET['no']; ?>">
                        <input type="hidden" name="sno" id="sno" value="<?php echo $_GET['sno']; ?>">
                        <input type="hidden" name="bud" id="bud" value="<?php echo $_GET['bud']; ?>">
                        <input type="hidden" name="dat" id="dat" value="<?php echo $_GET['dat']; ?>">
                        <input type="hidden" name="Dat" id="Dat" value="<?php echo $_GET['Dat']; ?>">
                        <input type="hidden" name="Dat2" id="Dat2" value="<?php echo $_GET['Dat2']; ?>">
                        <input type="hidden" name="arr" id="arr" value='<?php echo urldecode($_GET['arr']); ?>'>
                        <?php
                            $i=1;
                            while($i<=$_GET['no'])
                            {
                                echo '
                                <input type="hidden" name="'.$i.'" id="'.$i.'" value="';
                                    echo $_GET[$i];
                                echo '">';
                                $i+=1;
                            }
                        ?>
                        <div class="form-group">
                            <label for="file">Upload Bill</label>
                            <input class="form-control" type="file" name="file" id="file">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="user" id="user">
                                <option value="choose" readonly>Choose</option>
                                <?php
                                    $i=1;
                                    while($i<=$_GET['no'])
                                    {
                                        echo'
                                        <option value="'.$_GET[$i].'" readonly>'.$_GET[$i].'</option>
                                        ';
                                        $i+=1;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="submit" class="btn btn-block">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

     <!-- ADDING NEW EXPENSE FORM ENDS -->

    <!-- FOOTER -->

    <?php include "partition/_footer.php" ?>

    <!-- FOOTER -->

    <?php
    include 'partition/array_to_name.php';
    echo '
        <a id="rel1" href="View_Plan.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&arr='.urlencode($_GET['arr']).'&sno='.$_GET['sno'].'&'.http_build_query(arr($_GET['arr'])).'" hidden></a>
        ';
    ?>

    <!-- ADDING RESPONSIVENESS -->

    <script type="text/javascript">
        window.setInterval(() => {
            width=screen.availWidth;        //This takes the actual width of the screen
            height=screen.availHeight;      //This takes the actual height of the screen
            function fun(x)                 //This function will fire when actual width is less than 750px
            {
                if(!x.matches)
                {
                    href=document.getElementById("rel1").href;
                    window.location.href=href+"&width="+width+"&height="+height;
                }
            }
            var x=window.matchMedia("(max-width:750px)")
            x.addEventListener(fun(x),null)
        }, 500);
    </script>

    <!-- ADDING RESPONSIVENESS -->

</body>

</html>