<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}
include 'partition/_dbconnect.php';
$_SESSION['toggle']=false;
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
    <title>Welcome | Life Style Store</title>
    <link href="css/nav_plan.css" rel="stylesheet">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body style="background-color: #e7e6e6;" onresize="refresh()">
    <?php include "partition/_navbar.php" ?>
    <?php
    if($err)
    {
        echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
            <strong>Success!</strong>'.$err.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';
    }
    if($numExistRows==0)
    {
        echo "<div class='container'>
                <h2 style='font-weight: lighter;'>You don't have any active plans</h2>
            </div>
            <div class='container' style='background-color:white; max-width: 25%; min-height: 25%; text-align: center; margin-top: 6%;  margin-bottom: 17%;'>
                <p class='glyphicon glyphicon-plus-sign' style='color: green; margin-top: 20%;'>
                    <a href='new_plan.php'>
                    <p style='display: inline;'>Create a new plan</p>
                    </a>
                </p>
            </div>";
    }
    else{
        $Sql= "SELECT * FROM budget where email='$email'";
        $result=mysqli_query($conn,$Sql);
        include 'partition/num.php';
        include 'partition/_month.php';
        include 'partition/array_to_name.php';
        $i=1;
        echo '<div class="container">
                <h2 style="font-weight: lighter;">Your Plans</h2>
              </div>
            <div class="container" style="min-height:68%;">
                <div class="row">';          
            while($row=mysqli_fetch_assoc($result))
            {
                $ord=createFullWordOrdinal($i);
                $sql1='SELECT * FROM budget_details where sno="'.$row['sno'].'"';
                $result2=mysqli_query($conn,$sql1);
                $row2=mysqli_fetch_assoc($result2);
                $from_dt=createFullWordOrdinal2($row2['from_dt']);
                $to_dt=createFullWordOrdinal2($row2['to_dt']);
                $_SESSION['bud']=$row['initial_budget'];
                echo '     
                    <div class="col-md-3 col-sm-4" style="margin-bottom: 6%;">
                        <div class="panel-heading">
                            My '.$ord.' Plan <span class="glyphicon glyphicon-user" style="color:white;"> '.$row['no_of_people'].'</span>
                        </div>
                        <div class="panel-body" style="background-color: white;">
                            <div class="caption">
                                <span style="display: block; margin-bottom: 6%;">Budget:<p style="display: inherit; float: right; margin: 0;">'.$row['initial_budget'].'</p></span> 
                                <span style="display: block; margin-bottom: 6%;">Date:<p style="display: inherit; float: right; margin: 0;">'.$from_dt.' '.' - '.$to_dt.' '.substr($row2['from_dt'],0,4).'</p></span>
                            </div>
                            <a href="View_Plan.php?bud='.$_SESSION['bud'].'&Dat='.$row2['from_dt'].'&Dat2='.$row2['to_dt'].'&dat='.$from_dt.' '.' - '.$to_dt.' '.substr($row2['from_dt'],0,4).'&no='.$row['no_of_people'].'&ord='.$ord.'&arr='.urlencode($row2['person']).'&sno='.$row2['sno'].'&'.http_build_query(arr($row2['person'])).'" style="text-decoration:none;"></a>
                            <a href="View_Plan2.php?bud='.$_SESSION['bud'].'&Dat='.$row2['from_dt'].'&Dat2='.$row2['to_dt'].'&dat='.$from_dt.' '.' - '.$to_dt.' '.substr($row2['from_dt'],0,4).'&no='.$row['no_of_people'].'&ord='.$ord.'&arr='.urlencode($row2['person']).'&sno='.$row2['sno'].'&'.http_build_query(arr($row2['person'])).'" style="text-decoration:none;"></a>
                            <button type="button" class="edit btn btn-block btn-outline-success btn-default">
                                View Plan
                            </button>
                        </div>
                    </div>';
                $i=$i+1;
            }
        echo  '</div>
            </div>';
        echo '<div class="container" style="margin-right:3%; margin-bottom: 1.1%;">
                <a href="new_plan.php"><div class="glyphicon glyphicon-plus-sign" style="color:  #028162db; font-size:5em; float: right;"></div></a>
            </div>';
    }
    ?>  
    <?php include "partition/_footer.php" ?>
    <script type="text/javascript">
        window.onresize=function(){location.reload();}
        width=screen.availWidth;
        height=screen.availHeight;
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => 
        {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                href = tr.getElementsByTagName("a")[0].href;
                href2 = tr.getElementsByTagName("a")[1].href;
                if (width<414 || height<823)
                {
                    window.location.href=href2+"&width="+width+"&height="+height;
                }
                else
                {
                    window.location.href=href+"&width="+width+"&height="+height;
                }
            })
        })
    </script>
</body>

</html>