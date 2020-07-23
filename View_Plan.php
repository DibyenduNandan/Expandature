<?php

// CHECKING IF THE USER IS LOGGEDIN OTHERWISE REDIRECT HIM/HER TO LOGIN PAGE

session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}

// INCLUDATION OF ADDITIONAL REQUIRED FILES

$_SESSION['toggle']=false;
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

$existSql= 'SELECT * FROM people where sno="'.$_GET['sno'].'"';
$result=mysqli_query($conn,$existSql);
$numExistRows=mysqli_num_rows($result);
$i=1;
while($i<=$_GET['no'] && $numExistRows==0)
{
    $Sql= 'INSERT INTO `people`(`sno` ,`person_name`,`date_time`) VALUES ("'.$_GET['sno'].'","'.$_GET[$i].'",1000-01-01)';
    $result=mysqli_query($conn,$Sql);
    $i+=1;
}
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

// END OF CODE FOR DISPLAYING OF THE BILL FROM THE DATABASE

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup | Life Style Store</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <link href="css/view_plan.css" rel="stylesheet">
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color: #e7e6e6;" class="<?php echo $class;?>">
    <!-- ADDING NAVBAR -->

    <?php include "partition/_navbar.php" ?>

    <!-- DISPLAYING OF BILL CODE -->

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
        ?>          <div class="<?php echo $class2; ?>" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLable" aria-hidden="true" style=<?php echo $display;?>>    
                    <form role="form" action="connection.php" method="POST">
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
                        <button type="submit" class="close" data-dismiss="modal" aria-label="close" style="font-size: 3em;color: red;margin-right: 10%;margin-top: 4%;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                            </form>
                    <div class="modal-dialog" role="document" style="height: 50%;width: 50%;margin-top: 4%;">
                        <div class="modal-content">
                            <?php 
                                    $Sql='SELECT `bills` FROM `people` where `title`="'.$_GET['tit'].'"';
                                    $result=mysqli_query($conn,$Sql);
                                    $row= mysqli_fetch_assoc($result);
                                    $img=$row['bills'];
                                        echo '
                                                <img src="'.$img.'" alt="No Image" style="width:100%">
                                            ';
                            ?>
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

    <!-- END OF CODE FOR DISPLAYING OF BILL CODE -->

    <div class="container" style="min-height:68%;">
        <div class="row">

            <!-- STARTING OF CODE FOR DISPLAYING OF PLAN DETAILS -->

            <div class="container-fluid">
                <div class="change2 col-md-6 col-sm-4" style="margin-bottom: 2%;">
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

                <!-- ENDING OF CODE FOR DISPLAYING OF PLAN DETAILS -->

                <!-- THIS IS A BUTTON WHICH WILL REDIRECT TO THEEXPANSE DISTRIBUTION PAGE -->
                <?php
                    echo '<a href="Expense_Distribution.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&sno='.$_GET['sno'].'">
                            <button type="button"  class="edits" >Expance Distribution</button>
                        </a>';
                ?>
            </div>

            <div class="container-fluid">
                <div class="row" style="margin:0;">
                    <div class="con" style="display: inline-flex;width: 105%;">
                                        
                        <!-- CODE OF DISPLAYING DETAILS OF PREVIOUSLY CREATED EXPANSES BY THE USER -->


                        <div class="con" style="margin-left: 0;min-width: 47%;max-width: 47%;">
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
                                        <div class="con" style="min-width: 49%;display: inline-flex;">
                                            <div class="change col-md-12 col-sm-4" style="margin-bottom: 6%;">
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
                                                    <form action="View_Plan.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&arr='.urlencode($_GET['arr']).'&sno='.$_GET['sno'].'&'.http_build_query(arr($_GET['arr'])).'&tit='.$row['title'].'" method="post">
                                                        <button type="submit"  class="edit btn btn-block btn-outline-none btn-default">
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

                        <!-- CODE OF DISPLAYING DETAILS OF PREVIOUSLY CREATED EXPANSES BY THE USER -->

                        <!-- CREATING FORM FOR ADDING NEW EXPANSE DETAILS -->

                        <div class="change3 con" style="margin-left: 19%;width: 80%;">
                            <div class="con">
                                <div class="col-md-16 col-md-offset-0">
                                    <div class="panel">
                                        <div class="panel-heading"
                                            style="text-align: center; border-bottom:1px solid #d3cfcf;">
                                            <h4>Add New Expense</h4>
                                        </div>
                                        <?php 
                                            if(!empty($_GET['msg'])):?>
                                                <div class="alert alert-<?php echo $_GET['css_class']; ?> alert-dismissible fade in" style="margin: 1%;" role="alert">
                                                    <?php echo $_GET['msg']; ?>
                                                    <span class="close" data-dismiss="alert" aria-label="Close" aria-hidden="true">&times;</span>
                                                </div>
                                            <?php endif;?>
                                        <div class="panel-body">
                                            <form role="form" action="View_Plan1.php" method="POST"
                                                enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <label for="title">Title</label>
                                                    <input type="text" class="form-control" placeholder="Expance Name"
                                                        name="title" id="title" required>
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
                                                        <input type="number" class="form-control" min="0" placeholder="Amount Spent" name="num" id="num" required>
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
                                                    <button type="submit" name="submit"
                                                        class="btn btn-block">Add</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- CREATING FORM FOR ADDING NEW EXPANSE DETAILS -->

                    </div>
                </div>
            </div>
        </div>
    </div>
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

    <!-- FOOTER -->
    <?php include "partition/_footer.php" ?>


    <!-- SOME ADDITIONAL HIDDEN ATTRIBUTE WHOSE VALUE IS USED IN THE JAVASCRIPT BELOW FOR SCREEN RESOLUTION -->

    <?php
    echo '
        <a id="rel1" href="View_Plan.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&arr='.urlencode($_GET['arr']).'&sno='.$_GET['sno'].'&'.http_build_query(arr($_GET['arr'])).'" hidden></a>
        <a id="rel2" href="View_Plan2.php?bud='.$_GET['bud'].'&Dat='.$_GET['Dat'].'&no='.$_GET['no'].'&Dat2='.$_GET['Dat2'].'&dat='.$_GET['dat'].'&ord='.$_GET['ord'].'&arr='.urlencode($_GET['arr']).'&sno='.$_GET['sno'].'&'.http_build_query(arr($_GET['arr'])).'" hidden></a>
        ';
    ?>

    <!--CODE OF MANEGING SCREEN RESOLUTION-->

    <script type="text/javascript">
        reload=0;
        window.setInterval(() => {
            width=screen.availWidth;
            height=screen.availHeight;
            function fun(x,y)
            {
                if(x.matches)
                {
                    href=document.getElementById("rel2").href;
                    window.location.href=href+"&width="+width+"&height="+height;
                }
                else if(y.matches)
                {
                    reload=1;
                    t=document.querySelectorAll('.change')
                    document.querySelector('.change2').classList.remove('col-md-6','col-sm-4')
                    document.querySelector('.change2').classList.add('col-md-2','col-sm-6')
                    document.getElementsByClassName("change3")[0].setAttribute("style","margin-left:8%")
                    change = document.getElementsByClassName('change');
                    Array.from(change).forEach((e) => {
                        e.parentNode.setAttribute("style","width:100%");
                    })
                    for (let i = 0; i < t.length; i++) 
                    {
                        t[i].classList.remove("col-md-12","col-sm-4")
                        t[i].classList.add("col-md-0","col-sm-12")
                    }
                }
                else if(reload==1)
                {
                    href=document.getElementById("rel1").href;
                    window.location.href=href+"&width="+width+"&height="+height;
                }
                else
                {
                    reload=0;
                }
            }
            var x=window.matchMedia("(max-width:767px)");
            var y=window.matchMedia("(min-width:767px) and (max-width:991px)");
            x.addEventListener(fun(x,y),null)
        }, 250);
    </script>

    <!--END OF CODE OF MANEGING SCREEN RESOLUTION-->

</body>

</html>