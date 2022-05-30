<?php
session_start();
$email = $_SESSION['email'];
ob_start();
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Account</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fa_all.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/emojionearea.min.css">
    <style>
        <?php
        include "css/style.css";
        ?>
    </style>
</head>

<body>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/aos.js"></script>
    <script>
        aos.init();
    </script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/emojionearea.min.js"></script>
    <?php
    if ($_SESSION['email']) {
        if (isset($_GET['account'])) {
            $acc = $_GET['account'];
            if ($acc == $email) {
                $sel = $conn->query("select ID,Profile_pic from students_register where Email_id='$acc'");
                if ($sel->num_rows == 1) {
                    $row = $sel->fetch_assoc();
                    $id = $row['ID'];
                    $profile = $row['Profile_pic'];
                    $del = $conn->query("delete from students_register where Email_id='$acc'");
                    if ($del) {
                        unlink("profilepics/$profile");
                        $delp = $conn->query("delete from placement_details where Email_id='$acc'");
                        if ($delp) {
                            $selpost = $conn->query("select User_id,Post_file,Post_id from posts where User_id=$id");
                            if ($selpost->num_rows > 0) {
                                $fetch = $selpost->fetch_assoc();
                                $pid = $fetch['Post_id'];
                                $delpost = $conn->query("delete from posts where User_id=$id");
                                if ($delpost) {
                                    $comsel = $conn->query("select * from comments where User_id=$id");
                                    if ($comsel->num_rows > 0) {
                                        $comdel = $conn->query("delete from comments where User_id=$id");
                                        if ($comdel) {
                                            $_SESSION['title'] = "Thank you for using Students Hub!";
                                            $_SESSION['status_code'] = "success";
                                            $_SESSION['status'] = "Your account has been deleted successfully! You're Welcome again!";
                                            unset($_SESSION['email']);
                                            header("Location:index.php");
                                            ob_end_flush();
                                            exit();
                                        }
                                    } else {
                                        $_SESSION['title'] = "Thank you for using Students Hub!";
                                        $_SESSION['status_code'] = "success";
                                        $_SESSION['status'] = "Your account has been deleted successfully! You're Welcome again!";
                                        unset($_SESSION['email']);
                                        header("Location:index.php");
                                        ob_end_flush();
                                        exit();
                                    }
                                }
                            } else {
                                $comsel = $conn->query("select * from comments where User_id=$id");
                                if ($comsel->num_rows > 0) {
                                    $comdel = $conn->query("delete from comments where User_id=$id");
                                    if ($comdel) {
                                        $_SESSION['title'] = "Thank you for using Students Hub!";
                                        $_SESSION['status_code'] = "success";
                                        $_SESSION['status'] = "Your account has been deleted successfully! You're Welcome again!";
                                        unset($_SESSION['email']);
                                        header("Location:index.php");
                                        ob_end_flush();
                                        exit();
                                    }
                                } else {
                                    $_SESSION['title'] = "Thank you for using Students Hub!";
                                    $_SESSION['status_code'] = "success";
                                    $_SESSION['status'] = "Your account has been deleted successfully! You're Welcome again!";
                                    unset($_SESSION['email']);
                                    header("Location:index.php");
                                    ob_end_flush();
                                    exit();
                                }
                            }
                        }
                    }
                }
            } else {
                $_SESSION['title'] = "Don't do this again!";
                $_SESSION['status_code'] = "warning";
                $_SESSION['status'] = "You cannot delete others account!";
                header("Location:home.php");
                ob_end_flush();
                exit();
            }
        } else {
    ?>
            <h6 class="text-center mt-2">No email found</h6>
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