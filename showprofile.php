<?php
require_once "config.php";
if (isset($_POST['input'])) {
    $filter = $_POST['input'];
    $query = $conn->query("select * from students_register where concat(First_name,Last_name,Email_id,Year,Department) like '%{$filter}%'");
    if ($query->num_rows > 0) {
        while ($r = $query->fetch_assoc()) {
?>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card bg-white p-2 shadow" style="border-radius: 20px;">
                    <div class="card-body">
                        <div class="d-flex align-items-center p-2">
                            <img src="profilepics/<?php echo $r['Profile_pic'] ?>" class="shadow me-2" style="width:75px;height:75px;object-fit:cover;border-radius:10px">
                            <div class="mx-3">
                                <p class="m-0 fw-bold"><?php echo $r['First_name'] ?> <?php echo $r['Last_name'] ?></p>
                                <small class="text-muted"><?php echo $r['Year'] ?> <?php echo $r['Department'] ?> <?php echo $r['Class'] ?></small>
                            </div>
                        </div>
                        <div class="row text-center mt-3">
                            <a href="profile.php?account=<?php echo $r['Email_id'] ?>" class="btn btn-outline-success"><i class="fas fa-eye"></i> Look Profile</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    } else {
        ?>
        <h4 class="text-center">No profile found!</h4>
<?php
    }
} ?>
<hr class="mt-4 mb-4">
