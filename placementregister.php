<?php
ob_start();
session_start();
require_once "config.php";
$email = $_SESSION['emailid'];
$s = $conn->query("select ID from students_register where Email_id='$email'");
if ($s->num_rows == 1) {
    $fetch = $s->fetch_assoc();
    $id = $fetch['ID'];
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $year = $_POST['year'];
    $dept = $_POST['dept'];
    $class = $_POST['class'];
    $bio = nl2br(mysqli_real_escape_string($conn, $_POST['bio']));
    //$emailid=$_POST['email'];
    $tenth = $_POST['tenthper'];
    $twelve = $_POST['twelvethper'];
    $semper = $_POST['semper'];
    $cgpa = $_POST['cgpa'];
    $backlog = $_POST['backlog'];
    $numback = $_POST['numback'];
    $his = $_POST['hisbacklog'];
    $skills = nl2br(mysqli_real_escape_string($conn,$_POST['skills']));
    if (!empty($bio && $tenth && $twelve && $semper && $cgpa && $backlog && $numback && $his && $skills)) {

        $ins = $conn->query("insert into placement_details values($id,'$name','$email','$year','$dept','$class','$bio','$tenth','$twelve','$semper','$cgpa','$backlog','$numback','$his','$skills')");
        if ($ins) {
            $_SESSION['status'] = "Your Data inserted successfully! Now login and can use this platform";
            $_SESSION['status_code'] = "success";
            $_SESSION['title'] = "Thank you for registering with us!";
            header("Location:index.php");
            exit();
        } else {
            $_SESSION['status'] = "Your Data not inserted successfully!";
            $_SESSION['status_code'] = "error";
            $_SESSION['title'] = "Something went wrong!";
        }
    } else {
        $_SESSION['status'] = "All the data are required";
        $_SESSION['status_code'] = "error";
        $_SESSION['title'] = "Your Data not inserted successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Register</title>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-none top-0 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Students Hub</a>
        </div>
    </nav>
    <section id="placementreg" class="mt-3">
        <?php
        $sel = $conn->query("select * from students_register where Email_id='$email'");
        if ($sel->num_rows == 1) {
            $row = $sel->fetch_assoc();
        ?>
            <h4 class="mt-3 mb-3 text-center">Welcome to Students Hub <?php echo $row['First_name']; ?> <?php echo $row['Last_name']; ?></h4>
            <div class="mt-5 bg-white p-5 shadow w-100 mb-5" style="border-radius: 15px;display:block;margin-left:auto;margin-right:auto;">
                <h6 class="text-center p-3">Placement Registration</h6>
                <hr>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <div class="row my-3">
                        <label for="name">Full Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $row['First_name']; ?> <?php echo $row['Last_name']; ?>" readonly>
                    </div>
                    <div class="row my-3">
                        <label for="email">Email ID</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $row['Email_id']; ?>" readonly>
                    </div>
                    <div class="row my-3">
                        <label for="year">Year</label>
                        <input type="text" class="form-control" name="year" value="<?php echo $row['Year']; ?>" readonly>
                    </div>
                    <div class="row my-3">
                        <label for="dept">Department</label>
                        <input type="text" class="form-control" name="dept" value="<?php echo $row['Department']; ?>" readonly>
                    </div>
                    <div class="row my-3">
                        <label for="class">Class</label>
                        <input type="text" class="form-control" name="class" value="<?php echo $row['Class']; ?>" readonly>
                    </div>
                    <div class="row my-3">
                        <label for="bio">About</label>
                        <textarea class="form-control" name="bio" id="about" placeholder="Enter about yourself" rows="3"></textarea>
                        <small class="text-muted">Note: Your bio describes yourself in short format.</small>
                    </div>
                    <div class="row my-3">
                        <label for="tenthper">10th Percentile</label>
                        <input type="text" class="form-control" name="tenthper" placeholder="Enter your 10th Percentage" autocomplete="off">
                        <small class="text-muted">Note: Your 10th Percentage should be correct and honest.</small>
                    </div>
                    <div class="row my-3">
                        <label for="tewelvethper">12th Percentile</label>
                        <input type="text" class="form-control" name="twelvethper" placeholder="Enter your 12th Percentage" autocomplete="off">
                        <small class="text-muted">Note: Your 12th Percentage should be correct and honest.</small>
                    </div>
                    <div class="row my-3">
                        <label for="semper">Upto Current Semester Percentage</label>
                        <input type="text" class="form-control" name="semper" placeholder="Enter your percentage upto current semester" autocomplete="off">
                        <small class="text-muted">Note: Your Percentage should be correct and honest.</small>
                    </div>
                    <div class="row my-3">
                        <label for="cgpa">Upto Current Semester CGPA</label>
                        <input type="text" class="form-control" name="cgpa" placeholder="Enter your CGPA upto current semester" autocomplete="off">
                        <small class="text-muted">Note: Your CGPA should be correct and honest.</small>
                    </div>
                    <div class="row my-3">
                        <label class="my-2">Do you have any current backlogs?</label>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <label class="form-check-label">Yes</label>
                                <input type="radio" name="backlog" value="Yes" class="form-check-input">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <label class="form-check-label">No</label>
                                <input type="radio" name="backlog" value="No" class="form-check-input">
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <label for="numback">Number of backlogs</label>
                        <input type="text" class="form-control" placeholder="Enter no.of backlogs" name="numback" autocomplete="off">
                        <small class="text-muted">Note: If no backlogs enter None</small>
                    </div>
                    <div class="row my-3">
                        <label class="my-2">Do you have any history of backlogs?</label>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <label class="form-check-label">Yes</label>
                                <input type="radio" name="hisbacklog" value="Yes" class="form-check-input">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <label class="form-check-label">No</label>
                                <input type="radio" name="hisbacklog" value="No" class="form-check-input">
                            </div>
                        </div>
                    </div>
                    <div class="row my-3">
                        <label for="skills">Mention your skills</label>
                        <textarea class="form-control" placeholder="Mention your skills" name="skills"></textarea>
                        <small class="text-muted">Note: Type what you're well versed of</small>
                    </div>
                    <div class="row my-3 text-center">
                        <button type="submit" class="btn btn-success" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        <?php
        } else {
            header("Location:index.php");
            ob_end_flush();
            exit();
        }
        ?>
    </section>
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
        $('#about').emojioneArea({
            pickerPostion: 'right'
        });
    </script>
</body>

</html>
