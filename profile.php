<?php
session_start();
require_once "config.php";
$emailid = $_SESSION['email'];
$res = $conn->query("select * from students_register where Email_id='$emailid'");

if ($res->num_rows == 1) {
    $rows = $res->fetch_assoc();
}
if (isset($_GET['post_id'])) {
    $pid = $_GET['post_id'];
    if (isset($_POST['cmtbtn'])) {
        $userid = $rows['ID'];
        $comments = $_POST['comment'];
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
    <title>Profile - View</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fa_all.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <script src="js/jquery.min.js"></script>
    <style>
        <?php
        include "css/style.css";
        ?>
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-none top-0 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Students Hub</a>
        </div>
    </nav>
    <?php
    if (isset($_GET['account'])) {
        $email = $_GET['account'];
    ?>
        <section id="profile" class="mt-3">
            <div class="container">
                <div class="card bg-white shadow border-0 text-center p-4" style="border-radius:25px">
                    <?php
                    $sel = $conn->query("select students_register.Profile_pic,students_register.From_address,students_register.Lives_in,placement_details.Full_name,students_register.Year,students_register.Department,students_register.Class,placement_details.Bio,students_register.Gender,placement_details.Skills,students_register.Email_id from students_register inner join placement_details on students_register.Email_id=placement_details.Email_id where students_register.Email_id='$email'");
                    if ($sel->num_rows == 1) {
                        $row = $sel->fetch_assoc();
                    ?>
                        <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="rounded-circle" style="width:150px;height:150px;object-fit:cover;display:block;margin-left: auto;margin-right: auto">
                        <div class="row mt-3">
                            <h5><?php echo $row['Full_name'] ?></h5>
                            <span class="text-muted"><?php echo $row['Year'] ?> <?php echo $row['Department'] ?> <?php echo $row['Class'] ?></span>
                        </div>
                </div>
                <div class="row mt-4 mb-5">
                    <div class="col-md-4">
                        <div class="bg-white border-0 p-3 shadow" style="border-radius:25px">
                            <div class="row text-center p-3">
                                <h5>User Details</h5>
                            </div>
                            <hr>
                            <h5><i class="fas fa-circle-info"></i> About</h5>
                            <div class="row">
                                <p class="text-muted"><?php echo nl2br($row['Bio']) ?></p>
                                <hr>
                                <div class="row">
                                    <ul class="userdetails">
                                        <li class="mb-2">
                                            <i class="fas fa-envelope px-4"></i><a href="mailto:<?php echo $row['Email_id'] ?>" target="_blank" title="Mail to <?php echo $row['Full_name'] ?>" class="text-decoration-none btn"><?php echo $row['Email_id'] ?></a>
                                        </li>
                                        <li class="mb-3">
                                            <i class="fa-solid fa-location-dot px-4"></i><span class="fw-bold">From</span> <?php echo $row['From_address'] ?>
                                        </li>
                                        <li class="mb-3">
                                            <i class="fa-solid fa-house-chimney px-4"></i><span class="fw-bold">Lives in</span> <?php echo $row['Lives_in'] ?>
                                        </li>
                                        <li class="mb-3">
                                            <i class="fas fa-user px-4"></i> <?php echo $row['Gender'] ?>
                                        </li>
                                        <li class="mb-3"></li>
                                    </ul>
                                </div>
                                <hr>
                                <div class="row">
                                    <h5><i class="fas fa-chalkboard-user"></i> Skills</h5>
                                    <p>
                                        <?php echo nl2br($row['Skills']) ?>
                                    </p>
                                </div>
                            </div>

                        </div>
                        <div class="shadow p-3 bg-white mt-3 border-0" style="border-radius:25px;">
                            <div class="row text-center p-2">
                                <h5 class="p-3">Jobs applied</h5>
                                <hr>
                            </div>
                            <div class="row">
                                <?php
                                $jobssel = $conn->query("select * from student_details where Email_id='$email' order by ID desc");
                                if ($jobssel->num_rows > 0) {
                                    while($c=$jobssel->fetch_assoc()){
                                ?>
                                <ul class="mx-2" style="list-style:none">
                                    <li>
                                        <b><?php echo $c['Company_name'] ?></b> - <?php echo $c['Role'] ?>
                                    </li>
                                </ul>
                                <?php
                                    }
                                }else{
                                    ?>
                                    <h5 class="text-center">Not yet applied to any jobs!</h5>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 shadow bg-white border-0 h-100 p-3 mb-5" style="border-radius:15px">
                        <div class="bg-white border-0 p-2" style="border-radius:15px">
                            <?php
                            $postsel = $conn->query("select posts.Post_id,posts.Post_access,posts.User_id,posts.Post_file,posts.Caption,posts.Datetime,students_register.ID,students_register.Profile_pic,students_register.First_name,students_register.Last_name from posts inner join students_register on posts.User_id=students_register.ID where students_register.Email_id='$email' and posts.Post_access='Public' order by posts.Post_id desc");
                            if ($postsel->num_rows > 0) {

                                while ($pos = $postsel->fetch_assoc()) {
                                    $postid = $pos['Post_id'];
                                    if (!empty($pos['Post_file'])) {
                                        if (pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($pos['Post_file'], PATHINFO_EXTENSION) == 'png') {
                            ?>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex p-2">
                                                    <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $rows['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
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
                                                    <img src="posts/<?php echo $pos['Post_file'] ?>" class="img-fluid" style="border-radius:10px;display:block;margin-left:auto;margin-right:auto;">
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
                                                                    <img src="profilepics/<?php echo $rows['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="profile.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100">
                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $rows['ID'];
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
                                                    <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $rows['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
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
                                                                    <img src="profilepics/<?php echo $rows['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="profile.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100">

                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $rows['ID'];
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
                                                    <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $rows['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
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
                                                                    <img src="profilepics/<?php echo $rows['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="profile.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100">

                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $rows['ID'];
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
                                                    <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                    <div>
                                                        <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                        <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($pos['User_id'] == $rows['ID']) {
                                                ?>
                                                    <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                    <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                        <li>
                                                            <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
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
                                                                    <img src="profilepics/<?php echo $rows['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                    <form method="POST" action="profile.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100">

                                                                        <div class="input-group-text">
                                                                            <input type="text" class="form-control m-0 rounded-pill border-1 w-100" placeholder="Add comment" name="comment">
                                                                            <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                                <?php
                                                                $post_idd = $pos['Post_id'];
                                                                $uiid = $rows['ID'];
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
                                                <img src="profilepics/<?php echo $pos['Profile_pic'] ?>" class="rounded-circle me-2" style="width:38px;height:38px;object-fit:cover">
                                                <div>
                                                    <p class="m-0 fw-bold"><?php echo $pos['First_name'] ?> <?php echo $pos['Last_name'] ?></p>
                                                    <span class="text-muted"><?php echo $pos['Datetime'] ?></span>
                                                </div>
                                            </div>
                                            <?php
                                            if ($pos['User_id'] == $rows['ID']) {
                                            ?>
                                                <i class="fas fa-ellipsis-h" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="postmenu"></i>
                                                <ul class="dropdown-menu border-0 shadow bg-white p-3" aria-labelledby="#postmenu">
                                                    <li>
                                                        <a href="#" class="dropdown-item"><i class="fas fa-edit"></i> Edit Post</a>
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
                                                                <img src="profilepics/<?php echo $rows['Profile_pic'] ?>" class="me-2 rounded-circle" style="width:34px;height:34px;object-fit:cover">
                                                                <form method="POST" action="profile.php?post_id=<?php echo $pos['Post_id'] ?>" class="w-100">

                                                                    <div class="input-group-text">
                                                                        <input type="text" class="form-control m-0 rounded-pill border-1 w-100" placeholder="Add comment" name="comment">
                                                                        <button type="submit" class="btn" name="cmtbtn"><i class="fa-solid fa-circle-arrow-right"></i></button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                            <?php
                                                            $post_idd = $pos['Post_id'];
                                                            $uiid = $rows['ID'];
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
                                <h4 class="text-center">No post found!</h4>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                <?php
                    } else {
                ?>
                    <h5>No email id found!</h5>
                <?php
                    }
                ?>
                </div>
        </section>
    <?php
    } else {
    ?>
        <h5 class="mt-3">No user found</h5>
    <?php
    }
    ?>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/aos.js"></script>
    <script>
        aos.init();
    </script>
    <script src="js/sweetalert.min.js"></script>
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
</body>

</html>