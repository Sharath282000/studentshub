<?php
require_once "config.php";
session_start();
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $ans = $_POST['ans'];
    $ques = $_POST['ques'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    if (!empty($email && $ans && $pass)) {
        $selemail = $conn->query("select Email_id,Security_question,Answer from students_register where Email_id='$email'");
        if ($selemail->num_rows == 1) {
            $row = $selemail->fetch_assoc();
            if ($ans == $row['Answer'] && $ques == $row['Security_question']) {
                $update = $conn->query("update students_register set Password='$pass' where Email_id='$email'");
                if ($update) {
                    $_SESSION['status'] = "Your password is updated successfully, try to remember this one";
                    $_SESSION['title'] = "Updated Successfully!";
                    $_SESSION['status_code'] = "success";
                    header("Location:index.php");
                    exit();
                }
            } else {
                $_SESSION['status'] = "Your answer or question is incorrect";
                $_SESSION['title'] = "warning!";
                $_SESSION['status_code'] = "warning";
            }
        } 
        else {
            $_SESSION['status'] = "Email_ID not found";
            $_SESSION['title'] = "User not found";
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
    <title>Password Reset</title>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-none top-0 sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Students Hub</a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="card shadow" id="passwordreset">
                    <div class="card-header">
                        <div class="card-title text-center">
                            <h5 class="p-3">Your password reset</h5>
                            <hr>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                            <div class="row text-center justify-content-center my-4">
                                <input type="text" class="form-control w-50" name="email" placeholder="Email Id">
                            </div>
                            <div class="row text-center justify-content-center my-4">
                                <input type="text" class="form-control w-50" name="ques" placeholder="Enter your security question">
                                <small class="text-muted">Note: Its case sensitive</small>
                            </div>
                            <div class="row text-center justify-content-center my-4">
                                <input type="text" class="form-control w-50" name="ans" placeholder="Enter your answer">
                                <small class="text-muted">Note: Its case sensitive</small>
                            </div>
                            <div class="row text-center justify-content-center my-4">
                                <input type="password" class="form-control w-50" name="password" placeholder="Your new password">
                            </div>
                            <div class="row text-center justify-content-center">
                                <button type="submit" name="submit" class="btn btn-success w-50 my-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        <footer class="bg-white mt-5 pt-5 d-flex">
            <div class="container mt-4">
                <div class="mt-5 pt-5 mb-0">
                    <a href="index.html" class="btn text-muted mx-3">Login/Register</a>
                    <a href="#" class="btn text-muted mx-3">About us</a>
                    <a href="#" class="btn text-muted mx-3">Our Data Policy</a>
                    <a href="feedback.html" class="btn text-muted mx-3">Feedback</a>
                </div>
                <hr>
                <div>
                    <p class="text-muted mx-3">Students Hub &copy; 2022.</p>
                </div>
            </div>
        </footer>
    </div>
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