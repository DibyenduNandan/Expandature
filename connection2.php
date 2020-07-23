<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}

// This will take request which has been send by the View_Plan2.php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    include 'partition/_dbconnect.php';
    include 'partition/array_to_name.php';
    $ord=$_POST['ord'];
    $bud=$_POST['bud'];
    $Dat=$_POST['Dat'];
    $no=$_POST['no'];
    $Dat2=$_POST['Dat2'];
    $dat=$_POST['dat'];
    $sno=$_POST['sno'];
    header("location:View_Plan2.php?bud=".$bud."&Dat=".$Dat."&no=".$no."&Dat2=".$Dat2."&dat=".$dat."&ord=".$ord."&arr=".urlencode($_POST['arr'])."&sno=".$sno."&".http_build_query(arr($_POST['arr']))."");
}
?>