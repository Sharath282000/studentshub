<?php
session_start();
require_once "config.php";

if (isset($_POST['registerbtn'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['pass'], PASSWORD_DEFAULT);
    $rand = mt_rand(1, 99999999);
    $profilepicname = $_FILES['profilepic']['name'];
    $year = $_POST['year'];
    $class = $_POST['class'];
    $dept = $_POST['dept'];
    $gender = $_POST['Gender'];
    $age = $_POST['age'];
    $ques = $_POST['question'];
    $ans = $_POST['ans'];
    $from = $_POST['from'];
    $lives = $_POST['lives'];
    if (!empty($fname && $lname && $email && $password && $profilepicname && $year && $class && $dept && $gender && $age && $ques && $ans && $from && $lives)) {
        $profilepictype = pathinfo($profilepicname, PATHINFO_EXTENSION);
        $allow = array('jpg', 'jpeg', 'png');
        if (in_array($profilepictype, $allow)) {
            $profilepic = $_FILES['profilepic']['tmp_name'];
            $picname = $rand . "." . $profilepictype;
            $selectemail = $conn->query("select * from students_register where Email_id='$email'");
            if (!$selectemail->num_rows == 1) {
                if (ctype_alpha($fname) && ctype_alpha($lname)) {
                    if (strpos($email, 'mcc')) {
                        $ins = $conn->query("insert into students_register(First_name,Last_name,Profile_pic,Email_id,Password,Security_question,Answer,Year,Department,Class,Gender,Age,From_address,Lives_in)values(
                            '$fname','$lname','$picname','$email','$password','$ques','$ans','$year','$dept','$class','$gender',$age,'$from','$lives')");
                        if ($ins) {
                            move_uploaded_file($profilepic, "profilepics/" . $picname);
                            $_SESSION['emailid'] = $email;
                            $_SESSION['status'] = "Your Data inserted successfully! Now register for your placement";
                            $_SESSION['status_code'] = "success";
                            $_SESSION['title'] = "Thank you for registering with us!";
                            header("Location:placementregister.php");
                            exit();
                        } else {
                            $_SESSION['status'] = "Something went wrong";
                            $_SESSION['status_code'] = "error";
                            $_SESSION['title'] = "Data insertion failed";
                        }
                    } else {
                        $_SESSION['status'] = "Only your college Email-id is allowed to register";
                        $_SESSION['title'] = "Data insertion failed!";
                        $_SESSION['status_code'] = "error";
                    }
                } else {
                    $_SESSION['status'] = "Only letters allowed in name";
                    $_SESSION['title'] = "Data insertion failed!";
                    $_SESSION['status_code'] = "error";
                }
            } else {
                $_SESSION['status'] = "This Email-id already exist";
                $_SESSION['status_code'] = "error";
                $_SESSION['title'] = "Data insertion failed";
            }
        } else {
            $_SESSION['status'] = "Only PNG,JPG,JPEG format for profile pic is allowed";
            $_SESSION['status_code'] = "error";
            $_SESSION['title'] = "Data insertion failed";
        }
    } else {
        $_SESSION['status'] = "All data is required to register";
        $_SESSION['title'] = "Data insertion failed!";
        $_SESSION['status_code'] = "error";
    }
}

if (isset($_POST['loginbtn'])) {
    $em = $_POST['emailid'];
    $pas = $_POST['password'];
    if (!empty($em && $pas)) {
        if ($em == 'placementcell@mcc.edu.in' && $pas == 'placementcell') {
            $_SESSION['placement']=$em;
            $_SESSION['status'] = "Login is successful";
            $_SESSION['status_code'] = "success";
            $_SESSION['title'] = "Welcome Placement Cell to Students Hub";
            header("Location:placementcell.php");
            exit();
        } else if ($em == 'admin.studentshub@mcc.edu.in' && $pas == 'admin123') {
            $_SESSION['status'] = "Login is successful";
            $_SESSION['status_code'] = "success";
            $_SESSION['title'] = "Welcome Admin to Students Hub";
            header("Location:adminportal.php");
            exit();
        } else {
            $select = $conn->query("select First_name,Email_id,Password from students_register where Email_id='$em'");
            if ($select->num_rows == 1) {
                $row = $select->fetch_assoc();
                if (password_verify($pas, $row['Password'])) {
                    $_SESSION['email'] = $em;
                    $_SESSION['status'] = "Login is successful";
                    $_SESSION['status_code'] = "success";
                    $_SESSION['title'] = "Welcome to Students Hub";
                    header("Location:home.php");
                    exit();
                } else {
                    $_SESSION['status'] = "Check your password is correct";
                    $_SESSION['status_code'] = "error";
                    $_SESSION['title'] = "No user found";
                }
            } else {
                $_SESSION['status'] = "Check your email-id or register with us";
                $_SESSION['status_code'] = "error";
                $_SESSION['title'] = "No user found";
            }
        }
    } else {
        $_SESSION['status'] = "Input all necessary Data";
        $_SESSION['status_code'] = "error";
        $_SESSION['title'] = "All data is required";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome to Students Hub</title>
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

<body id="index">
    <div class="container row-lg mt-5 pt-5">
        <div class="d-flex flex-column flex-lg-row justify-content-evenly mt-5 pt-5">
            <div class="text-lg-start">
                <h1 class="primary">Students Hub</h1>
                <p class="f-15 mt-3" id="tit">Students Hub helps you to connect students of your
                    college.</p>
                <div>
                    <img src="Images/4575.jpg" class="img-fluid" style="width:500px">
                </div>
            </div>
            <div class="bg-white shadow rounded p-3 input-group-lg reg h-100">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" enctype="multipart/form-data">
                    <input type="email" class="form-control my-3" name="emailid" placeholder="Your email-id">
                    <input type="password" class="form-control my-3" name="password" placeholder="Password">
                    <button type="submit" class="btn btn-primary primary-bg w-100 my-3" name="loginbtn" id="login">Log in</button>
                </form>
                <div class="d-flex">
                    <a href="./passwordreset.php" class="text-decoration-none my-3">Forgot password?</a>
                </div>
                <hr>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary my-3 f-14" data-bs-toggle="modal" data-bs-target="#modalcontent">Create
                        account</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="modalcontent">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div>
                        <h3>Sign up</h3>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                        <div class="profile-pic-div">
                            <img src="Images/shadow-profile.png" id="photo">
                            <input type="file" id="file" name="profilepic" required>
                            <label for="file" id="uploadBtn">Choose Photo</label>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <input type="text" name="fname" placeholder="First Name" class="form-control" required>
                            </div>
                            <div class="col">
                                <input type="text" name="lname" placeholder="Last Name" class="form-control" required>
                            </div>
                        </div>
                        <input type="email" class="form-control my-1" name="email" placeholder="Email-id" required>
                        <small class="text-muted my-3 f-13">Note: Only your college email id is allowed</small>
                        <input type="password" name="pass" class="form-control my-3" placeholder="Password" required>
                        <div class="row-my-3">
                            <textarea name="question" class="form-control" placeholder="Enter your security question" rows="3" required></textarea>
                            <small class="text-muted">Note: Any One question is required and its needed to be remembered one.</small>
                        </div>
                        <div class="row my-3">
                            <input type="text" class="form-control" name="ans" placeholder="Type the answer for your question" required>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <select class="mx-2 form-select text-muted" name="year" id="drop" required>
                                    <option value="yr">Year</option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="mx-2 form-select text-muted" name="dept" id="drop" required>
                                    <option value="dept">Dept</option>
                                    <option value="BCA">BCA</option>
                                    <option value="MCA">MCA</option>
                                    <option value="B.Sc Mathemetics">B.Sc Mathemetics</option>
                                    <option value="M.Sc Mathemetics">M.Sc Mathemetics</option>
                                    <option value="B.Sc Physics">B.Sc Physics</option>
                                    <option value="M.Sc Physics">M.Sc Physics</option>
                                    <option value="B.Sc Chemistry">B.Sc Chemistry</option>
                                    <option value="M.Sc Chemistry">M.Sc Chemistry</option>
                                    <option value="B.Sc Geography">B.Sc Geography</option>
                                    <option value="B.Sc Botony">B.Sc Botony</option>
                                    <option value="M.Sc Botony">M.Sc Botony</option>
                                    <option value="B.Sc Zoology">B.Sc Zoology</option>
                                    <option value="M.Sc Zoology">M.Sc Zoology</option>
                                    <option value="B.Sc Visual Communication">B.Sc Visual Communication</option>
                                    <option value="M.A Communication">M.A Communication</option>
                                    <option value="B.Sc Microbiology">B.Sc Microbiology</option>
                                    <option value="BSW">B.S.W</option>
                                    <option value="MSW">M.S.W</option>
                                    <option value="BA History">BA History</option>
                                    <option value="MA History">MA History</option>
                                    <option value="BA Political Science">BA Political Science</option>
                                    <option value="MA Political Science">MA Political Science</option>
                                    <option value="BA Tamil">BA Tamil</option>
                                    <option value="MA Tamil">MA Tamil</option>
                                    <option value="BA English">BA English</option>
                                    <option value="MA English">MA English</option>
                                    <option value="B.com">B.Com</option>
                                    <option value="M.com">M.com</option>
                                    <option value="BBA">BBA</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="mx-2 form-select text-muted" name="class" id="drop" required>
                                    <option value="yr">Class</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                </select>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col">
                                <input type="text" name="from" placeholder="Enter city name" class="form-control" required>
                                <span class="text-muted f-12">Enter the city name from where you born</span>
                            </div>
                            <div class="col">
                                <input type="text" name="lives" placeholder="Enter city name" class="form-control" required>
                                <span class="text-muted f-12">Enter the city name from where you lives now</span>
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <label class="form-check-label">Male</label>
                                    <input type="radio" name="Gender" value="Male" class="form-check-input">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <label class="form-check-label">Female</label>
                                    <input type="radio" name="Gender" value="Female" class="form-check-input">
                                </div>
                            </div>
                            <div class="col-4">
                                <input type="text" name="age" placeholder="Age" class="form-control" required>
                            </div>
                        </div>
                        <div class="row my-3 text-center">
                            <div class="my-3 mb-0">
                                <button type="submit" name="registerbtn" class="btn btn-success">Sign Up</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="bg-grey my-5 p-3 d-flex mb-0">
        <div class="container">
            <div>
                <a href="./feedback.php" class="btn text-muted mx-3">Give your Feedback</a>
            </div>
            <hr>
            <div>
                <p class="text-muted mx-3">Students Hub &copy; 2022.</p>
            </div>
        </div>
    </footer>
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
</body>

</html>