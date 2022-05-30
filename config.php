<!------Configuring php to the project by connecting to the database----->
<?php 

$db="students hub";
$conn=mysqli_connect("localhost","root","",$db);
if($conn->connect_error){
    die("Sorry connection error please try again".$conn->connect_error);
}
?>