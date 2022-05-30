<?php
ob_start();
session_start();
require_once "config.php";
$email = $_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Portal</title>
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
    <?php
    if ($_SESSION['email']) {
    ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-none">
            <div class="container-fluid">
                <a class="navbar-brand" href="home.php">Students Hub</a>
            </div>
        </nav>
        <?php
        $sel = $conn->query("select * from students_register where not Email_id='$email' order by ID desc");
        if ($sel->num_rows > 0) {
        ?>
            <section id="profileportal" class="mt-5">
                <div class="row text-center">
                    <h3>Profile you're looking for</h3>
                </div>
                <div class="mt-3 mb-3 w-25" style="display:block;margin-left:auto;margin-right:auto;">
                    <input type="search" id="searchinput" autocomplete="off" class="form-control mb-4" placeholder="Search profile">
                </div>
                <div class="container mt-3">
                    <div class="row" id="showprofile">
                    </div>
                    <div class="row">
                        <?php while ($row = $sel->fetch_assoc()) {
                        ?>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-white p-2 shadow" style="border-radius: 20px;">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center p-2">
                                            <img src="profilepics/<?php echo $row['Profile_pic'] ?>" class="shadow me-2" style="width:75px;height:75px;object-fit:cover;border-radius:10px">
                                            <div class="mx-3">
                                                <p class="m-0 fw-bold"><?php echo $row['First_name'] ?> <?php echo $row['Last_name'] ?></p>
                                                <small class="text-muted"><?php echo $row['Year'] ?> <?php echo $row['Department'] ?> <?php echo $row['Class'] ?></small>
                                            </div>
                                        </div>
                                        <div class="row text-center mt-3">
                                            <a href="profile.php?account=<?php echo $row['Email_id'] ?>" class="btn btn-outline-success"><i class="fas fa-eye"></i> Look Profile</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </section>
        <?php
        } else {
        ?>
            <h6 class="mt-3">
                Sorry,There is no user other than you!
            </h6>
        <?php
        }
        ?>
    <?php
    } else {
        unset($_SESSION['email']);
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
    <script type="text/javascript">
        $(document).ready(function() {
            $('#searchinput').keyup(function() {
                var input = $(this).val();
                if (input != "") {
                    $.ajax({
                        url: "showprofile.php",
                        method: "POST",
                        data: {
                            input: input
                        },
                        success: function(data) {
                            $('#showprofile').html(data).show();
                        }
                    })
                } else {
                    $('#showprofile').css("display", "none");
                }
            });
        });
    </script>
</body>

</html>