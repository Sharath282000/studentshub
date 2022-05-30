<!------Including php configure file----->
<?php
session_start();
ob_start();
require_once "config.php";
$email = $_SESSION['placement'];
#getting data through post method and updating the data the respective table
if (isset($_POST['update'])) {
    $jid = $_POST['id'];
    $cmpname = $_POST['cmpname'];
    $role = $_POST['role'];
    $salary = $_POST['salary'];
    $loc = $_POST['wrkloc'];
    $bondage = $_POST['bondage'];
    $backlog = $_POST['backlog'];
    $hisbacklog = $_POST['hisbacklog'];
    $semper = $_POST['semper'];
    $lastdate = $_POST['lastdate'];
    $link = $_POST['link'];
    $dept = $_POST['dept'];
    if (!empty($cmpname && $role && $salary && $loc && $bondage && $backlog && $hisbacklog && $semper && $lastdate && $link && $dept)) {
        $update = $conn->query("update job_details set Company_name='$cmpname',Role='$role',Salary='$salary',Work_location='$loc',Bondage='$bondage',Backlogs='$backlog',His_of_backlog='$hisbacklog',Percentage='$semper',Last_date='$lastdate',Apply_link='$link',Department='$dept' where Job_id=$jid");
        if ($update) {
            $st = $conn->query("select * from student_details where Job_id=$jid");
            if ($st->num_rows > 0) {
                $s = $st->fetch_assoc();
                $update2 = $conn->query("update student_details set Company_name='$cmpname',Role='$role' where Job_id=$jid");
                if ($update2) {
                    $_SESSION['title'] = "Success";
                    $_SESSION['status'] = "Job Details has been updated successfully";
                    $_SESSION['status_code'] = "success";
                    header("Location:placementcell.php");
                    ob_end_flush();
                    exit();
                }
            } else {
                $_SESSION['title'] = "Success";
                $_SESSION['status'] = "Job Details has been updated successfully";
                $_SESSION['status_code'] = "success";
                header("Location:placementcell.php");
                ob_end_flush();
                exit();
            }
        }
    } else {
        $_SESSION['status'] = "All the data is needed!";
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
    <title>Edit - Job</title>
    <!-----Bootstrap----->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fa_all.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/emojionearea.min.css">
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-none top-0 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="placementcell.php">Students Hub</a>
        </div>
    </nav>
    <!-----Getting jobs details by getting job id through get method and allowing user to edit----->
    <?php
    if ($_SESSION['placement']) {
        if (isset($_GET['jobid'])) {
            $id = $_GET['jobid'];
            if ($_SESSION['placement'] == $email) {
                $sel = $conn->query("select * from job_details where Job_id=$id");
                if ($sel->num_rows == 1) {
                    $row = $sel->fetch_assoc();
    ?>
                    <section id="editjob">
                        <div class="mt-5 mb-5 shadow p-5 w-50 text-white" style="display:block;margin-left:auto;margin-right:auto;border-radius:25px;background-color: #485461;background-image: linear-gradient(315deg, #485461 0%, #28313b 74%);">
                            <h5>Edit Job <i class="fa-solid fa-gear"></i></h5>
                            <hr>
                            <div class="row">
                                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                    <input type="hidden" value="<?php echo $row['Job_id'] ?>" name="id">
                                    <div class="row my-3">
                                        <label for="cmpname" class="text-white">Company name</label>
                                        <input type="text" name="cmpname" class="form-control" value="<?php echo $row['Company_name'] ?>">
                                    </div>
                                    <div class="row my-3">
                                        <label for="role" class="text-white">Role/Position</label>
                                        <input type="text" name="role" class="form-control" value="<?php echo $row['Role'] ?>">
                                    </div>
                                    <div class="row my-3">
                                        <label for="salary" class="text-white">Salary</label>
                                        <input type="text" name="salary" class="form-control" value="<?php echo $row['Salary'] ?>">
                                    </div>
                                    <div class="row my-3">
                                        <label for="dept" class="text-white">
                                            Eligible Departments
                                        </label>
                                        <input type="text" class="form-control" name="dept" value="<?php echo $row['Department'] ?>">
                                        <span class="text-white-50 f-14">Enter departments seperated with comma eg:BCA,BBA</span>
                                    </div>
                                    <div class="row my-3">
                                        <label for="wrkloc" class="text-white">Work Location</label>
                                        <input type="text" name="wrkloc" class="form-control" value="<?php echo $row['Work_location'] ?>">
                                        <span class="text-white-50 f-14">Give as not mentioned if location not given for the job</span>
                                    </div>
                                    <div class="row my-3">
                                        <label for="bondage" class="text-white">Any bondage</label>
                                        <input type="text" name="bondage" class="form-control" value="<?php echo $row['Bondage'] ?>">
                                        <span class="text-white-50 f-14">Enter Yes/No</span>
                                    </div>
                                    <div class="row my-3">
                                        <label for="backlog" class="text-white">Backlogs students allowed?</label>
                                        <input type="text" name="backlog" class="form-control" value="<?php echo $row['Backlogs'] ?>">
                                        <span class="text-white-50 f-14">Enter Yes/No</span>
                                    </div>
                                    <div class="row my-3">
                                        <label for="hisbacklog" class="text-white">Having history of backlogs students allowed?</label>
                                        <input type="text" name="hisbacklog" class="form-control" value="<?php echo $row['His_of_backlog'] ?>">
                                        <span class="text-white-50 f-14">Enter Yes/No</span>
                                    </div>
                                    <div class="row my-3">
                                        <label for="semper" class="text-white">Any Percentage criteria?</label>
                                        <input type="text" name="semper" class="form-control" value="<?php echo $row['Percentage'] ?>">
                                        <span class="text-white-50 f-14">Enter the percentage value that should be passed by students</span>
                                    </div>
                                    <div class="row my-3">
                                        <label for="lastdate" class="text-white">Last Date</label>
                                        <input type="text" name="lastdate" class="form-control" value="<?php echo $row['Last_date'] ?>">
                                    </div>
                                    <div class="row my-3">
                                        <label for="link" class="text-white">Apply link</label>
                                        <input type="text" name="link" class="form-control" value="<?php echo $row['Apply_link'] ?>">
                                        <span class="text-white-50 f-14">url should be https://example.com</span>
                                    </div>
                                    <div class="row my-3 w-50" style="display:block;margin-left:auto;margin-right:auto">
                                        <button type="submit" name="update" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
    <?php
                }
            } else {
                $_SESSION['title'] = "Don't do this!";
                $_SESSION['status'] = "You cannot edit other's post";
                $_SESSION['status_code'] = "warning";
            }
        }
    } else {
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