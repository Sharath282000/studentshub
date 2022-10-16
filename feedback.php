<?php
require_once "config.php";
session_start();
if (isset($_POST['msgsubmit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $msg = $_POST['message'];
    if (!empty($name && $email && $msg)) {
        $ins = $conn->query("insert into feedbacks(Full_name,Email_id,Feedback ) values('$name','$email','$msg')");
        if ($ins) {
            $_SESSION['status'] = "We will catch you back later!";
            $_SESSION['status_code'] = "success";
            $_SESSION['title'] = "Thank you for your feedback!";
            header("Location:index.php");
            exit();
        } else {
            $_SESSION['status'] = "Your feedback cannot be inserted";
            $_SESSION['status_code'] = "error";
            $_SESSION['title'] = "Something went wrong!";
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
    <title>Students Hub - Feedback</title>
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-none">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.html">Students Hub</a>
        </div>
    </nav>
    <div class="container mt-4">
        <div class="row text-center">
            <div class="card shadow">
                <div class="card-title">
                    <h3 class="p-3">Feedback Form</h3>
                    <hr>
                </div>
                <div class="card-body">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                        <div class="row text-center justify-content-center my-4">
                            <input type="text" class="form-control w-100" name="name" placeholder="Full Name" required>
                        </div>
                        <div class="row text-center justify-content-center my-4">
                            <input type="text" class="form-control w-50" name="email" placeholder="Email ID" required>
                        </div>
                        <div class="row text-center justify-content-center my-4">
                            <textarea class="form-control w-50 messagetext" row="5" name="message" placeholder="Give Feedback" required></textarea>
                        </div>
                        <div class="row text-center justify-content-center my-4">
                            <button type="submit" name="msgsubmit" class="btn btn-primary w-50">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-white my-5 p-3 pt-5 d-flex mb-0">
        <div class="container">
            <div>
                <a href="index.html" class="btn text-muted mx-3">Login/Register</a>
                <a href="#" class="btn text-muted mx-3">About us</a>
                <a href="#" class="btn text-muted mx-3">Our Data Policy</a>
            </div>
            <hr>
            <div>
                <p class="text-muted mx-3">Students Hub &copy; 2022.</p>
            </div>
        </div>
    </footer>
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
