<?php include './partials/layouts/layoutTop.php';?>
<?php

$id = $_GET['id'];
   $qu="SELECT * FROM `blockexp` INNER JOIN blocks ON blockexp.bl_id = blocks.id where `b_id` = '$id'";
   $row = mysqli_query($con,$qu);
   $data = mysqli_fetch_assoc($row);

?>

<div class=" justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Add Blocks Expense</h5>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Block</label>
                        <input type="text" class="form-control" id="exampleInputEmail1"  value="<?php echo $data['block_name'];?>" aria-describedby="emailHelp"
                        name="blkn" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lift Expense</label>
                        <input type="number" name="lft" class="form-control" value="<?php echo $data['lift_expense'];?>" >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Security Expense</label>
                        <input type="number" name="sec" class="form-control" value="<?php echo $data['security_expense'];?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parking Expense</label>
                        <input type="number" name="par" class="form-control" value="<?php echo $data['parking_expense'];?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Water Expense</label>
                        <input type="number" name="wat" class="form-control" value="<?php echo $data['water_expense'];?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cleanliness Expense</label>
                        <input type="number" name="cle" class="form-control" value="<?php echo $data['clean_expense'];?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Block Electric Bill Expense</label>
                        <input type="number" name="ele" class="form-control" value="<?php echo $data['block_electri_bill'];?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Block Electric Bill Image/label>
                        <input type="file" name="image" class="form-control" >
                        <img src="<?php echo $data['bill_image'] ?>" width='40px' height="20px">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Staff Expense</label>
                        <input type="number" name="sta" class="form-control" value="<?php echo $data['lift_expense'];?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Camera Expense</label>
                        <input type="number" name="cam" class="form-control" value="<?php echo $data['camera_exp'];?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total House</label>
                        <input type="number" name="tot" class="form-control" value="<?php echo $data['total_house'];?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Month Name</label>
                        <input type="text" name="mon" class="form-control" value="<?php echo $data['month_name'];?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Year</label>
                        <input type="text" name="yea" class="form-control" value="<?php echo $data['year'];?>" disabled>
                    </div>

                    <div class="mb-3">
                        <button type="submit" name="updatetower" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
 if (isset($_POST['updatetower'])) {

    $f = $_FILES['image']['name'];
    $src = $_FILES['image']['tmp_name'];
    $des = "assets/images/image/" . $f;
    move_uploaded_file($src, $des);

    $l = $_POST['lft'];
    $s = $_POST['sec'];
    $p = $_POST['par'];
    $w = $_POST['wat'];
    $c = $_POST['cle'];
    $e = $_POST['ele'];
    $st = $_POST['sta'];
    $ca = $_POST['cam'];
    $t = $_POST['tot'];



    $q4= "update `blockexp` set `lift_expense`='$l',`security_expense` ='$s',`parking_expense` ='$p',`water_expense` ='$w',`clean_expense` ='$c',`block_electri_bill` = '$e',`bill_image` = '$des',`staff_expense` = '$st',`camera_exp` = '$ca',`total_house` = '$t' where `b_id` = '$id'
    ";
    // print_r($q4);
    // die();

  // Execute query
   mysqli_query($con, $q4);
   echo "<script>window.open('all_blk_exp.php','_self')</script>";
}


 $script = '<script src="assets/js/homeFiveChart.js"></script>';?>
<?php include './partials/layouts/layoutBottom.php' ?>
