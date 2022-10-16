<?php
session_start();
ob_start();
require_once "config.php";
if (isset($_GET['account'], $_GET['jobid'])) {
    $jobsid = $_GET['jobid'];
    $account = $_GET['account'];
    $_SESSION['jobsid']=$jobsid;
    $_SESSION['em']=$account;
}
$i=$_SESSION['jobsid'];
$e=$_SESSION['em'];
$seljobs = $conn->query("select Apply_link from job_details where Job_id=$i");
$jobs = $seljobs->fetch_assoc();
$email = $_SESSION['email'];
if (isset($_POST['submit'])) {
    $jobid = $_POST['jobid'];
    $cmp_name = $_POST['cmpname'];
    $role = $_POST['role'];
    $fullname = $_POST['name'];
    $email = $_POST['email'];
    $year = $_POST['year'];
    $dept = $_POST['dept'];
    $class = $_POST['class'];
    $tenper = $_POST['tenthper'];
    $twelper = $_POST['twelvethper'];
    $sem = $_POST['semper'];
    $cgpa = $_POST['cgpa'];
    $backlog = $_POST['backlogs'];
    $his = $_POST['his'];
    if (!empty($jobid && $cmp_name && $role && $fullname && $email && $year && $dept && $class && $tenper && $twelper && $sem && $cgpa && $backlog && $his)) {
        $selins = $conn->query("select * from student_details where Job_id=$i and Email_id='$e'");
        if ($selins->num_rows == 0) {
            $ins = $conn->query("insert into student_details(Job_id,Company_name,Role,Full_name,Email_id,Year,Department,Class,Tenth_percentage,Twelve_percentage,Sem_percentage,Cgpa,Backlogs,History_of_backlogs)values($jobid,'$cmp_name','$role','$fullname','$email','$year','$dept','$class','$tenper','$twelper','$sem','$cgpa','$backlog','$his')");
            if ($ins) {
                $url = $jobs['Apply_link'];
                header("Location:$url");
                ob_end_flush();
                exit();
            } else {
                $_SESSION['title'] = "Data not inserted";
                $_SESSION['status'] = "Something went wrong!";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['title'] = "You already applied to this job";
            $_SESSION['status'] = "Try to apply some other jobs";
            $_SESSION['status_code'] = "error";
            header("Location:home.php");
            ob_end_flush();
            exit();
        }
    } else {
        $_SESSION['title'] = "Data not inserted";
        $_SESSION['status'] = "All data required!";
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
    <title>Student Details</title>
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
    <?php if ($_SESSION['email']) { ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-none top-0 sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Students Hub</a>
            </div>
        </nav>
        <secion id="studentdetails">
            <?php
            if (isset($_GET['account'], $_GET['jobid'])) {
                $acc = $_GET['account'];
                $id = $_GET['jobid'];
                $res = $conn->query("select * from students_register where Email_id='$acc'");
                $row = $res->fetch_assoc();
                $placsel = $conn->query("select * from placement_details where Email_id='$acc'");
                $p = $placsel->fetch_assoc();
                $jobsel = $conn->query("select * from job_details where Job_id=$id");
                $job = $jobsel->fetch_assoc();
                $jobid = $job['Job_id'];
                if ($acc == $email && $jobid == $id) {
            ?>
                    <div class="mt-5 bg-white p-5 shadow w-100 mb-5" style="border-radius: 15px;display:block;margin-left:auto;margin-right:auto;">
                        <h6 class="text-center p-3">Job Registration</h6>
                        <p class="text-center text-muted mb-2">Check your details are correct</p>
                        <hr>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                            <div class="row my-3">
                                <label for="jobid">Job ID</label>
                                <input type="text" name="jobid" value="<?php echo $job['Job_id'] ?>" class="form-control" readonly>
                            </div>
                            <div class="row my-3">
                                <label for="cmpname">Company name</label>
                                <input type="text" name="cmpname" value="<?php echo $job['Company_name'] ?>" class="form-control" readonly>
                            </div>
                            <div class="row my-3">
                                <label for="role">Role</label>
                                <input type="text" name="role" value="<?php echo $job['Role'] ?>" class="form-control" readonly>
                            </div>
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
                                <label for="tenthper">10th Percentile</label>
                                <input type="text" class="form-control" name="tenthper" placeholder="Enter your 10th Percentage" value="<?php echo $p['10th_percentage'] ?>" readonly autocomplete="off">
                            </div>
                            <div class="row my-3">
                                <label for="tewelvethper">12th Percentile</label>
                                <input type="text" class="form-control" name="twelvethper" placeholder="Enter your 12th Percentage" value="<?php echo $p['12th_percentage'] ?>" readonly autocomplete="off">

                            </div>
                            <div class="row my-3">
                                <label for="semper">Upto Current Semester Percentage</label>
                                <input type="text" class="form-control" name="semper" placeholder="Enter your percentage upto current semester" value="<?php echo $p['Sem_percentage'] ?>" readonly autocomplete="off">

                            </div>
                            <div class="row my-3">
                                <label for="cgpa">Upto Current Semester CGPA</label>
                                <input type="text" class="form-control" name="cgpa" placeholder="Enter your CGPA upto current semester" value="<?php echo $p['Sem_CGPA'] ?>" readonly autocomplete="off">

                            </div>
                            <div class="row my-3">
                                <label class="my-2">Any current backlogs?</label>
                                <input type="text" class="form-control" name="backlogs" value="<?php echo $p['Backlogs'] ?>" readonly>
                            </div>
                            <div class="row my-3">
                                <label class="my-2">Any history of backlogs?</label>
                                <input type="text" class="form-control" name="his" value="<?php echo $p['History_of_backlogs'] ?>" readonly>
                            </div>
                            <div class="row my-3 text-center">
                                <button type="submit" class="btn btn-success" name="submit">Apply</button>
                            </div>
                        </form>
                    </div>
            <?php } else {
                    $_SESSION['title'] = "Don't do this!";
                    $_SESSION['status'] = "You cannot enter other's portal";
                    $_SESSION['status_code'] = "warning";
                }
            } else {
                $_SESSION['title'] = "Don't do this!";
                $_SESSION['status'] = "You cannot enter other's portal";
                $_SESSION['status_code'] = "warning";
            }
            ?>
            </section>
        <?php } else {
        session_unset();
        header("Location:index.php");
        ob_end_flush();
        exit();
    } ?>
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
