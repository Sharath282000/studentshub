<?php
session_start();
ob_start();
require_once "config.php";
$email = $_SESSION['email'];
if (isset($_POST['update'])) {
    $oldpic = $_POST['oldpic'];
    $id = $_POST['id'];
    $profilepic = $_FILES['profilepic']['name'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $emailid = $_POST['email'];
    $year = $_POST['year'];
    $bcity = $_POST['bcity'];
    $lcity = $_POST['lcity'];
    $age = $_POST['age'];
    $bio = nl2br(mysqli_real_escape_string($conn, $_POST['bio']));
    $tenthper = $_POST['10thper'];
    $twelper = $_POST['12thper'];
    $semper = $_POST['semper'];
    $cgpa = $_POST['cgpa'];
    $backlogs = $_POST['backlogs'];
    $numbacklog = $_POST['numbacklog'];
    $hisbacklogs = $_POST['hisbacklogs'];
    $skills = nl2br(mysqli_real_escape_string($conn, $_POST['skills']));
    $fullname = $fname . "" . $lname;
    $rand = mt_rand(1, 99999999);
    if (!empty($oldpic && $fname && $lname && $year && $bcity && $lcity && $age && $bio && $tenthper && $twelper && $semper && $cgpa && $backlogs && $numbacklog && $hisbacklogs && $skills)) {
        if ($profilepic == "") {
            if (ctype_alpha($fname) && ctype_alpha($lname)) {
                $update1 = $conn->query("update students_register set First_name='$fname',Last_name='$lname',Year='$year',From_address='$bcity',Lives_in='$lcity',Age='$age' where Email_id='$emailid'");
                if ($update1) {
                    $update2 = $conn->query("update placement_details set Full_name='$fullname',Year='$year',Bio='$bio',10th_percentage='$tenthper',12th_percentage='$twelper',Sem_percentage='$semper',Sem_CGPA='$cgpa',Backlogs='$backlogs',No_of_backlogs='$numbacklog',History_of_backlogs='$hisbacklogs',Skills='$skills' where Email_id='$emailid'");
                    if ($update2) {
                        $_SESSION['title'] = "Success";
                        $_SESSION['status'] = "Your account has been updated successfully";
                        $_SESSION['status_code'] = "success";
                        header("Location:home.php");
                        ob_end_flush();
                        exit();
                    }
                }
            } else {
                $_SESSION['status'] = "Only letters allowed in name";
                $_SESSION['title'] = "Data insertion failed!";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $profilepictype = pathinfo($profilepic, PATHINFO_EXTENSION);
            $allow = array('jpg', 'jpeg', 'png');
            if (in_array($profilepictype, $allow)) {
                $profilepics = $_FILES['profilepic']['tmp_name'];
                $picname =  $id . $rand . "." . $profilepictype;
                if (ctype_alpha($fname) && ctype_alpha($lname)) {
                    $update1 = $conn->query("update students_register set Profile_pic='$picname',First_name='$fname',Last_name='$lname',Year='$year',From_address='$bcity',Lives_in='$lcity',Age='$age' where Email_id='$emailid'");
                    if ($update1) {
                        move_uploaded_file($profilepics, "profilepics/" . $picname);
                        unlink("profilepics/$oldpic");
                        $update2 = $conn->query("update placement_details set Full_name='$fullname',Year='$year',Bio='$bio',10th_percentage='$tenthper',12th_percentage='$twelper',Sem_percentage='$semper',Sem_CGPA='$cgpa',Backlogs='$backlogs',No_of_backlogs='$numbacklog',History_of_backlogs='$hisbacklogs',Skills='$skills' where Email_id='$emailid'");
                        if ($update2) {
                            $_SESSION['title'] = "Success";
                            $_SESSION['status'] = "Your account has been updated successfully";
                            $_SESSION['status_code'] = "success";
                            header("Location:home.php");
                            ob_end_flush();
                            exit();
                        }
                    }
                } else {
                    $_SESSION['status'] = "Only letters allowed in name";
                    $_SESSION['title'] = "Data insertion failed!";
                    $_SESSION['status_code'] = "error";
                }
            } else {
                $_SESSION['status'] = "Only PNG,JPG,JPEG format for profile pic is allowed";
                $_SESSION['status_code'] = "error";
                $_SESSION['title'] = "Data insertion failed";
            }
        }
    } else {
        $_SESSION['status'] = "Insert the needed data!";
        $_SESSION['title'] = "Data updation failed!";
        $_SESSION['status_code'] = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit - Profile</title>
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
        if (isset($_GET['account'])) {
            $acc = $_GET['account'];
            if ($acc == $email) {
                $sel = $conn->query("select * from students_register where Email_id='$acc'");
                if ($sel->num_rows == 1) {
                    $row = $sel->fetch_assoc();
                    $plac = $conn->query("select * from placement_details where Email_id='$acc'");
                    if ($plac->num_rows == 1) {
                        $p = $plac->fetch_assoc();
        ?>
                        <section id="editprofile">
                            <div class="mt-5 mb-5 shadow p-5 w-50 text-white" style="display:block;margin-left:auto;margin-right:auto;border-radius:25px;background-color: #485461;background-image: linear-gradient(315deg, #485461 0%, #28313b 74%);">
                                <h5><i class="fa-solid fa-gear"></i> Account Settings</h5>
                                <hr>
                                <div class="row">
                                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                        <div class="profile-pic-div">
                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" id="photo">
                                            <input type="hidden" name="oldpic" value="<?php echo $row['Profile_pic'] ?>">
                                            <input type="file" id="file" name="profilepic">
                                            <label for="file" id="uploadBtn">Choose Photo</label>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <input type="hidden" value="<?php echo $row['ID'] ?>" name="id">
                                                <input type="text" name="fname" value="<?php echo $row['First_name'] ?>" placeholder="First Name" class="form-control" required>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="lname" value="<?php echo $row['Last_name'] ?>" placeholder="Last Name" class="form-control" required>
                                            </div>
                                        </div>
                                        <input type="email" name="email" class="form-control my-1" value="<?php echo $row['Email_id'] ?>" readonly>
                                        <div class="row my-3">
                                            <?php
                                            if ($row['Year'] == 'III') {
                                            ?>
                                                <div class="col">
                                                    <input type="text" name="year" value="<?php echo $row['Year'] ?>" class="form-control" readonly>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="col">
                                                    <input type="text" name="year" value="<?php echo $row['Year'] ?>" class="form-control" required>
                                                    <span class="text-white-50 f-14">Change with roman letters only like I,II,III</span>
                                                </div>
                                            <?php
                                            } ?>
                                            <div class="col">
                                                <input type="text" value="<?php echo $row['Department'] ?>" class="form-control" readonly>
                                            </div>
                                            <div class="col">
                                                <input type="text" value="<?php echo $row['Class'] ?>" class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <input type="text" name="bcity" value="<?php echo $row['From_address'] ?>" class="form-control" required>
                                                <span class="text-white-50 f-14">City from where you born</span>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="lcity" value="<?php echo $row['Lives_in'] ?>" class="form-control" required>
                                                <span class="text-white-50 f-14">City from where you lives now</span>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="age" class="form-control" value="<?php echo $row['Age'] ?>" required>
                                                <span class="text-white-50 f-14">Your current age</span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <textarea class="form-control" name="bio" id="about" placeholder="Enter about yourself" rows="3" required><?php echo $p['Bio'] ?></textarea>
                                            <small class="text-white-50 f-14">Note: Your bio describes yourself in short format.</small>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <input type="text" name="10thper" value="<?php echo $p['10th_percentage'] ?>" class="form-control" required>
                                                <span class="text-white-50 f-14">Your 10th percentage</span>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="12thper" value="<?php echo $p['12th_percentage'] ?>" class="form-control" required>
                                                <span class="text-white-50 f-14">Your 12th percentage</span>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="semper" value="<?php echo $p['Sem_percentage'] ?>" class="form-control" required>
                                                <span class="text-white-50 f-14">Upto your current semester percentage</span>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="cgpa" value="<?php echo $p['Sem_CGPA'] ?>" class="form-control" required>
                                                <span class="text-white-50 f-14">Upto your current semester CGPA</span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <div class="col">
                                                <input type="text" name="backlogs" value="<?php echo $p['Backlogs'] ?>" class="form-control" required>
                                                <span class="text-white-50 f-14">Any current backlogs:Enter Yes/No</span>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="numbacklog" value="<?php echo $p['No_of_backlogs'] ?>" class="form-control" required>
                                                <span class="text-white-50 f-14">Number of backlogs:Enter None if its zero</span>
                                            </div>
                                            <div class="col">
                                                <input type="text" name="hisbacklogs" class="form-control" value="<?php echo $p['History_of_backlogs'] ?>" required>
                                                <span class="text-white-50 f-14">Any History of backlogs:Enter Yes/No</span>
                                            </div>
                                        </div>
                                        <div class="row my-3">
                                            <textarea class="form-control" placeholder="Mention your skills" name="skills"><?php echo $p['Skills'] ?></textarea>
                                            <span class="text-white-50 f-14">Update your skills</span>
                                        </div>
                                        <div class="row my-3 w-50" style="display:block ;margin-left:auto;margin-right:auto;">
                                            <button type="submit" name="update" class="btn btn-success">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
        <?php
                    }
                }
            } else {
                $_SESSION['title'] = "Don't do this!";
                $_SESSION['status'] = "You cannot edit other's details";
                $_SESSION['status_code'] = "warning";
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

            const imgDiv = document.querySelector('.profile-pic-div');
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