<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location:login.php");
    exit();
}
$msg="";
$css_class="";
if (isset($_POST['submit']))
{
    include 'partition/_dbconnect.php';
    include 'partition/array_to_name.php';
    $ord=$_POST['ord'];
    $bud=$_POST['bud'];
    $Dat=$_POST['Dat'];
    $no=$_POST['no'];
    $Dat2=$_POST['Dat2'];
    $dat=$_POST['dat'];
    $title=$_POST['title'];
    $date = $_POST['date'];
    $spent=$_POST['num'];
    $user=$_POST['user'];
    $sno=$_POST['sno'];
    $Sql= 'SELECT * FROM people where title="No title" AND person_name="'.$user.'"';
    $result=mysqli_query($conn,$Sql);
    $numExistRows=mysqli_num_rows($result);
    $Sql2= 'SELECT * FROM people where title="'.$title.'" AND sno="'.$sno.'"';
    $result2=mysqli_query($conn,$Sql2);
    $numExistRows2=mysqli_num_rows($result2);
    echo $numExistRows.'<br>';
    echo $numExistRows2.'<br>';
    echo $_FILES['file']['name'].'<br>';
    if ($numExistRows==0)
    {
        $Sql2= 'INSERT INTO `people`(`sno` ,`person_name`,`date_time`) VALUES ("'.$_POST['sno'].'","'.$_POST['user'].'",1000-01-01)';
        $result=mysqli_query($conn,$Sql2);
    }
    if($numExistRows2==1)
    {
        $msg="Expense Title already exist. Plese try another name or title";
        $css_class="danger";
        header("location:Add_New_Expense.php?bud=".$bud."&Dat=".$Dat."&no=".$no."&Dat2=".$Dat2."&dat=".$dat."&ord=".$ord."&arr=".urlencode($_POST['arr'])."&sno=".$sno."&".http_build_query(arr($_POST['arr']))."&msg=".$msg."&css_class=".$css_class."");
    }
    else
    {
        if ($_FILES['file']['name']==NULL)
        {
            $sql='UPDATE `people` SET `title` = "'.$title.'",`amount` = '.$spent.',`date_time` = "'.$date.'" WHERE `person_name`="'.$user.'" and `title`="No title"';
            $result=mysqli_query($conn,$sql);
            if($result){
                $msg="Data uploaded successfully! Now you can add another Expense";
                $css_class="success";
                header("location:View_Plan2.php?bud=".$bud."&Dat=".$Dat."&no=".$no."&Dat2=".$Dat2."&dat=".$dat."&ord=".$ord."&arr=".urlencode($_POST['arr'])."&sno=".$sno."&".http_build_query(arr($_POST['arr']))."&msg=".$msg."&css_class=".$css_class."");
            }
            else{
                $msg="Cannot upload data! Please try later";
                $css_class="danger";
                header("location:Add_New_Expense.php?bud=".$bud."&Dat=".$Dat."&no=".$no."&Dat2=".$Dat2."&dat=".$dat."&ord=".$ord."&arr=".urlencode($_POST['arr'])."&sno=".$sno."&".http_build_query(arr($_POST['arr']))."&msg=".$msg."&css_class=".$css_class."");
            }
        }
        else
        {
            $file_name=$_FILES['file']['name']; 
            $temp_name=$_FILES["file"]["tmp_name"]; 
            $imgtype=$_FILES["file"]["type"];
            include 'partition/_image.php';
            $ext= GetImageExtension($imgtype);
            $imagename=date("d-m-Y")."-".time().$ext; 
            $target_path = "image/".$imagename; 
            echo $target_path.'<br>';
            echo $imgtype.'<br>';
            echo $_FILES['file']['error'];
            die();
            if(move_uploaded_file($temp_name, $target_path) && $ext!=false)
            {
                $sql='UPDATE `people` SET `title` = "'.$title.'",`bills` = "'.$target_path.'",`amount` = '.$spent.',`date_time` = "'.$date.'" WHERE `person_name`="'.$user.'" and `title`="No title"';
                $result=mysqli_query($conn,$sql);
                if($result){

                    $msg="Image and Data uploaded successfully! Now you can add another Expense";
                    $css_class="success";
                    header("location:View_Plan2.php?bud=".$bud."&Dat=".$Dat."&no=".$no."&Dat2=".$Dat2."&dat=".$dat."&ord=".$ord."&arr=".urlencode($_POST['arr'])."&sno=".$sno."&".http_build_query(arr($_POST['arr']))."&msg=".$msg."&css_class=".$css_class."");
                }
                else{
                    $msg="Cannot upload data! Please try later";
                    $css_class="danger";
                    header("location:Add_New_Expense.php?bud=".$bud."&Dat=".$Dat."&no=".$no."&Dat2=".$Dat2."&dat=".$dat."&ord=".$ord."&arr=".urlencode($_POST['arr'])."&sno=".$sno."&".http_build_query(arr($_POST['arr']))."&msg=".$msg."&css_class=".$css_class."");
                }
            }
            else
            {
                $msg="Failed to upload the Image! You can only upload Image file ";
                $css_class="danger";
                header("location:Add_New_Expense.php?bud=".$bud."&Dat=".$Dat."&no=".$no."&Dat2=".$Dat2."&dat=".$dat."&ord=".$ord."&arr=".urlencode($_POST['arr'])."&sno=".$sno."&".http_build_query(arr($_POST['arr']))."&msg=".$msg."&css_class=".$css_class."");
            }
        }
    }
}
?>