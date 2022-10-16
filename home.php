<?php
session_start();
ob_start();
require_once "config.php";
$email = $_SESSION['email'];
$res = $conn->query("select * from students_register where Email_id='$email'");

if ($res->num_rows == 1) {
    $row = $res->fetch_assoc();
}
$placsel = $conn->query("select * from placement_details where Email_id='$email'");
if ($placsel->num_rows == 1) {
    $p = $placsel->fetch_assoc();
}
if (isset($_POST['logout'])) {
    unset($_SESSION['email']);
    $_SESSION['status'] = "You were successfully logged out!";
    $_SESSION['title'] = "Thank you for using Students Hub! Welcome again!";
    $_SESSION['status_code'] = "success";
    header("Location:index.php");
    ob_end_flush();
    exit();
}
if (isset($_POST['postsubmit'])) {
    $access = $_POST['postaccess'];
    $caption = nl2br(mysqli_real_escape_string($conn, $_POST['caption']));
    date_default_timezone_set('Asia/Kolkata');
    $timestamp = date("F j,Y, h:i a");
    $doc = $_FILES['documents']['name'];
    $rand = mt_rand(1, 99999999);
    $user_id = $row['ID'];
    if (!empty($caption && $doc)) {
        $doctype = pathinfo($doc, PATHINFO_EXTENSION);
        $allows = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'pptx','txt','docx');
        if (in_array($doctype, $allows)) {
            $documents = $_FILES['documents']['tmp_name'];
            $docnames = $rand . "." . $doctype;
            if (preg_match('/[\'^"£$%&*()}{@#~?><>,|=_+¬-]/', $caption)) {

                $inss = $conn->query("insert into posts(User_id,Post_file,Caption,Post_access,Datetime)values($user_id,'$docnames','$caption','$access','$timestamp')");
                if ($inss) {
                    move_uploaded_file($documents, "posts/" . $docnames);
                    $url = $_SERVER['HTTP_REFERER'];
                    header("Location:$url");
                    exit();
                    $_SESSION['status'] = "Your post has been saved successfully";
                    $_SESSION['title'] = "Success!";
                    $_SESSION['status_code'] = "success";
                } else {
                    $url = $_SERVER['HTTP_REFERER'];
                    header("Location:$url");
                    exit();
                    $_SESSION['status'] = "Your post has not been saved successfully";
                    $_SESSION['title'] = "Something went wrong!";
                    $_SESSION['status_code'] = "error";
                }
            } else {
                $inss = $conn->query("insert into posts(User_id,Post_file,Caption,Post_access,Datetime)values($user_id,'$docnames','$caption','$access','$timestamp')");
                if ($inss) {
                    move_uploaded_file($documents, "posts/" . $docnames);
                    $url = $_SERVER['HTTP_REFERER'];
                    header("Location:$url");
                    exit();
                    $_SESSION['status'] = "Your post has been saved successfully";
                    $_SESSION['title'] = "Success!";
                    $_SESSION['status_code'] = "success";
                } else {
                    $url = $_SERVER['HTTP_REFERER'];
                    header("Location:$url");
                    exit();
                    $_SESSION['status'] = "Your post has not been saved successfully";
                    $_SESSION['title'] = "Something went wrong!";
                    $_SESSION['status_code'] = "error";
                }
            }
        } else {
            $url = $_SERVER['HTTP_REFERER'];
            header("Location:$url");
            exit();
            $_SESSION['status'] = "Only PDF,DOC,PPTX,PNG,JPEG,JPG file format is allowed";
            $_SESSION['title'] = "Data insertion failed!";
            $_SESSION['status_code'] = "error";
        }
    } else if (!empty($caption)) {
        if (preg_match('/[\'^"£$%&*()}{@#~?><>,|=_+¬-]/', $caption)) {
            $insert = $conn->query("insert into posts(User_id,Post_access,Caption,Datetime)values($user_id,'$access','$caption','$timestamp')");
            if ($insert) {
                $url = $_SERVER['HTTP_REFERER'];
                header("Location:$url");
                exit();
                $_SESSION['status'] = "Your post has been saved successfully";
                $_SESSION['title'] = "Success!";
                $_SESSION['status_code'] = "success";
            } else {
                $url = $_SERVER['HTTP_REFERER'];
                header("Location:$url");
                exit();
                $_SESSION['status'] = "Your post has not been saved successfully";
                $_SESSION['title'] = "Something went wrong!";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $insert = $conn->query("insert into posts(User_id,Post_access,Caption,Datetime)values($user_id,'$access','$caption','$timestamp')");
            if ($insert) {
                $url = $_SERVER['HTTP_REFERER'];
                header("Location:$url");
                exit();
                $_SESSION['status'] = "Your post has been saved successfully";
                $_SESSION['title'] = "Success!";
                $_SESSION['status_code'] = "success";
            } else {
                $url = $_SERVER['HTTP_REFERER'];
                header("Location:$url");
                exit();
                $_SESSION['status'] = "Your post has not been saved successfully";
                $_SESSION['title'] = "Something went wrong!";
                $_SESSION['status_code'] = "error";
            }
        }
    } else if (!empty($doc)) {
        $doctype = pathinfo($doc, PATHINFO_EXTENSION);
        $allow = array('jpg', 'jpeg', 'png', 'pdf', 'doc', 'pptx','txt','docx');
        if (in_array($doctype, $allow)) {
            $document = $_FILES['documents']['tmp_name'];
            $docname = $rand . "." . $doctype;
            $ins = $conn->query("insert into posts(User_id,Post_file,Post_access,Datetime)values($user_id,'$docname','$access','$timestamp')");
            if ($ins) {
                move_uploaded_file($document, "posts/" . $docname);
                $url = $_SERVER['HTTP_REFERER'];
                header("Location:$url");
                exit();
                $_SESSION['status'] = "Your post has been saved successfully";
                $_SESSION['title'] = "Success!";
                $_SESSION['status_code'] = "success";
            } else {
                $url = $_SERVER['HTTP_REFERER'];
                header("Location:$url");
                exit();
                $_SESSION['status'] = "Your post has not been saved successfully";
                $_SESSION['title'] = "Something went wrong!";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $url = $_SERVER['HTTP_REFERER'];
            header("Location:$url");
            exit();
            $_SESSION['status'] = "Only PDF,DOC,PPTX,PNG,JPEG,JPG file format is allowed";
            $_SESSION['title'] = "Data insertion failed!";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $url = $_SERVER['HTTP_REFERER'];
        header("Location:$url");
        exit();
        $_SESSION['status'] = "Either Caption or post file is required";
        $_SESSION['title'] = "Your post has not been saved successfully!";
        $_SESSION['status_code'] = "error";
    }
}
if (isset($_GET['post_id'])) {
    $pid = $_GET['post_id'];
    if (isset($_POST['cmtbtn'])) {
        $userid = $row['ID'];
        $comments = nl2br(mysqli_real_escape_string($conn,$_POST['comment']));
        if (!empty($comments)) {
            $cmt = $conn->query("insert into comments(Post_id,User_id,Comments)values($pid,$userid,'$comments')");
            $url = $_SERVER['HTTP_REFERER'];
            if ($cmt) {
                header("Location:$url");
                exit();
            }
        } else {
            $_SESSION['status'] = "Comment cannot be left empty";
            $_SESSION['title'] = "Valid comment needed";
            $_SESSION['status_code'] = "error";
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fa_all.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/emojionearea.min.css">
    <script src="js/jquery.min.js"></script>
    <style>
        <?php
        include "css/style.css";
        ?>
    </style>
</head>

<body>
    <?php
    if ($_SESSION['email']) {
    ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-none top-0 sticky-top">
            <div class="container" style="margin-left:5px">
                <a class="navbar-brand" href="home.php">Students Hub</a>
            </div>
            <div>
                <ul class="navbar-nav mx-auto px-3">
                    <li class="nav-item px-2">
                        <div class="dropdown">
                            <a role="button" class="dropdownn-toggle" data-bs-toggle="dropdown" title="Menu" aria-haspopup="true" aria-expanded="false">
                                <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                            </a>
                            <div class="dropdown-menu" style="margin-left:-92px">
                                <a class="dropdown-item d-flex rounded-3" href="profile.php?account=<?php echo $email ?>" title="Look your profile">
                                    <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                    <h6 class="mt-2">
                                        <?php echo $row['First_name'] ?> <?php echo $row['Last_name'] ?>
                                    </h6>
                                </a>
                                <a class="dropdown-item mt-2 d-flex" href="feedback.php" title="Give feedback">
                                    <i class="fa-solid fa-info me-3" style="margin-left:5px">
                                    </i>
                                    <h6>Feedback</h6>
                                </a>
                                <a class="dropdown-item d-flex mt-2" href="editprofile.php?account=<?php echo $row['Email_id'] ?>" title="Edit your profile">
                                    <i class="fa-solid fa-gear me-3"></i>
                                    <h6>Account settings</h6>
                                </a>
                                <a class="dropdown-item d-flex mt-2" href="removeaccount.php?account=<?php echo $row['Email_id'] ?>">
                                    <i class="fa-solid fa-trash me-2"></i>
                                    <h6> Delete my account</h6>
                                </a>
                                <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" class="dropdown-item mt-2">
                                    <button type="submit" name="logout" class="btn d-flex">
                                        <i class="fa-solid fa-right-from-bracket me-2" style="margin-left: -10px;"></i>
                                        <h6>Log Out</h6>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item mx-4">
                        <div class="dropdown">
                            <a role="button" id="filter" class="text-decoration-none dropdown-toggle" title="Filter posts" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa-solid fa-filter f-20 text-white mt-2"></i>
                            </a>
                            <div class="dropdown-menu text-black-100" style="margin-left:-100px;margin-top:10px;">
                                <a href="home.php?access=Public" class="dropdown-item btn">Public</a>
                                <a href="home.php?access=Department" class="dropdown-item btn">Department</a>
                                <a href="home.php?access=Class" class="dropdown-item btn">Class</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container-fluid mt-md-4 pt-md-4" id="minddiv">
            <div class="row">
                <div class="col-lg-3 col-md-12" id="news">
                    <div class="bg-white p-4 mb-5 shadow border-0" style="border-radius:25px">
                        <div class="row">
                            <h5 class="p-2">Latest Jobs for you</h5>
                            <?php
                            if (str_starts_with($p['Department'], 'B') && $p['Year'] == 'III' || str_starts_with($p['Department'], 'M') && $p['Year'] == 'II') {
                                $jobsel = $conn->query("select * from job_details order by Last_date");
                                if ($jobsel->num_rows > 0) {
                                    date_default_timezone_set('Asia/Kolkata');
                                    $currentdate = date("d-m-Y");
                                    while ($job = $jobsel->fetch_assoc()) {
                                        $jobid = $job['Job_id'];
                                        $applysel = $conn->query("select * from student_details where Job_id=$jobid and Email_id='$email'");
                                        if (!$applysel->num_rows > 0) {
                                            $olddate = $job['Last_date'];
                                            $stamp = strtotime($olddate);
                                            $newdate = date("d-m-Y", $stamp);
                                            $dept = explode(",", $job['Department']);
                                            if ($job['Department'] == 'All' && $job['Percentage'] == 'None' && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    $olddate = $job['Last_date'];
                                                    $stamp = strtotime($olddate);
                                                    $newdate = date("d-m-Y", $stamp);
                            ?>
                                                    <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                        <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                        <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                        <p class="text-center mb-1">Hiring all Departments</p>
                                                        <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                        <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                        <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                        <div class="text-center">
                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else if ($job['Department'] == 'All UG' && $job['Percentage'] == 'None' && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (str_starts_with($p['Department'], 'B')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all UG Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All PG' && $job['Percentage'] == 'None' && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (str_starts_with($p['Department'], 'M')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all PG Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    $olddate = $job['Last_date'];
                                                    $stamp = strtotime($olddate);
                                                    $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                    <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                        <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                        <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                        <p class="text-center mb-1">Hiring all Departments</p>
                                                        <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                        <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                        <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                        <div class="text-center">
                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else if ($job['Department'] == 'All' && $job['Percentage'] = 'None' && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'No') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No' && $p['History_of_backlogs'] == 'No') {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="#" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All UG' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (str_starts_with($p['Department'], 'B')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all UG Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All UG' && $job['Percentage'] == 'None' && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'B')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all UG Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All UG' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'B')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all UG Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All UG' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'No') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No' && $p['History_of_backlogs']) {
                                                        if (str_starts_with($p['Department'], 'B')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all UG Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All PG' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (str_starts_with($p['Department'], 'M')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all PG Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All PG' && $job['Percentage'] == 'None' && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'M')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all PG Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All PG' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'M')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all PG Departments</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == 'All PG' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'No') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No' && $p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'M')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all PG Departments</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All UG', $dept) && $job['Percentage'] == 'None' && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (str_starts_with($p['Department'], 'B')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All UG', $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (str_starts_with($p['Department'], 'B')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All UG', $dept) && $job['Percentage'] == 'None' && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'B')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All UG', $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'B')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All UG', $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'No') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No' && $p['History_of_backlogs']) {
                                                        if (str_starts_with($p['Department'], 'B')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All PG', $dept) && $job['Percentage'] == 'None' && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (str_starts_with($p['Department'], 'M')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All PG', $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (str_starts_with($p['Department'], 'M')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All PG', $dept) && $job['Percentage'] == 'None' && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'M')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All PG', $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        if (str_starts_with($p['Department'], 'M')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array('All PG', $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'No') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No' && $p['History_of_backlogs']) {
                                                        if (str_starts_with($p['Department'], 'M')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                        ?>
                                                            <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                                <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                                <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                                <p class="text-center mb-1">Hiring <?php echo $job['Department'] ?> Departments</p>
                                                                <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                                <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                                <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                                <div class="text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                                </div>
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array($p['Department'], $dept) && $job['Percentage'] == 'None' && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    $olddate = $job['Last_date'];
                                                    $stamp = strtotime($olddate);
                                                    $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                    <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                        <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                        <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                        <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                        <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                        <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                        <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                        <div class="text-center">
                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                            } else if ($job['Department'] == in_array($p['Department'], $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    $olddate = $job['Last_date'];
                                                    $stamp = strtotime($olddate);
                                                    $newdate = date("d-m-Y", $stamp);
                                                ?>
                                                    <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                        <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                        <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                        <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                        <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                        <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                        <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                        <div class="text-center">
                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            } else if ($job['Department'] == in_array($p['Department'], $dept) && $job['Percentage'] == 'None' && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No') {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array($p['Department'], $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'Yes') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if (($p['Backlogs'] == 'No')) {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                                    <?php
                                                    }
                                                }
                                            } else if ($job['Department'] == in_array($p['Department'], $dept) && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'No' &&  $job['His_of_backlog'] == 'No') {
                                                if ($currentdate < $newdate || $currentdate == $newdate) {
                                                    if ($p['Backlogs'] == 'No' && $p['History_of_backlogs'] == 'No') {
                                                        $olddate = $job['Last_date'];
                                                        $stamp = strtotime($olddate);
                                                        $newdate = date("d-m-Y", $stamp);
                                                    ?>
                                                        <div class="bg-white shadow p-2 mb-2" style="border-radius:25px">
                                                            <p class="p-1 fw-bold f-17 text-center mb-1"><?php echo $job['Company_name'] ?></p>
                                                            <p class="text-center mb-1"><?php echo $job['Role'] ?></p>
                                                            <p class="text-center mb-1">Hiring all <?php echo $job['Department'] ?> Departments</p>
                                                            <p class="text-center mb-1">CTC: <?php echo $job['Salary'] ?> LPA</p>
                                                            <p class="text-center mb-1">Bondage: <?php echo $job['Bondage'] ?></p>
                                                            <p class="text-center mb-1">Last date to apply: <?php echo $newdate ?></p>
                                                            <div class="text-center">
                                                                <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="mt-2 btn btn-outline-primary">Apply now</a>
                                                            </div>
                                                        </div>
                                    <?php
                                                    }
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    ?>
                                    <h4>No jobs found!</h4>
                                <?php
                                }
                            } else {
                                ?>
                                <h4>No jobs found!</h4>
                            <?php
                            }
                            ?>
                            <div class="text-center mt-4 mb-2">
                                <a href="jobportal.php?account=<?php echo $email ?>" class="btn btn-outline-dark">See more</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="bg-white p-3 shadow" style="border-radius:15px">
                        <div class="d-flex" type="button">
                            <div class="p-1">
                                <a href="profile.php?account=<?php echo $email ?>" title="Look your profile">
                                    <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="rounded-circle me-2" style="width:44px;height:44px;object-fit: cover" alt="avatar">
                                </a>
                            </div>
                            <input type="text" class="form-control rounded-pill border-0 bg-gray" placeholder="What's on your mind?" disabled type="button" data-bs-toggle="modal" data-bs-target="#postmodal">
                        </div>
                    </div>
                    <div class="bg-white border-0 p-4 mt-4 mb-5 shadow" style="border-radius:15px">
                        <?php
                        if (isset($_GET['access'])) {
                            $access = $_GET['access'];
                            $postsel = $conn->query("select posts.Post_id,posts.User_id,posts.Post_file,posts.Post_access,posts.Caption,posts.Datetime,students_register.ID,students_register.Profile_pic,students_register.First_name,students_register.Email_id,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from posts,students_register where posts.Post_access='$access' and posts.User_id=students_register.ID order by posts.Post_id desc");
                            if ($access == "Department") {
                                if ($postsel->num_rows > 0) {

                                    while ($pos = $postsel->fetch_assoc()) {
                                        if ($row['Department'] == $pos['Department']) {
                                            $postid = $pos['Post_id'];
                                            if (!empty($pos['Post_file'])) {
                                                if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'png') {
                        ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex p-2">
                                                            <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                            </a>
                                                            <div>
                                                                <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                                <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($pos['User_id'] == $row['ID']) {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>

                                                            </ul>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="mt-2 mb-2">
                                                        <p><?php echo nl2br($pos['Caption']) ?></p>
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                            <img src="posts/<?php echo $pos['Post_file'] ?>" class="img-fluid" style="border-radius:10px;display:block;margin-right:auto;margin-left:auto;">
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                                Download</a>
                                                            <form method="POST" action="home.php">
                                                                <?php
                                                                $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                                if ($c->num_rows > 0) {
                                                                    $count = $c->fetch_assoc();
                                                                ?>
                                                                    <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" onclick="getid();" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                        Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                        <div class="accordion border-0" id="accordioncomment">
                                                            <div class="accordion-item">
                                                                <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                    <div class="accordion-body">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">
                                                                                <div class="input-group-text">
                                                                                    <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt1" placeholder="Add comment" name="comment">
                                                                                    <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <?php
                                                                        $post_idd = $pos['Post_id'];
                                                                        $uiid = $row['ID'];
                                                                        $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                        if ($com->num_rows > 0) {
                                                                            while ($comment = $com->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="mt-3 w-100">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                            <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                        </a>
                                                                                        <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                            <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                            <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                            <?php echo $comment['Comments'] ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <h6 class="mt-2 text-center">No comments found!</h6>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'pdf') {
                                                ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex p-2">
                                                            <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                            </a>
                                                            <div>
                                                                <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                                <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($pos['User_id'] == $row['ID']) {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>

                                                            </ul>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="mt-2 mb-2">
                                                        <p><?php echo nl2br($pos['Caption']) ?></p>
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                            <img src="Images/pdf-icon-png-2058.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                                Download</a>
                                                            <form method="POST" action="home.php">
                                                                <?php
                                                                $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                                if ($c->num_rows > 0) {
                                                                    $count = $c->fetch_assoc();
                                                                ?>
                                                                    <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                        Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                        <div class="accordion border-0" id="accordioncomment">
                                                            <div class="accordion-item">
                                                                <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                    <div class="accordion-body">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                                <div class="input-group-text">
                                                                                    <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt2" placeholder="Add comment" name="comment">
                                                                                    <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                                </div>
                                                                            </form>

                                                                        </div>
                                                                        <?php
                                                                        $post_idd = $pos['Post_id'];
                                                                        $uiid = $row['ID'];
                                                                        $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                        if ($com->num_rows > 0) {
                                                                            while ($comment = $com->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="mt-3 w-100">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                            <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                        </a>
                                                                                        <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                            <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                            <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                            <?php echo $comment['Comments'] ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <h6 class="mt-2 text-center">No comments found!</h6>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'pptx') {
                                                ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex p-2">
                                                            <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                            </a>
                                                            <div>
                                                                <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                                <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($pos['User_id'] == $row['ID']) {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>

                                                            </ul>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="mt-2 mb-2">
                                                        <p><?php echo nl2br($pos['Caption']) ?></p>
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                            <img src="Images/ppt-icon-486.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                                Download</a>
                                                            <form method="POST" action="home.php">
                                                                <?php
                                                                $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                                if ($c->num_rows > 0) {
                                                                    $count = $c->fetch_assoc();
                                                                ?>
                                                                    <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                        Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                        <div class="accordion border-0" id="accordioncomment">
                                                            <div class="accordion-item">
                                                                <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                    <div class="accordion-body">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                                <div class="input-group-text">
                                                                                    <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt3" placeholder="Add comment" name="comment">
                                                                                    <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                        <?php
                                                                        $post_idd = $pos['Post_id'];
                                                                        $uiid = $row['ID'];
                                                                        $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                        if ($com->num_rows > 0) {
                                                                            while ($comment = $com->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="mt-3 w-100">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                            <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                        </a>
                                                                                        <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                            <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                            <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                            <?php echo $comment['Comments'] ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <h6 class="mt-2 text-center">No comments found!</h6>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex p-2">
                                                            <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                            </a>
                                                            <div>
                                                                <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                                <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($pos['User_id'] == $row['ID']) {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>

                                                            </ul>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="mt-2 mb-2">
                                                        <p><?php echo nl2br($pos['Caption']) ?></p>
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                            <img src="Images/word-icon-png-4001.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                                Download</a>
                                                            <form method="POST" action="home.php">
                                                                <?php
                                                                $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                                if ($c->num_rows > 0) {
                                                                    $count = $c->fetch_assoc();
                                                                ?>
                                                                    <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                        Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                        <div class="accordion border-0" id="accordioncomment">
                                                            <div class="accordion-item">
                                                                <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                    <div class="accordion-body">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                                <div class="input-group-text">
                                                                                    <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt3" placeholder="Add comment" name="comment">
                                                                                    <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                        <?php
                                                                        $post_idd = $pos['Post_id'];
                                                                        $uiid = $row['ID'];
                                                                        $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                        if ($com->num_rows > 0) {
                                                                            while ($comment = $com->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="mt-3 w-100">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                            <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                        </a>
                                                                                        <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                            <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                            <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                            <?php echo $comment['Comments'] ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <h6 class="mt-2 text-center">No comments found!</h6>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex p-2">
                                                        <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" class="text-decoration-none">
                                                            <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                        </a>
                                                        <div>
                                                            <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                            <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($pos['User_id'] == $row['ID']) {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>

                                                        </ul>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="mt-2 mb-2">
                                                    <p><?php echo nl2br($pos['Caption']) ?></p>
                                                    <div class="d-flex justify-content-end">
                                                        <form method="POST" action="home.php">
                                                            <?php
                                                            $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                            if ($c->num_rows > 0) {
                                                                $count = $c->fetch_assoc();
                                                            ?>
                                                                <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative float-right" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                    Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                </button>
                                                            <?php } ?>
                                                        </form>
                                                    </div>
                                                    <div class="accordion border-0" id="accordioncomments">
                                                        <div class="accordion-item">
                                                            <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomments">
                                                                <div class="accordion-body">
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                        <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                            <div class="input-group-text">
                                                                                <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt4" placeholder="Add comment" name="comment">
                                                                                <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                            </div>

                                                                        </form>

                                                                    </div>
                                                                    <?php
                                                                    $post_idd = $pos['Post_id'];
                                                                    $uiid = $row['ID'];
                                                                    $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.ID,students_register.Email_id,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                    if ($com->num_rows > 0) {
                                                                        while ($comment = $com->fetch_assoc()) {
                                                                    ?>
                                                                            <div class="mt-3 w-100">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                        <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                    </a>
                                                                                    <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                        <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                        <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                        <?php echo $comment['Comments'] ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <h6 class="mt-2 text-center">No comments found!</h6>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <h4>No post found!</h4>
                                    <?php
                                }
                            } else if ($access == 'Class') {
                                if ($postsel->num_rows > 0) {

                                    while ($pos = $postsel->fetch_assoc()) {
                                        if ($row['Year'] == $pos['Year'] && $row['Department'] == $pos['Department'] && $row['Class'] == $pos['Class']) {
                                            $postid = $pos['Post_id'];
                                            if (!empty($pos['Post_file'])) {
                                                if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'png') {
                                    ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex p-2">
                                                            <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                            </a>
                                                            <div>
                                                                <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                                <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($pos['User_id'] == $row['ID']) {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>

                                                            </ul>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="mt-2 mb-2">
                                                        <p><?php echo nl2br($pos['Caption']) ?></p>
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                            <img src="posts/<?php echo $pos['Post_file'] ?>" class="img-fluid" style="border-radius:10px;display:block;margin-right:auto;margin-left:auto;">
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                                Download</a>
                                                            <form method="POST" action="home.php">
                                                                <?php
                                                                $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                                if ($c->num_rows > 0) {
                                                                    $count = $c->fetch_assoc();
                                                                ?>
                                                                    <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" onclick="getid();" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                        Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                        <div class="accordion border-0" id="accordioncomment">
                                                            <div class="accordion-item">
                                                                <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                    <div class="accordion-body">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">
                                                                                <div class="input-group-text">
                                                                                    <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt5" placeholder="Add comment" name="comment">
                                                                                    <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                                </div>

                                                                            </form>
                                                                        </div>
                                                                        <?php
                                                                        $post_idd = $pos['Post_id'];
                                                                        $uiid = $row['ID'];
                                                                        $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                        if ($com->num_rows > 0) {
                                                                            while ($comment = $com->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="mt-3 w-100">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                            <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                        </a>
                                                                                        <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                            <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                            <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                            <?php echo $comment['Comments'] ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <h6 class="mt-2 text-center">No comments found!</h6>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'pdf') {
                                                ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex p-2">
                                                            <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                            </a>
                                                            <div>
                                                                <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                                <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($pos['User_id'] == $row['ID']) {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>

                                                            </ul>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="mt-2 mb-2">
                                                        <p><?php echo nl2br($pos['Caption']) ?></p>
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                            <img src="Images/pdf-icon-png-2058.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                                Download</a>
                                                            <form method="POST" action="home.php">
                                                                <?php
                                                                $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                                if ($c->num_rows > 0) {
                                                                    $count = $c->fetch_assoc();
                                                                ?>
                                                                    <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                        Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                        <div class="accordion border-0" id="accordioncomment">
                                                            <div class="accordion-item">
                                                                <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                    <div class="accordion-body">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                                <div class="input-group-text">
                                                                                    <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt6" placeholder="Add comment" name="comment">
                                                                                    <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                        <?php
                                                                        $post_idd = $pos['Post_id'];
                                                                        $uiid = $row['ID'];
                                                                        $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                        if ($com->num_rows > 0) {
                                                                            while ($comment = $com->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="mt-3 w-100">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                            <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                        </a>
                                                                                        <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                            <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                            <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                            <?php echo $comment['Comments'] ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <h6 class="mt-2 text-center">No comments found!</h6>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'pptx') {
                                                ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex p-2">
                                                            <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                            </a>
                                                            <div>
                                                                <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                                <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($pos['User_id'] == $row['ID']) {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>

                                                            </ul>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="mt-2 mb-2">
                                                        <p><?php echo nl2br($pos['Caption']) ?></p>
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                            <img src="Images/ppt-icon-486.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                                Download</a>
                                                            <form method="POST" action="home.php">
                                                                <?php
                                                                $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                                if ($c->num_rows > 0) {
                                                                    $count = $c->fetch_assoc();
                                                                ?>
                                                                    <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                        Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                        <div class="accordion border-0" id="accordioncomment">
                                                            <div class="accordion-item">
                                                                <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                    <div class="accordion-body">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                                <div class="input-group-text">
                                                                                    <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt7" placeholder="Add comment" name="comment">
                                                                                    <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                        <?php
                                                                        $post_idd = $pos['Post_id'];
                                                                        $uiid = $row['ID'];
                                                                        $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                        if ($com->num_rows > 0) {
                                                                            while ($comment = $com->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="mt-3 w-100">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                            <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                        </a>
                                                                                        <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                            <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                            <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                            <?php echo $comment['Comments'] ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <h6 class="mt-2 text-center">No comments found!</h6>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                } else {
                                                ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex p-2">
                                                            <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                            </a>
                                                            <div>
                                                                <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                                <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        if ($pos['User_id'] == $row['ID']) {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>

                                                            </ul>
                                                        <?php
                                                        } else {
                                                        ?>
                                                            <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                            <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                                </li>
                                                            </ul>
                                                        <?php
                                                        }
                                                        ?>
                                                    </div>
                                                    <div class="mt-2 mb-2">
                                                        <p><?php echo nl2br($pos['Caption']) ?></p>
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                            <img src="Images/word-icon-png-4001.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                        </a>
                                                        <div class="d-flex justify-content-between">
                                                            <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                                Download</a>
                                                            <form method="POST" action="home.php">
                                                                <?php
                                                                $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                                if ($c->num_rows > 0) {
                                                                    $count = $c->fetch_assoc();
                                                                ?>
                                                                    <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                        Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                    </button>
                                                                <?php
                                                                }
                                                                ?>
                                                            </form>
                                                        </div>
                                                        <div class="accordion border-0" id="accordioncomment">
                                                            <div class="accordion-item">
                                                                <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                    <div class="accordion-body">
                                                                        <div class="d-flex align-items-center">
                                                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                                <div class="input-group-text">
                                                                                    <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt8" placeholder="Add comment" name="comment">
                                                                                    <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                                </div>

                                                                            </form>

                                                                        </div>
                                                                        <?php
                                                                        $post_idd = $pos['Post_id'];
                                                                        $uiid = $row['ID'];
                                                                        $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                        if ($com->num_rows > 0) {
                                                                            while ($comment = $com->fetch_assoc()) {
                                                                        ?>
                                                                                <div class="mt-3 w-100">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                            <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                        </a>
                                                                                        <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                            <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                            <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                            <?php echo $comment['Comments'] ?>
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                            <?php
                                                                            }
                                                                        } else {
                                                                            ?>
                                                                            <h6 class="mt-2 text-center">No comments found!</h6>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                }
                                            } else {
                                                ?>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex p-2">
                                                        <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" class="text-decoration-none">
                                                            <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                        </a>
                                                        <div>
                                                            <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                            <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($pos['User_id'] == $row['ID']) {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>

                                                        </ul>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="mt-2 mb-2">
                                                    <p><?php echo nl2br($pos['Caption']) ?></p>
                                                    <div class="d-flex justify-content-end">
                                                        <form method="POST" action="home.php">
                                                            <?php
                                                            $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                            if ($c->num_rows > 0) {
                                                                $count = $c->fetch_assoc();
                                                            ?>
                                                                <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative float-right" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                    Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                </button>
                                                            <?php } ?>
                                                        </form>
                                                    </div>
                                                    <div class="accordion border-0" id="accordioncomments">
                                                        <div class="accordion-item">
                                                            <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomments">
                                                                <div class="accordion-body">
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                        <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                            <div class="input-group-text">
                                                                                <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt9" placeholder="Add comment" name="comment">
                                                                                <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                            </div>

                                                                        </form>

                                                                    </div>
                                                                    <?php
                                                                    $post_idd = $pos['Post_id'];
                                                                    $uiid = $row['ID'];
                                                                    $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.ID,students_register.Email_id,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                    if ($com->num_rows > 0) {
                                                                        while ($comment = $com->fetch_assoc()) {
                                                                    ?>
                                                                            <div class="mt-3 w-100">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                        <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                    </a>
                                                                                    <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                        <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                        <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                        <?php echo $comment['Comments'] ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <h6 class="mt-2 text-center">No comments found!</h6>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <h4>No post found!</h4>
                                    <?php
                                }
                            } else {
                                if ($postsel->num_rows > 0) {

                                    while ($pos = $postsel->fetch_assoc()) {
                                        $postid = $pos['Post_id'];
                                        if (!empty($pos['Post_file'])) {
                                            if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'png') {
                                    ?>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex p-2">
                                                        <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                            <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                        </a>
                                                        <div>
                                                            <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                            <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($pos['User_id'] == $row['ID']) {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>

                                                        </ul>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="mt-2 mb-2">
                                                    <p><?php echo nl2br($pos['Caption']) ?></p>
                                                    <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                        <img src="posts/<?php echo $pos['Post_file'] ?>" class="img-fluid" style="border-radius:10px;display:block;margin-right:auto;margin-left:auto;">
                                                    </a>
                                                    <div class="d-flex justify-content-between">
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                            Download</a>
                                                        <form method="POST" action="home.php">
                                                            <?php
                                                            $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                            if ($c->num_rows > 0) {
                                                                $count = $c->fetch_assoc();
                                                            ?>
                                                                <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" onclick="getid();" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                    Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </form>
                                                    </div>
                                                    <div class="accordion border-0" id="accordioncomment">
                                                        <div class="accordion-item">
                                                            <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                <div class="accordion-body">
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                        <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">
                                                                            <div class="input-group-text">
                                                                                <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt10" placeholder="Add comment" name="comment">
                                                                                <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                    <?php
                                                                    $post_idd = $pos['Post_id'];
                                                                    $uiid = $row['ID'];
                                                                    $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                    if ($com->num_rows > 0) {
                                                                        while ($comment = $com->fetch_assoc()) {
                                                                    ?>
                                                                            <div class="mt-3 w-100">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                        <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                    </a>
                                                                                    <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                        <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                        <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                        <?php echo $comment['Comments'] ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <h6 class="mt-2 text-center">No comments found!</h6>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            } else if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'pdf') {
                                            ?>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex p-2">
                                                        <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                            <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                        </a>
                                                        <div>
                                                            <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                            <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($pos['User_id'] == $row['ID']) {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>

                                                        </ul>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="mt-2 mb-2">
                                                    <p><?php echo nl2br($pos['Caption']) ?></p>
                                                    <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                        <img src="Images/pdf-icon-png-2058.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                    </a>
                                                    <div class="d-flex justify-content-between">
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                            Download</a>
                                                        <form method="POST" action="home.php">
                                                            <?php
                                                            $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                            if ($c->num_rows > 0) {
                                                                $count = $c->fetch_assoc();
                                                            ?>
                                                                <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                    Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </form>
                                                    </div>
                                                    <div class="accordion border-0" id="accordioncomment">
                                                        <div class="accordion-item">
                                                            <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                <div class="accordion-body">
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                        <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                            <div class="input-group-text">
                                                                                <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt11" placeholder="Add comment" name="comment">
                                                                                <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                            </div>

                                                                        </form>

                                                                    </div>
                                                                    <?php
                                                                    $post_idd = $pos['Post_id'];
                                                                    $uiid = $row['ID'];
                                                                    $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                    if ($com->num_rows > 0) {
                                                                        while ($comment = $com->fetch_assoc()) {
                                                                    ?>
                                                                            <div class="mt-3 w-100">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                        <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                    </a>
                                                                                    <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                        <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                        <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                        <?php echo $comment['Comments'] ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <h6 class="mt-2 text-center">No comments found!</h6>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            } else if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'pptx') {
                                            ?>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex p-2">
                                                        <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                            <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                        </a>
                                                        <div>
                                                            <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                            <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($pos['User_id'] == $row['ID']) {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>

                                                        </ul>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="mt-2 mb-2">
                                                    <p><?php echo nl2br($pos['Caption']) ?></p>
                                                    <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                        <img src="Images/ppt-icon-486.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                    </a>
                                                    <div class="d-flex justify-content-between">
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                            Download</a>
                                                        <form method="POST" action="home.php">
                                                            <?php
                                                            $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                            if ($c->num_rows > 0) {
                                                                $count = $c->fetch_assoc();
                                                            ?>
                                                                <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                    Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </form>
                                                    </div>
                                                    <div class="accordion border-0" id="accordioncomment">
                                                        <div class="accordion-item">
                                                            <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                <div class="accordion-body">
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                        <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                            <div class="input-group-text">
                                                                                <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt12" placeholder="Add comment" name="comment">
                                                                                <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                            </div>

                                                                        </form>

                                                                    </div>
                                                                    <?php
                                                                    $post_idd = $pos['Post_id'];
                                                                    $uiid = $row['ID'];
                                                                    $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                    if ($com->num_rows > 0) {
                                                                        while ($comment = $com->fetch_assoc()) {
                                                                    ?>
                                                                            <div class="mt-3 w-100">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                        <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                    </a>
                                                                                    <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                        <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                        <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                        <?php echo $comment['Comments'] ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <h6 class="mt-2 text-center">No comments found!</h6>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div class="d-flex p-2">
                                                        <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                            <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                        </a>
                                                        <div>
                                                            <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                            <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if ($pos['User_id'] == $row['ID']) {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>

                                                        </ul>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                        <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                            </li>
                                                            <li>
                                                                <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                            </li>
                                                        </ul>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="mt-2 mb-2">
                                                    <p><?php echo nl2br($pos['Caption']) ?></p>
                                                    <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                        <img src="Images/word-icon-png-4001.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                    </a>
                                                    <div class="d-flex justify-content-between">
                                                        <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                            Download</a>
                                                        <form method="POST" action="home.php">
                                                            <?php
                                                            $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                            if ($c->num_rows > 0) {
                                                                $count = $c->fetch_assoc();
                                                            ?>
                                                                <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                    Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                                </button>
                                                            <?php
                                                            }
                                                            ?>
                                                        </form>
                                                    </div>
                                                    <div class="accordion border-0" id="accordioncomment">
                                                        <div class="accordion-item">
                                                            <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                                <div class="accordion-body">
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                        <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                            <div class="input-group-text">
                                                                                <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt13" placeholder="Add comment" name="comment">
                                                                                <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                            </div>

                                                                        </form>

                                                                    </div>
                                                                    <?php
                                                                    $post_idd = $pos['Post_id'];
                                                                    $uiid = $row['ID'];
                                                                    $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                    if ($com->num_rows > 0) {
                                                                        while ($comment = $com->fetch_assoc()) {
                                                                    ?>
                                                                            <div class="mt-3 w-100">
                                                                                <div class="d-flex align-items-center">
                                                                                    <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                        <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                    </a>
                                                                                    <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                        <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                        <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                        <?php echo $comment['Comments'] ?>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                    } else {
                                                                        ?>
                                                                        <h6 class="mt-2 text-center">No comments found!</h6>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex p-2">
                                                    <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" class="text-decoration-none">
                                                        <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    </a>
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $row['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>

                                                    </ul>
                                                <?php
                                                } else {
                                                ?>
                                                    <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                        </li>
                                                    </ul>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="mt-2 mb-2">
                                                <p><?php echo nl2br($pos['Caption']) ?></p>
                                                <div class="d-flex justify-content-end">
                                                    <form method="POST" action="home.php">
                                                        <?php
                                                        $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                        if ($c->num_rows > 0) {
                                                            $count = $c->fetch_assoc();
                                                        ?>
                                                            <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative float-right" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                            </button>
                                                        <?php } ?>
                                                    </form>
                                                </div>
                                                <div class="accordion border-0" id="accordioncomments">
                                                    <div class="accordion-item">
                                                        <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomments">
                                                            <div class="accordion-body">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt14" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>

                                                                    </form>

                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $row['ID'];
                                                                $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.ID,students_register.Email_id,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                if ($com->num_rows > 0) {
                                                                    while ($comment = $com->fetch_assoc()) {
                                                                ?>
                                                                        <div class="mt-3 w-100">
                                                                            <div class="d-flex align-items-center">
                                                                                <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                    <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                </a>
                                                                                <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                    <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                    <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                    <?php echo $comment['Comments'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <h6 class="mt-2 text-center">No comments found!</h6>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <h4>No post found!</h4>
                                    <?php
                                }
                            }
                        } else {
                            $postsel = $conn->query("select posts.Post_id,posts.User_id,posts.Post_file,posts.Post_access,posts.Caption,posts.Datetime,students_register.ID,students_register.Profile_pic,students_register.First_name,students_register.Email_id,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from posts,students_register where posts.Post_access='Public' and posts.User_id=students_register.ID order by posts.Post_id desc");
                            if ($postsel->num_rows > 0) {

                                while ($pos = $postsel->fetch_assoc()) {
                                    $postid = $pos['Post_id'];
                                    if (!empty($pos['Post_file'])) {
                                        if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'png') {
                                    ?>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex p-2">
                                                    <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                        <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    </a>
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $row['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>

                                                    </ul>
                                                <?php
                                                } else {
                                                ?>
                                                    <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                        </li>
                                                    </ul>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="mt-2 mb-2">
                                                <p><?php echo nl2br($pos['Caption']) ?></p>
                                                <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                    <img src="posts/<?php echo $pos['Post_file'] ?>" class="img-fluid" style="border-radius:10px;display:block;margin-right:auto;margin-left:auto;">
                                                </a>
                                                <div class="d-flex justify-content-between">
                                                    <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                        Download</a>
                                                    <form method="POST" action="home.php">
                                                        <?php
                                                        $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                        if ($c->num_rows > 0) {
                                                            $count = $c->fetch_assoc();
                                                        ?>
                                                            <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" onclick="getid();" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                            </button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </form>
                                                </div>
                                                <div class="accordion border-0" id="accordioncomment">
                                                    <div class="accordion-item">
                                                        <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                            <div class="accordion-body">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">
                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt15" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>

                                                                    </form>
                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $row['ID'];
                                                                $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                if ($com->num_rows > 0) {
                                                                    while ($comment = $com->fetch_assoc()) {
                                                                ?>
                                                                        <div class="mt-3 w-100">
                                                                            <div class="d-flex align-items-center">
                                                                                <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                    <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                </a>
                                                                                <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                    <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                    <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                    <?php echo $comment['Comments'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <h6 class="mt-2 text-center">No comments found!</h6>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } else if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'pdf') {
                                        ?>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex p-2">
                                                    <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                        <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    </a>
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $row['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>

                                                    </ul>
                                                <?php
                                                } else {
                                                ?>
                                                    <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                        </li>
                                                    </ul>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="mt-2 mb-2">
                                                <p><?php echo nl2br($pos['Caption']) ?></p>
                                                <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                    <img src="Images/pdf-icon-png-2058.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                </a>
                                                <div class="d-flex justify-content-between">
                                                    <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                        Download</a>
                                                    <form method="POST" action="home.php">
                                                        <?php
                                                        $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                        if ($c->num_rows > 0) {
                                                            $count = $c->fetch_assoc();
                                                        ?>
                                                            <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                            </button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </form>
                                                </div>
                                                <div class="accordion border-0" id="accordioncomment">
                                                    <div class="accordion-item">
                                                        <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                            <div class="accordion-body">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt16" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>

                                                                    </form>

                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $row['ID'];
                                                                $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                if ($com->num_rows > 0) {
                                                                    while ($comment = $com->fetch_assoc()) {
                                                                ?>
                                                                        <div class="mt-3 w-100">
                                                                            <div class="d-flex align-items-center">
                                                                                <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                    <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                </a>
                                                                                <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                    <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                    <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                    <?php echo $comment['Comments'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <h6 class="mt-2 text-center">No comments found!</h6>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } else if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'pptx') {
                                        ?>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex p-2">
                                                    <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                        <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    </a>
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $row['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>

                                                    </ul>
                                                <?php
                                                } else {
                                                ?>
                                                    <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                        </li>
                                                    </ul>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="mt-2 mb-2">
                                                <p><?php echo nl2br($pos['Caption']) ?></p>
                                                <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                    <img src="Images/ppt-icon-486.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                </a>
                                                <div class="d-flex justify-content-between">
                                                    <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                        Download</a>
                                                    <form method="POST" action="home.php">
                                                        <?php
                                                        $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                        if ($c->num_rows > 0) {
                                                            $count = $c->fetch_assoc();
                                                        ?>
                                                            <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                            </button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </form>
                                                </div>
                                                <div class="accordion border-0" id="accordioncomment">
                                                    <div class="accordion-item">
                                                        <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                            <div class="accordion-body">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt17" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>

                                                                    </form>

                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $row['ID'];
                                                                $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                if ($com->num_rows > 0) {
                                                                    while ($comment = $com->fetch_assoc()) {
                                                                ?>
                                                                        <div class="mt-3 w-100">
                                                                            <div class="d-flex align-items-center">
                                                                                <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                    <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                </a>
                                                                                <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                    <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                    <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                    <?php echo $comment['Comments'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <h6 class="mt-2 text-center">No comments found!</h6>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex p-2">
                                                    <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" target="_blank" class="text-decoration-none">
                                                        <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    </a>
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $row['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>

                                                    </ul>
                                                <?php
                                                } else {
                                                ?>
                                                    <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                        </li>
                                                    </ul>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="mt-2 mb-2">
                                                <p><?php echo nl2br($pos['Caption']) ?></p>
                                                <a href="posts/<?php echo $pos['Post_file'] ?>">
                                                    <img src="Images/word-icon-png-4001.png" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
                                                </a>
                                                <div class="d-flex justify-content-between">
                                                    <a href="posts/<?php echo $pos['Post_file'] ?>" download class="btn btn-outline-primary mt-3 mb-3"><i class="fas fa-download"></i>
                                                        Download</a>
                                                    <form method="POST" action="home.php">
                                                        <?php
                                                        $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                        if ($c->num_rows > 0) {
                                                            $count = $c->fetch_assoc();
                                                        ?>
                                                            <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                                Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                            </button>
                                                        <?php
                                                        }
                                                        ?>
                                                    </form>
                                                </div>
                                                <div class="accordion border-0" id="accordioncomment">
                                                    <div class="accordion-item">
                                                        <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomment">
                                                            <div class="accordion-body">
                                                                <div class="d-flex align-items-center">
                                                                    <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt18" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>
                                                                        <script type="text/javascript">
                                                                            $('#cmt<?php echo $pos['Post_id'] ?>').emojioneArea({
                                                                                pickerPostion: 'top'
                                                                            });
                                                                        </script>
                                                                    </form>

                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $row['ID'];
                                                                $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.Email_id,students_register.ID,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                                if ($com->num_rows > 0) {
                                                                    while ($comment = $com->fetch_assoc()) {
                                                                ?>
                                                                        <div class="mt-3 w-100">
                                                                            <div class="d-flex align-items-center">
                                                                                <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                    <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                                </a>
                                                                                <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                    <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                    <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                    <?php echo $comment['Comments'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                } else {
                                                                    ?>
                                                                    <h6 class="mt-2 text-center">No comments found!</h6>
                                                                <?php
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex p-2">
                                                <a href="profile.php?account=<?php echo $pos['Email_id'] ?>" class="text-decoration-none">
                                                    <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                </a>
                                                <div>
                                                    <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                    <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                </div>
                                            </div>
                                            <?php
                                            if ($pos['User_id'] == $row['ID']) {
                                            ?>
                                                <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                    <li>
                                                        <a href="editpost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                    </li>
                                                    <li>
                                                        <a href="deletepost.php?postid=<?php echo $pos['Post_id'] ?>" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                    </li>

                                                </ul>
                                            <?php
                                            } else {
                                            ?>
                                                <i class="fas fa-ellipsis-h d-none" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                    <li>
                                                        <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item"><i class="fas fa-trash"></i> Delete Post</a>
                                                    </li>
                                                    <li>
                                                        <a href="#" class="dropdown-item"><i class="fas fa-save"></i> Save Post</a>
                                                    </li>
                                                </ul>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                        <div class="mt-2 mb-2">
                                            <p><?php echo nl2br($pos['Caption']) ?></p>
                                            <div class="d-flex justify-content-end">
                                                <form method="POST" action="home.php">
                                                    <?php
                                                    $c = $conn->query("select count(Comments),posts.Post_id,comments.Post_id from comments inner join posts on comments.Post_id=posts.Post_id where posts.Post_id=$postid");
                                                    if ($c->num_rows > 0) {
                                                        $count = $c->fetch_assoc();
                                                    ?>
                                                        <button type="button" class="btn btn-outline-warning mt-3 mb-3 position-relative float-right" name="commentbtn" data-bs-toggle="collapse" data-bs-target="#post<?php echo $pos['Post_id'] ?>"><i class="fas fa-message"></i>
                                                            Comment<span class="position-absolute top-0 start-100 bg-danger translate-middle badge rounded-pill"><?php echo $count['count(Comments)'] ?></span>
                                                        </button>
                                                    <?php } ?>
                                                </form>
                                            </div>
                                            <div class="accordion border-0" id="accordioncomments">
                                                <div class="accordion-item">
                                                    <div class="accordion-collapse collapse" id="post<?php echo $pos['Post_id'] ?>" data-bs-parent="#accordioncomments">
                                                        <div class="accordion-body">
                                                            <div class="d-flex align-items-center">
                                                                <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                <form method="POST" action="home.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100" autocomplete="off">

                                                                    <div class="input-group-text">
                                                                        <input type="text" class="form-control m-0 rounded-pill border-1 w-100" id="cmt19" placeholder="Add comment" name="comment">
                                                                        <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                    </div>

                                                                </form>

                                                            </div>
                                                            <?php
                                                            $post_idd = $pos['Post_id'];
                                                            $uiid = $row['ID'];
                                                            $com = $conn->query("select comments.Comment_id,comments.Post_id,comments.User_id,comments.Comments,students_register.Profile_pic,students_register.ID,students_register.Email_id,students_register.First_name,students_register.Last_name,students_register.Department,students_register.Year,students_register.Class from (comments join posts on comments.Post_id=posts.Post_id) join students_register on comments.User_id=students_register.ID where comments.Post_id=$post_idd and students_register.ID=comments.User_id order by comments.Comment_id desc");
                                                            if ($com->num_rows > 0) {
                                                                while ($comment = $com->fetch_assoc()) {
                                                            ?>
                                                                    <div class="mt-3 w-100">
                                                                        <div class="d-flex align-items-center">
                                                                            <a href="profile.php?account=<?php echo $comment['Email_id'] ?>" title="Look profile">
                                                                                <img src="profilepics/<?php echo $comment['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                            </a>
                                                                            <p class="bg-grey shadow p-3 m-0" style="border-radius:10px">
                                                                                <span class="fw-bold"><?php echo $comment['First_name'] ?> <?php echo $comment['Last_name'] ?></span><br>
                                                                                <span class="text-muted"><?php echo $comment['Year'] ?> <?php echo $comment['Department'] ?> <?php echo $comment['Class'] ?></span><br>
                                                                                <?php echo $comment['Comments'] ?>
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <h6 class="mt-2 text-center">No comments found!</h6>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                <?php
                                }
                            } else {
                                ?>
                                <h4>No post found!</h4>
                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-3 col-md-12" id="friends">
                    <div class="bg-white p-4 border-0 shadow" style="border-radius:25px">
                        <h5>Look your friends</h5>
                        <?php
                        $profile = $conn->query("select * from students_register where not Email_id='$email' order by ID desc limit 10");
                        if ($profile->num_rows > 0) {
                            while ($fetch = $profile->fetch_assoc()) {
                        ?>
                                <div class="row">
                                    <div class="d-flex align-items-center p-2">
                                        <img src="profilepics/<?php echo $fetch['Profile_pic'] ?>" class="rounded-circle me-2" style="width:35px; height:35px;object-fit:cover">
                                        <div>
                                            <p class="m-0 fw-bold"><?php echo $fetch['First_name'] ?> <?php echo $fetch['Last_name'] ?></p>
                                            <small class="text-muted"><?php echo $fetch['Year'] ?> <?php echo $fetch['Department'] ?> <?php echo $fetch['Class'] ?></small>
                                        </div>
                                    </div>
                                    <div class="text-center mb-4">
                                        <a href="profile.php?account=<?php echo $fetch['Email_id'] ?>" class="btn btn-outline-success"><i class="fas fa-eye" id="eye"></i>
                                            Look profile</a>
                                    </div>
                                </div>
                            <?php
                            }
                        } else {
                            ?>
                            <h6>Sorry!No users found other than you</h6>
                        <?php
                        }
                        ?>
                        <div class="mt-3 mb-2 text-center">
                            <a href="profileportal.php" class="btn btn-outline-dark">See more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" tabindex="-1" id="postmodal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="align-items-center">
                            <h4 class="text-center">Create Post</h4>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center">
                                    <div class="p-2">
                                        <img src="./profilepics/<?php echo $row['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover" alt="avatar">
                                    </div>
                                    <p class="m-0 fw-bold"><?php echo $row['First_name'] ?> <?php echo $row['Last_name'] ?></p>
                                    <select name="postaccess" class="mx-5 form-select border-0 bg-gray" style="width:35%;">
                                        <option value="Public">Public</option>
                                        <option value="Department">Department</option>
                                        <option value="Class">Class</option>
                                    </select>
                                </div>
                                <div>
                                    <textarea rows="5" cols="30" class="border-1 form-control mb-2" id="caption" name="caption"></textarea>
                                    <div class="d-flex justify-content-end">
                                        <input type="file" class="form-control" name="documents" placeholder="Choose file">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="postsubmit" class="btn btn-primary w-100">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    } else {
        unset($_SESSION['email']);
        header("Location:index.php");
        ob_end_flush();
        exit();
    }
    ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/aos.js"></script>
    <script>
        aos.init();
    </script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/emojionearea.min.js"></script>
    <?php
    if (isset($_SESSION['status'])) {
    ?>
        <script>
            swal({
                title: "<?php echo $_SESSION['title'] ?>",
                text: "<?php echo $_SESSION['status'] ?>",
                icon: "<?php echo $_SESSION['status_code'] ?>",
                button: "Okay!",
            });
        </script>
    <?php
        unset($_SESSION['status']);
    }
    ?>
    <script type="text/javascript">
        $('#caption').emojioneArea({
            pickerPostion: 'right'
        });
    </script>
</body>

</html>
