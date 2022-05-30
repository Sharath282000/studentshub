<?php
session_start();
ob_start();
require_once "config.php";
$email = $_SESSION['placement'];
if (isset($_POST['submit'])) {
    $cmp = mysqli_real_escape_string($conn, $_POST['cmpname']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $salary = $_POST['salary'];
    $backlog = $_POST['backlog'];
    $hisbacklog = $_POST['backloghis'];
    $percentage = $_POST['percentage'];
    $lastdate = $_POST['lastdate'];
    $wrkloc = $_POST['workloc'];
    $link = $_POST['link'];
    $dept = $_POST['dept'];
    $str = implode(",", $dept);
    $bond = $_POST['bond'];
    if (!empty($cmp && $role && $dept && $link)) {
        $ins = $conn->query("insert into job_details(Company_name,Role,Work_location,Salary,Department,Backlogs,His_of_backlog,Percentage,Last_date,Apply_link,Bondage)values('$cmp','$role','$wrkloc','$salary','$str','$backlog','$hisbacklog','$percentage','$lastdate','$link','$bond')");
        if ($ins) {
            $_SESSION['title'] = "Success";
            $_SESSION['status'] = "Job details have been stored successfully";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['title'] = "Data not inserted";
            $_SESSION['status'] = "Something went wrong!";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['title'] = "Give required data";
        $_SESSION['status'] = "Company name, eligible department,Job description,Apply_link is needed";
        $_SESSION['status_code'] = "error";
    }
}
if (isset($_POST['logout'])) {
    unset($_SESSION['placement']);
    $_SESSION['status'] = "You were successfully logged out!";
    $_SESSION['title'] = "Thank you for using Students Hub! Welcome again!";
    $_SESSION['status_code'] = "success";
    header("Location:index.php");
    ob_end_flush();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Placement Cell - Portal</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/fa_all.min.css">
    <link rel="stylesheet" href="css/aos.css">
    <link rel="stylesheet" href="fonts/fonts.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/all.min.css">
    <style>
        <?php
        include "css/style.css";
        ?>
    </style>
</head>

<body>
    <?php if ($_SESSION['placement']) {
        if ($_SESSION['placement'] == 'placementcell@mcc.edu.in') { ?>
            <nav class="navbar navbar-expand-lg navbar-dark bg-none top-0 sticky-top">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">Students Hub</a>
                </div>
                <div>
                    <ul class="navbar-nav mx-auto px-3">
                        <li class="nav-item px-2">
                            <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" class="dropdown-item mt-2">
                                <button type="submit" name="logout" class="btn text-white d-flex" id="logoutp">
                                    <i class="fa-solid fa-right-from-bracket me-2" style="margin-left: -10px;"></i>
                                    <h6>Log Out</h6>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            <section id="placementcell">
                <div class="mt-3 text-center w-50 mb-5" style="display:block;margin-left:auto;margin-right:auto;">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Add Jobs
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data">
                                        <div class="row mb-3">
                                            <textarea class="form-control border-2" rows="4" name="cmpname" placeholder="Give the company name here"></textarea>
                                        </div>
                                        <div class="row mb-3">
                                            <textarea class="form-control border-2" rows="4" name="role" placeholder="Give the described role"></textarea>
                                        </div>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" name="salary" placeholder="Give the salary package">
                                            <span class="input-group-text">Lakhs per annum</span>
                                        </div>
                                        <div class="row mb-3">
                                            <input type="text" class="form-control" name="workloc" placeholder="Give work location">
                                            <span class="text-start fw-bold f-14">Give as not mentioned if location not given for the job</span>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="dept" class="form-label fw-bold">Choose Eligible Department</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="all" value="All">
                                            <label class="form-check-label" for="inlineCheckbox1">All</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="allug" value="All UG">
                                            <label class="form-check-label" for="inlineCheckbox1">All UG</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="allpg" value="All PG">
                                            <label class="form-check-label" for="inlineCheckbox1">All PG</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="BCA">
                                            <label class="form-check-label" for="inlineCheckbox1">BCA</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="MCA">
                                            <label class="form-check-label" for="inlineCheckbox1">MCA</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.Sc Mathemetics">
                                            <label class="form-check-label" for="inlineCheckbox1">B.Sc Mathemetics</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.Sc Mathemetics">
                                            <label class="form-check-label" for="inlineCheckbox1">M.Sc Mathemetics</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.Sc Physics">
                                            <label class="form-check-label" for="inlineCheckbox1">B.Sc Physics</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.Sc Physics">
                                            <label class="form-check-label" for="inlineCheckbox1">M.Sc Physics</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.Sc Chemistry">
                                            <label class="form-check-label" for="inlineCheckbox1">B.Sc Chemistry</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.Sc Chemistry">
                                            <label class="form-check-label" for="inlineCheckbox1">M.Sc Chemistry</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.Sc Botony">
                                            <label class="form-check-label" for="inlineCheckbox1">B.Sc Botony</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.Sc Botony">
                                            <label class="form-check-label" for="inlineCheckbox1">M.Sc Botony</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.Sc Zoology">
                                            <label class="form-check-label" for="inlineCheckbox1">B.Sc Zoology</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.Sc Zoology">
                                            <label class="form-check-label" for="inlineCheckbox1">M.Sc Zoology</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.Sc Visual Communication">
                                            <label class="form-check-label" for="inlineCheckbox1">B.Sc Visual Communication</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.A Communication">
                                            <label class="form-check-label" for="inlineCheckbox1">M.A Communication</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.Sc Microbiology">
                                            <label class="form-check-label" for="inlineCheckbox1">B.Sc Microbiology</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.Sc Microbiology">
                                            <label class="form-check-label" for="inlineCheckbox1">M.Sc Microbiology</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.S.W">
                                            <label class="form-check-label" for="inlineCheckbox1">B.S.W</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.S.W">
                                            <label class="form-check-label" for="inlineCheckbox1">M.S.W</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="BA History">
                                            <label class="form-check-label" for="inlineCheckbox1">BA History</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="MA History">
                                            <label class="form-check-label" for="inlineCheckbox1">MA History</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.Sc Geography">
                                            <label class="form-check-label" for="inlineCheckbox1">B.Sc Geography</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="BA Tamil">
                                            <label class="form-check-label" for="inlineCheckbox1">BA Tamil</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="MA Tamil">
                                            <label class="form-check-label" for="inlineCheckbox1">MA Tamil</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="BA English">
                                            <label class="form-check-label" for="inlineCheckbox1">BA English</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="MA English">
                                            <label class="form-check-label" for="inlineCheckbox1">MA English</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="B.com">
                                            <label class="form-check-label" for="inlineCheckbox1">B.com</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="M.com">
                                            <label class="form-check-label" for="inlineCheckbox1">M.com</label>
                                        </div>
                                        <div class="form-check form-check-inline mb-3">
                                            <input class="form-check-input" type="checkbox" name="dept[]" id="inlineCheckbox1" value="BBA">
                                            <label class="form-check-label" for="inlineCheckbox1">BBA</label>
                                        </div>
                                        <div class="row text-start mb-3 mt-3">
                                            <label for="backlog" class="fw-bold mb-3">Any bondage?</label>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <div class="border rounded p-2">
                                                        <label class="form-check-label">Yes</label>
                                                        <input type="radio" name="bond" value="Yes" class="form-check-input">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-2">
                                                        <label class="form-check-label">No</label>
                                                        <input type="radio" name="bond" value="No" class="form-check-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-start mb-3 mt-3">
                                            <label for="backlog" class="fw-bold mb-3">Does backlogs students can apply?</label>
                                            <div class="row mb-3">
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
                                        </div>
                                        <div class="row text-start mb-3 mt-3">
                                            <label for="backlog" class="fw-bold mb-3">Is students having backlogs history can apply?</label>
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <div class="border rounded p-2">
                                                        <label class="form-check-label">Yes</label>
                                                        <input type="radio" name="backloghis" value="Yes" class="form-check-input">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="border rounded p-2">
                                                        <label class="form-check-label">No</label>
                                                        <input type="radio" name="backloghis" value="No" class="form-check-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row text-start mb-3">
                                            <label for="semper" class="fw-bold">Percentage allowed</label>
                                            <div class="row mb-3">
                                                <div class="col-3">
                                                    <div class="border rounded p-2">
                                                        <label class="form-check-label">None</label>
                                                        <input type="radio" name="percentage" value="None" class="form-check-input">
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="border rounded p-2">
                                                        <label class="form-check-label">>60</label>
                                                        <input type="radio" name="percentage" value="60" class="form-check-input">
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="border rounded p-2">
                                                        <label class="form-check-label">>70</label>
                                                        <input type="radio" name="percentage" value="70" class="form-check-input">
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="border rounded p-2">
                                                        <label class="form-check-label">>80</label>
                                                        <input type="radio" name="percentage" value="80" class="form-check-input">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="lastdate" class="text-start fw-bold mb-3">Choose last date for registration</label>
                                            <input type="date" class="form-control" name="lastdate" placeholder="Choose last date for registration">
                                        </div>
                                        <div class="row mb-3">
                                            <label for="link" class="text-start fw-bold mb-3">Apply link</label>
                                            <input type="url" name="link" class="form-control" placeholder="https://example.com">
                                        </div>
                                        <div class="row mt-3 mb-3 w-50" style="display:block;margin-left:auto;margin-right:auto">
                                            <button type="submit" class="btn btn-success" name="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <h5 class="mt-2 text-center mb-4">Jobs posted</h5>
                        <div class="container">
                            <div class="row text-start">
                                <?php
                                $jobsel = $conn->query("select * from job_details order by Job_id desc");
                                if ($jobsel->num_rows > 0) {
                                    while ($job = $jobsel->fetch_assoc()) {
                                ?>
                                        <div class="col-lg-6 mb-2">
                                            <div class="shadow p-5 h-100" style="border-radius:25px">
                                                <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                <div class="jobcontent">
                                                    <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br>Last Date to apply is <b><?php echo $job['Last_date'] ?></b><br>Apply Link: <a href="<?php echo $job['Apply_link'] ?>"><?php echo $job['Apply_link'] ?></a>
                                                    </p>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a href="editjob.php?jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Edit details</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a href="deletejob.php?jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-danger">Delete job</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <h6 class="text-center">
                                        No jobs been posted!
                                    </h6>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
            </section>
            <script src="js/jquery-3.6.0.js"></script>
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
        } else {
            unset($_SESSION['placement']);
            $_SESSION['title'] = "Dont do this!";
            $_SESSION['status'] = "You cannot enter this portal";
            $_SESSION['status_code'] = "warning";
        }
    } else {
        unset($_SESSION['placement']);
        header("Location:index.php");
        ob_end_flush();
        exit();
    }
    ?>
</body>

</html>