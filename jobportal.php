<?php
session_start();
ob_start();
require_once "config.php";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Portal</title>
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
    <?php if ($_SESSION['email']) {
    ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-none top-0 sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">Students Hub</a>
            </div>
        </nav>
        <section id="jobs" class="mt-5">
            <?php
            if (isset($_GET['account'])) {
                $acc = $_GET['account'];
                if ($acc == $row['Email_id']) {
                    $placsel = $conn->query("select * from placement_details where Email_id='$acc'");
                    if ($placsel->num_rows == 1) {
                        $p = $placsel->fetch_assoc();
            ?>
                        <div class="row text-center">
                            <h3>Jobs you're looking for</h3>
                        </div>
                        <div class="container mt-4 mb-5">
                            <div class="row mb-3">
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
                                                        <div class="col-lg-3 col-md-6 mb-2">
                                                            <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                <div class="jobcontent">
                                                                    <p>Hiring all departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                    </p>
                                                                </div>
                                                                <div class="mt-3 row text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                </div>
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
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all UG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all PG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                        <div class="col-lg-3 col-md-6">
                                                            <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                <div class="jobcontent">
                                                                    <p>Hiring all departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                    </p>
                                                                </div>
                                                                <div class="mt-3 row text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                            <div class="col-lg-3 col-md-6">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all UG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all UG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all UG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all UG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                                <div class="bg-white shadow p-2 rounded-2 mb-2">
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
                                                } else if ($job['Department'] == 'All PG' && $job['Percentage'] <= $p['Sem_percentage'] && $job['Backlogs'] == 'Yes' &&  $job['His_of_backlog'] == 'Yes') {
                                                    if ($currentdate < $newdate || $currentdate == $newdate) {
                                                        if (str_starts_with($p['Department'], 'M')) {
                                                            $olddate = $job['Last_date'];
                                                            $stamp = strtotime($olddate);
                                                            $newdate = date("d-m-Y", $stamp);
                                                            ?>
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all PG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all PG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all PG departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br>Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                                <div class="col-lg-3 col-md-6 mb-2">
                                                                    <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                        <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                        <div class="jobcontent">
                                                                            <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                            </p>
                                                                        </div>
                                                                        <div class="mt-3 row text-center">
                                                                            <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                        </div>
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
                                                        <div class="col-lg-3 col-md-6 mb-2">
                                                            <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                <div class="jobcontent">
                                                                    <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                    </p>
                                                                </div>
                                                                <div class="mt-3 row text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                </div>
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
                                                        <div class="col-lg-3 col-md-6 mb-2">
                                                            <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                <div class="jobcontent">
                                                                    <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                    </p>
                                                                </div>
                                                                <div class="mt-3 row text-center">
                                                                    <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                            <div class="col-lg-3col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                                                            <div class="col-lg-3 col-md-6 mb-2">
                                                                <div class="shadow p-5 h-100" style="border-radius:25px">
                                                                    <h5 class="mb-2 fw-bolder f-17"><?php echo $job['Company_name'] ?></h5>
                                                                    <div class="jobcontent">
                                                                        <p>Hiring all <?php echo $job['Department'] ?> departments for <b><?php echo $job['Role'] ?></b> with the Salary package of <b><?php echo $job['Salary'] ?></b> LPA and <?php echo $job['Bondage'] ?> to the Bondage with the working location: <?php echo $job['Work_location'] ?>.<br> Last Date to apply is <b><?php echo $newdate ?></b>
                                                                        </p>
                                                                    </div>
                                                                    <div class="mt-3 row text-center">
                                                                        <a href="studentdetails.php?account=<?php echo $email ?>&&jobid=<?php echo $job['Job_id'] ?>" class="btn btn-outline-primary">Apply now <i class="px-3 fas fa-arrow-right"></i></a>
                                                                    </div>
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
                            </div>
                        </div>
            <?php }
                } else {
                    if ($_SESSION['email']) {
                        $_SESSION['title'] = "Dont do this!";
                        $_SESSION['status'] = "You cannot enter other's job portal!";
                        $_SESSION['status_code'] = "warning";
                        header("Location:home.php");
                        ob_end_flush();
                        exit();
                    } else {
                        $_SESSION['title'] = "Dont do this!";
                        $_SESSION['status'] = "You cannot enter this portal!";
                        $_SESSION['status_code'] = "warning";
                        header("Location:index.php");
                        ob_end_flush();
                        exit();
                    }
                }
            } ?>
        </section>
    <?php
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
