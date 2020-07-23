<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}
include 'partition/_dbconnect.php';
$email=mysqli_real_escape_string($conn,$_SESSION['email']);
$Sql= "SELECT * FROM budget_details";
$result=mysqli_query($conn,$Sql);
include 'partition/num.php';
include 'partition/array_to_name.php';
$i=1;
while($row=mysqli_fetch_assoc($result))
{
    $ord=createFullWordOrdinal($i);
    if ($ord==$_GET['ord'])
    {  
        $per= $row['person'];
        $arr=arr($row['person']);
        $j=1;
        $S=0;
        $T=0;
        $totamt=0;
        $remamt=$_GET['bud'];
        $ishare=0;
        while($j<=$_GET['no'])
        {
            ${'amt'.$j}=0;
            $Sql= "SELECT amount FROM people where person_name='".$arr[$j]."' and sno=".$_GET['sno']."";
            $result=mysqli_query($conn,$Sql);
            while($row=mysqli_fetch_assoc($result))
            {
                ${'amt'.$j}+=$row['amount'];
            }
            if (mysqli_num_rows($result)==1 && ${'amt'.$j}==0)
            {
                $S+=1;
            }
            $totamt+=${'amt'.$j};
            $j+=1;
        }
        $j=1;
        $ishare=$totamt/$_GET['no'];
        while($j<=$_GET['no'])
        {
            ${'amt2'.$j}=${'amt'.$j}-$ishare;
            if (${'amt2'.$j}==0)
            {
                $T+=1;
            }
            $j+=1;
        }
        $remamt-=$totamt;
    break;
    }
    $i+=1;
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
    <link href="css/distribution.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

    <!-- HEADER -->

    <?php include "partition/_navbar.php" ?>

    <!-- Header ENDS -->

    <div class="container-fluid decor_bg" id="login-panel">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel">

                    <!-- FORM HEADING -->

                    <div class="panel-heading">
                        My <?php echo $_GET['ord'] ?> Plan
                        <p style="display: inherit; float: right; margin: 0;">
                            <span class="glyphicon glyphicon-user">
                                <?php echo $_GET['no'] ?>
                            </span>
                        </p>
                    </div>

                    <!-- FORM HEADING ENDS-->
                    
                    <div class="panel-body">
                        <div class="caption">

                            <!-- Displaying total budget -->
                            <span style="display: block; margin-bottom: 4%;">
                                Budget
                                <p style="display: inherit; float: right; margin: 0;">
                                    <span>&#8377;</span><?php echo $_GET['bud']?>
                                </p>
                            </span>
                            <!-- Displaying total budget enda -->

                            <!-- This loop will print the names of person and amount spent by them -->

                            <?php
                                    $j=1;
                                    while($j<=$_GET['no'])
                                    {
                                ?>       
                            <span style="display: block; margin-bottom: 4%;">
                                <?php echo $arr[$j];?>
                                <p style="display: inherit; float: right; margin: 0;">
                                    <span>&#8377;</span><?php echo ${'amt'.$j};?>
                                </p>
                            </span>
                            <?php
                                        $j+=1;
                                    }
                            ?>

                            <!-- This loop will print the names of person and amount spent by them ends -->
                            
                            <span style="display: block; margin-bottom: 4%;">
                                Total Amount Spent
                                <p style="display: inherit; float: right; margin: 0;">
                                    <span>&#8377;</span><?php echo $totamt;?>
                                </p>
                            </span>

                            <!-- This will print remaining amount -->

                            <span style="display: block; margin-bottom: 4%;">
                                Remaining Amount
                                <?php
                                        if($remamt>0)
                                        {
                                           echo '
                                            <p style="display: inherit; float: right; margin: 0; color:green;">
                                                <span>&#8377;</span>'.$remamt.'
                                            </p>
                                            ';
                                        }
                                        else if($remamt==0)
                                        {
                                            echo '
                                            <p style="display: inherit; float: right; margin: 0;">
                                                <span>&#8377;</span>'.$remamt.'
                                            </p>
                                            ';
                                        }
                                        else
                                        {
                                            $remamt*=-1;
                                            echo '
                                            <p style="display: inherit; float: right; margin: 0; color:red">
                                                Overspended by <span>&#8377;</span>'.$remamt.'
                                            </p>
                                            ';
                                            $remamt*=-1;
                                        }
                                ?>
                            </span>

                            <!-- This will print remaining amount -->

                            <!-- This loop will print the names of person and there Individual Shares -->

                            <span style="display: block; margin-bottom: 4%;">
                                Individual Shares
                                <p style="display: inherit; float: right; margin: 0;">
                                    <span>&#8377;</span><?php echo $ishare;?>
                                </p>
                            </span>
                            <?php
                                    $j=1;
                                    while($j<=$_GET['no'])
                                    {
                                ?>
                            <span style="display: block; margin-bottom: 4%;">
                                <?php echo $arr[$j];?>
                                <?php
                                        if(${'amt2'.$j}>0)
                                        {
                                           echo '
                                            <p style="display: inherit; float: right; margin: 0; color:green;">
                                                Gets back <span>&#8377;</span>'.${'amt2'.$j}.'
                                            </p>
                                            ';
                                        }
                                        else if(${'amt2'.$j}==0)
                                        {
                                            echo '
                                            <p style="display: inherit; float: right; margin: 0;">
                                                <span>&#8377;</span>'.${'amt2'.$j}.'
                                            </p>
                                            ';
                                        }
                                        else
                                        {
                                            ${'amt2'.$j}*=-1;
                                            echo '
                                            <p style="display: inherit; float: right; margin: 0; color:red">
                                               Owes  <span>&#8377;</span>'.${'amt2'.$j}.'
                                            </p>
                                            ';
                                            ${'amt2'.$j}*=-1;
                                        }
                                    ?>
                            </span>
                            <?php
                                        $j+=1;
                                    }
                            ?>

                            <!-- This loop will print the names of person and there Individual Shares ends -->

                            <!-- Displaying Message If all debt settled -->

                            <?php
                            if($S!=$_GET['no'] && $T==$_GET['no'])
                            {
                                echo'
                                <div class="alert alert-success alert-dismissible fade in" role="alert">
                                    <strong>Success!</strong> All amount settled Up!!!!
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                ';
                            }
                            ?>

                            <!--End Of Displaying Message If all debt settled -->

                            <!-- Button for submission of form -->

                            <div class="form-actions">
                                <span>
                                    <?php
                                    echo '
                                            <a href="View_Plan.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&arr='.urlencode($per).'&sno='.$_GET['sno'].'&'.http_build_query($arr).'&tit='.$row['title'].'">
                                                <button type="submit"  class="btn  btn-outline-none btn-default">
                                                    <div class="glyphicon glyphicon-arrow-left" style="margin-right: 2px;"></div>Go back
                                                </button>
                                            </a>
                                        ';
                                    ?>
                                </span>
                            </div>

                            <!-- Button for submission of form ends -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->

    <?php include "partition/_footer.php" ?>

    <!-- FOOTER ENDS -->

</body>

</html>