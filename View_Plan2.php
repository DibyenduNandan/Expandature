<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}
// INCLUDATION OF ADDITIONAL REQUIRED FILES
$_SESSION['toggle']=true;
include 'partition/_dbconnect.php';
include 'partition/num.php';
include 'partition/array_to_name.php';

// CODE FOR CALCULATION OF REMAINING BUDGET

$Sql= "SELECT * FROM budget_details";
$result=mysqli_query($conn,$Sql);
$i=1;
while($row=mysqli_fetch_assoc($result))
{
    $ord=createFullWordOrdinal($i);
    if ($ord==$_GET['ord'])
    {  
        $per= $row['person'];
        $arr=arr($row['person']);
        $j=1;
        $totamt=0;
        $remamt=$_GET['bud'];
        while($j<=$_GET['no'])
        {
            ${'amt'.$j}=0;
            $Sql= "SELECT amount FROM people where person_name='".$arr[$j]."' and sno=".$_GET['sno']."";
            $result=mysqli_query($conn,$Sql);
            while($row=mysqli_fetch_assoc($result))
            {
                ${'amt'.$j}+=$row['amount'];
            }
            $totamt+=${'amt'.$j};
            $j+=1;
        }
        $remamt-=$totamt;
    break;
    }
    $i+=1;
}

// END OF CODE FOR CALCULATION OF REMAINING BUDGET

// CODE FOR DISPLAYING OF THE BILL FROM THE DATABASE

$_SESSION['request']=$_REQUEST;
$existSql= 'SELECT * FROM people where sno="'.$_GET['sno'].'"';
$result=mysqli_query($conn,$existSql);
$numExistRows=mysqli_num_rows($result);
echo $numExistRows2
$i=1;
while($i<=$_GET['no'] && $numExistRows==0)
{
    $Sql= 'INSERT INTO `expandature`.`people`(`sno` ,`person_name`,`date_time`) VALUES ("'.$_GET['sno'].'","'.$_GET[$i].'","1000-01-01")';
    $result=mysqli_query($conn,$Sql);
    echo $Sql;
    echo var_dump($result);
    $i+=1;
}
die();
$permission=0;
$class="";
$class2="modal fade";
$display="display:none;";
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
        $Sql='SELECT `bills` FROM `people` where `title`="'.$_GET['tit'].'"';
        $result=mysqli_query($conn,$Sql);
        $row= mysqli_fetch_assoc($result);
        $permission=1;
        if($row['bills']!="You Don't have bill")
        {          
            $class="modal-open";
            $class2="modal fade in";
            $display="display:block;";
        }
        else
        {
            $class="";
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
    <link href="css/view_plan2.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body  style="background-color: #e7e6e6;" class="<?php echo $class;?>" >
    <!-- NAVBAR -->
    <?php include "partition/_navbar.php" ?>

    <marquee style="color:red;">Toggle Down The Navbar to add Expance</marquee>

    <!-- SHOWING OF BILL CODE -->

    <?php
        include 'partition/_month.php';
        if($permission==1)
            {
                $notRequire=False; 
                $Sql='SELECT `bills` FROM `people` where `title`="'.$_GET['tit'].'"';
                $result=mysqli_query($conn,$Sql);
                $row= mysqli_fetch_assoc($result);
                $img=$row['bills'];
                if ($img!="You Don't have bill")
                {
    ?>              <div class="<?php echo $class2; ?>" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLable" aria-hidden="true" style=<?php echo $display;?>>    
                    <div class="modal-dialog" role="document" style="height: 50%;width: 50%;margin-top: 4%;">
                        <div class="modal-content" style="height: 50%;position: relative;">
                            <form role="form" action="/connection2.php" method="POST">
                                <input type="hidden" name="ord" id="ord" value="<?php echo $_GET['ord']; ?>">
                                <input type="hidden" name="no" id="no" value="<?php echo $_GET['no']; ?>">
                                <input type="hidden" name="sno" id="sno" value="<?php echo $_GET['sno']; ?>">
                                <input type="hidden" name="bud" id="bud" value="<?php echo $_GET['bud']; ?>">
                                <input type="hidden" name="dat" id="dat" value="<?php echo $_GET['dat']; ?>">
                                <input type="hidden" name="Dat" id="Dat" value="<?php echo $_GET['Dat']; ?>">
                                <input type="hidden" name="Dat2" id="Dat2" value="<?php echo $_GET['Dat2']; ?>">
                                <input type="hidden" name="arr" id="arr" value='<?php echo urldecode($_GET['arr']);?>'>
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
                            <?php 
                                    $Sql='SELECT `bills` FROM `people` where `title`="'.$_GET['tit'].'"';
                                    $result=mysqli_query($conn,$Sql);
                                    $row= mysqli_fetch_assoc($result);
                                    $img=$row['bills'];
                                        echo '
                                                <img src="'.$img.'" alt="No Image" style="width: 196%;height: 200%;">
                                            ';
                            ?>
                                <button type="submit" class="close" data-dismiss="modal" aria-label="close" style="font-size: 3em;color: red;margin-right: 10%;margin-top: 4%;position: absolute;transform: translate(27%, -462%);">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </form>
                        </div>
                    </div>
        <?php
                }
                else
                {
                    $notRequire=True;
                    echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <strong>Sorry!</strong> Your have not given any bill details
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin: 0;">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                          </div>';
                }
            }
        ?>
                    </div>
    <!-- ENDING OF BILL SHOWING CODE -->

    <!--STARTING OF THE PAGE -->

    <div class="container" style="min-height:90%;">
        <div class="row">
            <div class="container-fluid">
                <div class="col-md-6 col-sm-4" style="margin-bottom: 2%;">
                    <div class="panel-heading">
                        My <?php echo $_GET['ord'] ?> Plan
                        <p style="display: inherit; float: right; margin: 0;">
                            <span class="glyphicon glyphicon-user" style="color:white;">
                                <?php echo $_GET['no'] ?>
                            </span>
                        </p>
                    </div>
                    <div class="panel-body" style="background-color: white;">
                        <div class="caption">
                            <span style="display: block; margin-bottom: 4%;">
                                Budget:
                                <p style="display: inherit; float: right; margin: 0;">
                                    <span>&#8377;</span><?php echo $_GET['bud']?>
                                </p>
                            </span>
                            <span style="display: block; margin-bottom: 4%;">
                                Remaining Amount:
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
                            <span style="display: block; margin-bottom: 4%;">
                                Date:
                                <p style="display: inherit; float: right; margin: 0;">
                                    <?php echo $_GET['dat']?>
                                </p>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <?php
                    echo '
                        <a href="Expense_Distribution.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&sno='.$_GET['sno'].'">
                            <button type="button"  class="edits btn btn-block">Expance Distribution</button>
                        </a>
                        ';
                ?>
            </div>
            
            <!-- DISPLAYING OF ALL STORED EXPANCE DISTRIBUTION -->

            <div class="container-fluid">
                <div class="row" style="margin:0;">
                    <div class="con">
                        <div class="con">
                            <?php
                                $Sql= 'SELECT * FROM people where title!="No title" and sno="'.$_GET['sno'].'"';
                                $result=mysqli_query($conn,$Sql);
                                $numExistRows2=mysqli_num_rows($result);
                                $i=1;
                                while($i<= $numExistRows2)
                                {
                                    while($row=mysqli_fetch_assoc($result))
                                    {
                                        $from_dt=createFullWordOrdinal2($row['date_time']);
                                        if ($row['bills']!="You Don't have bill")
                                            {
                                                $bill='Show Bill';
                                            }
                                        else
                                            {
                                                $bill=$row['bills'];
                                            }
                                        echo '
                                        <div class="con">
                                            <div class="col-md-12 col-sm-4" style="margin-bottom: 6%;">
                                                <div class="panel-heading">
                                                    '.$row['title'].'
                                                </div>
                                                <div class="panel-body" style="background-color: white;">
                                                    <div class="caption">
                                                        <span style="display: block; margin-bottom: 6%;">Amount
                                                            <p style="display: inherit; float: right; margin: 0;">
                                                                '.$row['amount'].'
                                                            </p>
                                                        </span>
                                                        <span style="display: block; margin-bottom: 6%;">Paid By
                                                            <p style="display: inherit; float: right; margin: 0;">
                                                                '.$row['person_name'].'
                                                            </p>
                                                        </span>
                                                        <span style="display: block; margin-bottom: 6%;">Paid on
                                                            <p style="display: inherit; float: right; margin: 0;">
                                                                '.$from_dt.' '.substr($row['date_time'],0,4).'
                                                            </p>
                                                        </span>
                                                    </div>
                                                    <form action="View_Plan2.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&arr='.urlencode($_GET['arr']).'&sno='.$_GET['sno'].'&'.http_build_query(arr($_GET['arr'])).'&tit='.$row['title'].'" method="post">
                                                        <button type="submit"  class="btn btn-block btn-outline-none btn-default"
                                                            style="color: #337ab7; margin: 0; border-color: white;">
                                                                '.$bill.'
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                            ';
                                    }
                                    $i+=1;
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ENDING OF DISPLAYING -->

        </div>
    </div>
    <!-- ENDING OF THE PAGE -->
    <?php
        if($permission==1 && $notRequire==False)
        {
            echo '<div class="modal-backdrop fade in"></div>';
        }
        else
        {
            echo '<div class=""></div>';
        }
        ?>
    <?php include "partition/_footer.php" ?>
    
    <?php
    echo '
        <a id="rel1" href="View_Plan.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&arr='.urlencode($_GET['arr']).'&sno='.$_GET['sno'].'&'.http_build_query(arr($_GET['arr'])).'" hidden></a>
        ';
    ?>

    <!-- MANEGING SCREEN RESOLUTION-->

    <script type="text/javascript">
        window.setInterval(() => {
            width=screen.availWidth;
            height=screen.availHeight;
            function fun(x)
            {
                if(!x.matches)
                {
                    href=document.getElementById("rel1").href;
                    window.location.href=href+"&width="+width+"&height="+height;
                }
            }
            var x=window.matchMedia("(max-width:767px)")
            x.addEventListener(fun(x),null)
        }, 500);
    </script>

</body>

</html>