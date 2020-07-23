<?php
session_start();
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

    <!-- HEADER -->

    <?php include "partition/_navbar.php"?>

    <!-- HEADER -->
    <!-- ABOUT PAGE CONTENT -->

    <div class="container" style="min-height: 571px;">
        <div class="row">
            <div class="col">
                <div class="con" style="display: flex;">
                    <div class="con" style="max-width: 44%;">
                        <h1 style="font-weight: lighter;">Who we are?</h1>
                        <span style="font-weight: lighter;">
                            We are the young technocrats who come up with an idea of solving budget and time issue
                            which we usually face in our daily life. We are here to provide a
                            budget controller according to your accept
                            <br>
                            <br>
                            Budget control is the biggest financial issue in the present world. One should look
                            after their budget control to get rid off their financial crisis.
                            <br>
                        </span>
                    </div>
                    <div class="con" style="margin-left: 9%;">
                        <h1 style="font-weight: lighter;">Why choose us?</h1>
                        <span style="font-weight: lighter;">We provide with a predominant way to control and manage your
                            budget estimations with ease of accessing for multiple users.</span>
                    </div>
                </div>
                <div class="col">
                    <h1 style="font-weight: lighter;">Contact Us</h1>
                    <span style="font-weight: lighter;">
                        <b>Email:</b>Budget@gmail.com
                        <br>
                        <br>
                        <b>Mobile:</b>+91 8448555843
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- ABOUT PAGE CONTENT -->
    <!-- FOOTER -->

    <?php include "partition/_footer.php" ?>

    <!-- FOOTER -->
</body>

</html>