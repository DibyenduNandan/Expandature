<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']!=true){
    $loggedin=false;
  }
  elseif(!isset($_SESSION['loggedin'])){
    $loggedin=false;
  }
  else{
    $loggedin=true;
  }
    echo '<div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>';
                    if(!$loggedin){
          echo'     <a href = "index.php" class="navbar-brand">Ct<span>&#8377;</span>l Budget</a>';
                    }
                    else{
          echo'     <a href = "welcome.php" class="navbar-brand">Ct<span>&#8377;</span>l Budget</a>';
                    }
      echo '     </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">';
                    if(!$loggedin)
                    {
                        echo '
                              <li><a href = "about.php"><span class = "glyphicon glyphicon-info-sign"></span> About Us </a></li>
                              <li><a href="signup.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                              <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                            ';
                    }
                    else if($_SESSION['toggle'])
                    {
                      echo '
                              <li><a href = "about.php"><span class = "glyphicon glyphicon-info-sign"></span> About Us </a></li>
                              <li><a href="change_password.php"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
                              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                              <li><a href="Add_New_Expense.php?'.http_build_query($_SESSION['request']).'"><span class="glyphicon glyphicon-plus-sign"></span> Add New Expense</a></li>
                            ';
                    }
                    else 
                    {
                        echo '
                              <li><a href = "about.php"><span class = "glyphicon glyphicon-info-sign"></span> About Us </a></li>
                              <li><a href="change_password.php"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
                              <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                            ';
                    }
             echo  '</ul>
                </div>
            </div>
         </div>';
?>