<?php
session_start();
ob_start();
require_once "config.php";
$email = $_SESSION['email'];
$res = $conn->query("select * from students_register where Email_id='$email'");

if ($res->num_rows == 1) {
    $rows = $res->fetch_assoc();
}
if (isset($_POST['update'])) {
    $caption = nl2br(mysqli_real_escape_string($conn, $_POST['caption']));
    $postid = $_POST['id'];
    $doc = $_FILES['profilepic']['name'];
    $access = $_POST['access'];
    $rand = mt_rand(1, 99999999);
    $pos = $conn->query("select * from posts where Post_id=$postid");
    if ($pos->num_rows == 1) {
        $p = $pos->fetch_assoc();
        $uid = $p['User_id'];
        $postfile = $p['Post_file'];
        $capt = $p['Caption'];
        if (!empty($access)) {
            if ($postfile != "" && $capt != "") {
                if ($doc == "") {
                    if ($p['Caption'] == "") {
                        $update1 = $conn->query("update posts set Post_access='$access' where Post_id=$postid");
                        if ($update1) {
                            $_SESSION['title'] = "Success";
                            $_SESSION['status'] = "Your post has been updated successfully";
                            $_SESSION['status_code'] = "success";
                            header("Location:home.php");
                            ob_end_flush();
                            exit();
                        }
                    } else {
                        $update2 = $conn->query("update posts set Caption='$caption',Post_access='$access' where Post_id=$postid");
                        if ($update2) {
                            $_SESSION['title'] = "Success";
                            $_SESSION['status'] = "Your post has been updated successfully";
                            $_SESSION['status_code'] = "success";
                            header("Location:home.php");
                            ob_end_flush();
                            exit();
                        }
                    }
                } else {
                    $doctype = pathinfo($doc, PATHINFO_EXTENSION);
                    $allow = array('jpg', 'jpeg', 'png', 'pdf', 'pptx', 'doc', 'docx', 'txt');
                    if (in_array($doctype, $allow)) {
                        $profilepics = $_FILES['profilepic']['tmp_name'];
                        $picname =  $uid . $rand . "." . $doctype;
                        $update3 = $conn->query("update posts set Caption='$caption',Post_file='$picname',Post_access='$access' where Post_id=$postid");
                        if ($update3) {
                            move_uploaded_file($profilepics, "posts/" . $picname);
                            unlink("posts/$postfile");
                            $_SESSION['title'] = "Success";
                            $_SESSION['status'] = "Your post has been updated successfully";
                            $_SESSION['status_code'] = "success";
                            header("Location:home.php");
                            ob_end_flush();
                            exit();
                        }
                    } else {
                        $_SESSION['status'] = "Only PDF,DOC,PPTX,PNG,JPEG,JPG file format is allowed";
                        $_SESSION['title'] = "Data insertion failed!";
                        $_SESSION['status_code'] = "error";
                    }
                }
            } else if ($postfile != "") {
                if ($doc == "") {
                    $update2 = $conn->query("update posts set Post_access='$access' where Post_id=$postid");
                    if ($update2) {
                        $_SESSION['title'] = "Success";
                        $_SESSION['status'] = "Your post has been updated successfully";
                        $_SESSION['status_code'] = "success";
                        header("Location:home.php");
                        ob_end_flush();
                        exit();
                    }
                } else {
                    $doctype = pathinfo($doc, PATHINFO_EXTENSION);
                    $allow = array('jpg', 'jpeg', 'png', 'pdf', 'pptx', 'doc', 'docx', 'txt');
                    if (in_array($doctype, $allow)) {
                        $profilepics = $_FILES['profilepic']['tmp_name'];
                        $picname =  $uid . $rand . "." . $doctype;
                        $update3 = $conn->query("update posts set Caption='$caption',Post_file='$picname',Post_access='$access' where Post_id=$postid");
                        if ($update3) {
                            move_uploaded_file($profilepics, "posts/" . $picname);
                            unlink("posts/$postfile");
                            $_SESSION['title'] = "Success";
                            $_SESSION['status'] = "Your post has been updated successfully";
                            $_SESSION['status_code'] = "success";
                            header("Location:home.php");
                            ob_end_flush();
                            exit();
                        }
                    } else {
                        $_SESSION['status'] = "Only PDF,DOC,PPTX,PNG,JPEG,JPG file format is allowed";
                        $_SESSION['title'] = "Data insertion failed!";
                        $_SESSION['status_code'] = "error";
                    }
                }
            } else if ($capt != "") {

                $update2 = $conn->query("update posts set Caption='$caption',Post_access='$access' where Post_id=$postid");
                if ($update2) {
                    $_SESSION['title'] = "Success";
                    $_SESSION['status'] = "Your post has been updated successfully";
                    $_SESSION['status_code'] = "success";
                    header("Location:home.php");
                    ob_end_flush();
                    exit();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - Post</title>
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
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Students Hub</a>
            </div>
        </nav>
        <?php
        if (isset($_GET['postid'])) {
            $pid = $_GET['postid'];
            $sel = $conn->query("select * from posts where Post_id=$pid");
            if ($sel->num_rows == 1) {
                $row = $sel->fetch_assoc();
                if ($row['User_id'] == $rows['ID']) {
        ?>
                    <section id="editposts">
                        <div class="mt-5 mb-5 shadow p-5 w-100 text-white" style="display:block;margin-left:auto;margin-right:auto;border-radius:25px;background-color: #485461;background-image: linear-gradient(315deg, #485461 0%, #28313b 74%);">
                            <h5>Edit Post</h5>
                            <hr>
                            <div class="row">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <?php
                                    if ($row['Post_file'] != "") {
                                        if ($row['Caption'] == "") {
                                            if (pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'png') { ?>
                                                <div class="post-pic-div">
                                                    <img src="posts/<?php echo $row['Post_file'] ?>" id="photo">
                                                    <input type="file" id="file" name="profilepic">
                                                    <label for="file" id="uploadBtn">Choose Photo</label>
                                                </div>
                                                <div class="row my-3">
                                                    <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                    <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                    <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                                </div>
                                                <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                                </div>
                                            <?php
                                            } else if (pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'pdf' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'pptx' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'doc' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'docx' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'txt') {
                                            ?>
                                                <input type="file" name="profilepic" class="form-control">
                                                <span class="text-white-50 f-14">Your post was in the .<?php echo pathinfo($row['Post_file'], PATHINFO_EXTENSION) ?> format</span>
                                                <div class="row my-3">
                                                    <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                    <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                    <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                                </div>
                                                <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="row my-3">
                                                    <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                    <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                    <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                                </div>
                                                <div class="row my-3">
                                                    <textarea class="form-control" id="about" name="caption" rows="4"><?php echo $row['Caption'] ?></textarea>
                                                </div>
                                                <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                                </div>
                                            <?php
                                            }
                                        } else {
                                            if (pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'png') { ?>
                                                <div class="post-pic-div">
                                                    <img src="posts/<?php echo $row['Post_file'] ?>" id="photo">
                                                    <input type="file" id="file" name="profilepic">
                                                    <label for="file" id="uploadBtn">Choose Photo</label>
                                                </div>
                                                <div class="row my-3">
                                                    <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                    <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                    <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                                </div>
                                                <div class="row my-3">
                                                    <textarea class="form-control" id="about" name="caption" rows="4"><?php echo $row['Caption'] ?></textarea>
                                                </div>
                                                <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                                </div>
                                            <?php
                                            } else if (pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'pdf' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'pptx' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'doc' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'docx' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'txt') {
                                            ?>
                                                <input type="file" name="profilepic" class="form-control">
                                                <span class="text-white-50 f-14">Your post was in the .<?php echo pathinfo($row['Post_file'], PATHINFO_EXTENSION) ?> format</span>
                                                <div class="row my-3">
                                                    <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                    <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                    <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                                </div>
                                                <div class="row my-3">
                                                    <textarea class="form-control" id="about" name="caption" rows="4"><?php echo $row['Caption'] ?></textarea>
                                                </div>
                                                <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="row my-3">
                                                    <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                    <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                    <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                                </div>
                                                <div class="row my-3">
                                                    <textarea class="form-control" id="about" name="caption" rows="4"><?php echo $row['Caption'] ?></textarea>
                                                </div>
                                                <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                    <button type="submit" name="update" class="btn btn-success">Update</button>
                                                </div>
                                        <?php
                                            }
                                        } ?>
                                        <?php } else if ($row['Caption'] != "") {
                                        if (pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'png') { ?>
                                            <div class="post-pic-div">
                                                <img src="posts/<?php echo $row['Post_file'] ?>" id="photo">
                                                <input type="file" id="file" name="profilepic">
                                                <label for="file" id="uploadBtn">Choose Photo</label>
                                            </div>
                                            <div class="row my-3">
                                                <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                            </div>
                                            <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                            </div>
                                        <?php
                                        } else if (pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'pdf' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'pptx' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'doc' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'docx' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'txt') {
                                        ?>
                                            <input type="file" name="profilepic" class="form-control">
                                            <span class="text-white-50 f-14">Your post was in the .<?php echo pathinfo($row['Post_file'], PATHINFO_EXTENSION) ?> format</span>
                                            <div class="row my-3">
                                                <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                            </div>
                                            <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="row my-3">
                                                <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                            </div>
                                            <div class="row my-3">
                                                <textarea class="form-control" id="about" name="caption" rows="4"><?php echo $row['Caption'] ?></textarea>
                                            </div>
                                            <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                            </div>
                                        <?php
                                        }
                                    } else {
                                        if (pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'jpeg' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'png') { ?>
                                            <div class="post-pic-div">
                                                <img src="posts/<?php echo $row['Post_file'] ?>" id="photo">
                                                <input type="file" id="file" name="profilepic">
                                                <label for="file" id="uploadBtn">Choose Photo</label>
                                            </div>
                                            <div class="row my-3">
                                                <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                            </div>
                                            <div class="row my-3">
                                                <textarea class="form-control" id="about" name="caption" rows="4"><?php echo $row['Caption'] ?></textarea>
                                            </div>
                                            <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                            </div>
                                        <?php
                                        } else if (pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'pdf' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'pptx' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'doc' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'docx' || pathinfo($row['Post_file'], PATHINFO_EXTENSION) == 'txt') {
                                        ?>
                                            <input type="file" name="profilepic" class="form-control">
                                            <span class="text-white-50 f-14">Your post was in the .<?php echo pathinfo($row['Post_file'], PATHINFO_EXTENSION) ?> format</span>
                                            <div class="row my-3">
                                                <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                            </div>
                                            <div class="row my-3">
                                                <textarea class="form-control" id="about" name="caption" rows="4"><?php echo $row['Caption'] ?></textarea>
                                            </div>
                                            <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <div class="row my-3">
                                                <input type="hidden" value="<?php echo $row['Post_id'] ?>" name="id">
                                                <input type="text" class="form-control" value="<?php echo $row['Post_access'] ?>" name="access">
                                                <span class="text-white-50 f-14">You can choose any of Public/Department/Class</span>
                                            </div>
                                            <div class="row my-3">
                                                <textarea class="form-control" id="about" name="caption" rows="4"><?php echo $row['Caption'] ?></textarea>
                                            </div>
                                            <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                                <button type="submit" name="update" class="btn btn-success">Update</button>
                                            </div>
                                    <?php
                                        }
                                    } ?>
                                    <?php ?>
                                </form>
                            </div>
                        </div>
                    </section>
        <?php
                } else {
                    $_SESSION['title'] = "Don't do this!";
                    $_SESSION['status'] = "You cannot edit other's post";
                    $_SESSION['status_code'] = "warning";
                }
            }
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
        <script>
            //declearing html elements

            const imgDiv = document.querySelector('.post-pic-div');
            const img = document.querySelector('#photo');
            const file = document.querySelector('#file');
            const uploadBtn = document.querySelector('#uploadBtn');

            //if user hover on img div 

            imgDiv.addEventListener('mouseenter', function() {
                uploadBtn.style.display = "block";
            });

            //if we hover out from img div

            imgDiv.addEventListener('mouseleave', function() {
                uploadBtn.style.display = "none";
            });

            //lets work for image showing functionality when we choose an image to upload

            //when we choose a foto to upload

            file.addEventListener('change', function() {
                //this refers to file
                const choosedFile = this.files[0];

                if (choosedFile) {

                    const reader = new FileReader(); //FileReader is a predefined function of JS

                    reader.addEventListener('load', function() {
                        img.setAttribute('src', reader.result);
                    });

                    reader.readAsDataURL(choosedFile);

                    //Allright is done
                }
            });
        </script>
        <script type="text/javascript">
            $('#about').emojioneArea({
                pickerPostion: 'right'
            });
        </script>
    <?php } else {
        header("Location:index.php");
        ob_end_flush();
        exit();
    } ?>
</body>

</html>
