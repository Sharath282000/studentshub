<!------Including php configure file----->
<?php
require_once "config.php";
session_start();
ob_start();
$email = $_SESSION['placement'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Job</title>
    <!-----Bootstrap----->
    <link rel="stylesheet" href="css/bootstrap.min.css">
     <!-----Font awesome----->
    <link rel="stylesheet" href="css/fa_all.min.css">
     <!-----Animate on scroll----->
    <link rel="stylesheet" href="css/aos.css">
     <!-----Google fonts----->
    <link rel="stylesheet" href="fonts/fonts.css">
     <!-----Font awesome----->
    <link rel="stylesheet" href="css/fontawesome.min.css">
     <!-----For font awesome----->
    <link rel="stylesheet" href="css/all.min.css">
     <!-----Jquery----->
    <script src="js/jquery.min.js"></script>
     <!-----Customed stylesheet----->
    <style>
        <?php
        include "css/style.css";
        ?>
    </style>
</head>

<body>
     <!-----Sweet Alert----->
    <script src="js/sweetalert.min.js"></script>
     <!-----Deleting job by getting job id through get method----->
    <?php
    if ($_SESSION['placement']) {
        if (isset($_GET['jobid'])) {
            $jid = $_GET['jobid'];
            $sel = $conn->query("select * from job_details where Job_id=$jid");
            $rows = $sel->fetch_assoc();
            if ($rows['Job_id'] == $jid) {
                $deljob = $conn->query("Delete from job_details where Job_id=$jid");
                if ($deljob) {
                    $_SESSION['status'] = "Job has been deleted successfully!";
                    $_SESSION['status_code'] = "info";
                    $_SESSION['title'] = "Success!";
                    header("Location:placementcell.php");
                    ob_end_flush();
                    exit();
                }
            } else {
                $_SESSION['status'] = "You cannot delete this";
                $_SESSION['status_code'] = "warning";
                $_SESSION['title'] = "Job not found!";
                header("Location:placementcell.php");
                ob_end_flush();
                exit();
            }
        } else {
    ?>
            <h4 class="text-center mt-2">No job found</h4>
    <?php
        }
    } else {
        header("Location:index.php");
        ob_end_flush();
        exit();
    }
    ?>
</body>

</html>