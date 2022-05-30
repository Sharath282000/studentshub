<!------Including php configure file----->
<?php
require_once "config.php";
session_start();
ob_start();
$email = $_SESSION['email'];
$res = $conn->query("select * from students_register where Email_id='$email'");

if ($res->num_rows == 1) {
    $row = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Posts</title>
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
    <!-----Deleting posts by getting post id through get method----->
    <?php
    if ($_SESSION['email']) {
        if (isset($_GET['postid'])) {
            $pid = $_GET['postid'];
            $sel = $conn->query("select Post_file,User_id from posts where Post_id=$pid");
            $rows = $sel->fetch_assoc();
            $data = $rows['Post_file'];
            if ($row['ID'] == $rows['User_id']) {
                $delpos = $conn->query("Delete from posts where Post_id=$pid");
                if ($delpos) {
                    $com = $conn->query("Delete from comments where Post_id=$pid");
                    unlink("posts/$data");
                    $_SESSION['status'] = "Your post has been deleted successfully!";
                    $_SESSION['status_code'] = "info";
                    $_SESSION['title'] = "Success!";
                    $url = $_SERVER['HTTP_REFERER'];
                    header("Location:$url");
                    ob_end_flush();
                    exit();
                }
            } else {
                $_SESSION['status'] = "You cannot delete others post!";
                $_SESSION['status_code'] = "warning";
                $_SESSION['title'] = "Don't do this!";
                header("Location:home.php");
                ob_end_flush();
                exit();
            }
        } else {
    ?>
            <h4 class="text-center mt-2">No post found</h4>
    <?php
        }
    } else {
        unset($_SESSION['email']);
        header("Location:index.php");
        ob_end_flush();
        exit();
    }
    ?>
</body>

</html>