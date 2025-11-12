<style>
   /* Target only the 'Choose File' button of the file input */
.file-input-custom::file-selector-button {
    background-color: lightcoral !important; /* Light red background */
    color: white; /* White text */
    padding: 8px 12px; /* Adjust padding to your preference */
    border: none; /* Remove the default border */
    border-radius: 4px; /* Optional: add rounded corners */
    cursor: pointer; /* Show pointer on hover */
}

/* Add a hover effect for better interaction */
.file-input-custom::file-selector-button:hover {
    background-color: #e57373; /* Slightly darker coral on hover */
}

/* Optional: Adjust focus styling */
.file-input-custom::file-selector-button:focus {
    outline: 2px solid lightcoral;
}

    .card .card-header {
  background-color: #33c539 !important;
  color: white !important;
}
.card .card-title {
  color: white !important;
}

.bordered-table thead tr th {
  background-color: #6985f5 !important;
  border-bottom: 1px solid var(--neutral-200) !important;
  color: white !important;

}


</style>
<?php
include './partials/layouts/layoutTop.php';

if (isset($_POST['addtower'])) {

    // Fetch expense inputs from the form
    $l = $_POST['lftexp'];
    $s = $_POST['secexp'];
    $p = $_POST['parexp'];
    $w = $_POST['watexp'];
    $c = $_POST['cleexp'];
    $e = $_POST['blkelec'];
    $st = $_POST['staexp'];
    $ct = $_POST['camexp'];

    $bl = $_POST['block'];
    $month = $_POST['month'];
    $year = $_POST['year'];

    // Check if data for this block, month, and year already exists
    $check_query = "SELECT * FROM blockexp WHERE bl_id = '$bl' AND month_name = '$month' AND year = '$year'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // If entry already exists, show a warning message
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Block expense for this block, month, and year already exists. You can only edit the existing record.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
    } else {
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $f = $_FILES['image']['name'];
            $src = $_FILES['image']['tmp_name'];
            $des = "assets/images/image/" . $f;
            move_uploaded_file($src, $des);
        } else {
            $des = null; // Set to null if no image is uploaded or an error occurs
        }

        $total_amount = $l + $s + $p + $w + $c + $e + $st + $ct;

        // Insert query if no entry exists for this block, month, and year
        $q2 = "INSERT INTO `blockexp`(`lift_expense`, `security_expense`, `parking_expense`, `water_expense`, `clean_expense`, `block_electri_bill`, `bill_image`, `staff_expense`, `camera_exp`, `total_amount`, `bl_id`, `month_name`, `year`)
               VALUES('$l', '$s', '$p', '$w', '$c', '$e', '$des', '$st', '$ct', '$total_amount', '$bl', '$month', '$year')";

        $row = mysqli_query($con, $q2);

        if ($row == true) {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Block Expenses have been added successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
        } else {
            echo 'Error adding block expense: ' . mysqli_error($con);
        }
    }
}

$currentMonthName = date('F'); // Returns the full name of the month, like 'October'
$year = date('Y');
?>


<div class="row gy-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            <h5 class="card-title mb-0">Add Blocks Expense</h5>
            </div>
            <div class="card-body">

                <!-- Corrected enctype to handle file uploads -->
                <form method="POST" enctype="multipart/form-data">
                    <div class="row gy-3">
                        <div class="col-6">

                        <label class="form-label">Block</label>
                        <select class="form-select" name="block">
                            <?php
                            $q4 = "SELECT * FROM `blocks`";
                            $row = mysqli_query($con, $q4);
                            while ($data = mysqli_fetch_assoc($row)) {
                            ?>
                            <option value="<?php echo $data['id']; ?>"><?php echo $data['block_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Lift Expense</label>
                        <input type="number" name="lftexp" class="form-control">
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Security Expense</label>
                        <input type="number" name="secexp" class="form-control">
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Parking Expense</label>
                        <input type="number" name="parexp" class="form-control">
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Water Expense</label>
                        <input type="number" name="watexp" class="form-control">
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Cleanliness Expense</label>
                        <input type="number" name="cleexp" class="form-control">
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Block Electric Bill Expense</label>
                        <input type="number" name="blkelec" class="form-control">
                    </div>

                    <div class="mb-3 col-6">
                    <label class="form-label">Block Electric Bill Image</label>
                    <input type="file" name="image" class="form-control file-input-custom">
                </div>


                    <div class="mb-3 col-6">
                        <label class="form-label">Staff Expense</label>
                        <input type="number" name="staexp" class="form-control">
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Camera Expense</label>
                        <input type="number" name="camexp" class="form-control">
                    </div>



                    <div class="mb-3 col-6">
                        <label class="form-label">Month Name</label>
                        <input type="text" name="month" class="form-control" value="<?php echo $currentMonthName; ?>">
                    </div>

                    <div class="mb-3 col-6">
                        <label class="form-label">Year</label>
                        <input type="text" name="year" class="form-control" value="<?php echo $year; ?>">
                    </div>

                    <div class="mb-3">
                        <button type="submit" name="addtower" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>





<?php

    // Fetch all blocks, including blocks without expense data
    $query = "SELECT blocks.block_name,
                         blockexp.b_id AS block_exp_id,
                     COALESCE(blockexp.lift_expense, 0) AS lift_expense,
                     COALESCE(blockexp.security_expense, 0) AS security_expense,
                     COALESCE(blockexp.parking_expense, 0) AS parking_expense,
                     COALESCE(blockexp.water_expense, 0) AS water_expense,
                     COALESCE(blockexp.clean_expense, 0) AS clean_expense,
                     COALESCE(blockexp.block_electri_bill, 0) AS block_electri_bill,
                     COALESCE(blockexp.staff_expense, 0) AS staff_expense,
                     COALESCE(blockexp.camera_exp, 0) AS camera_exp,

                     COALESCE(blockexp.month_name, '-') AS month_name,
                     COALESCE(blockexp.year, '-') AS year,

                     (COALESCE(blockexp.lift_expense, 0) + COALESCE(blockexp.security_expense, 0) +
                      COALESCE(blockexp.parking_expense, 0) + COALESCE(blockexp.water_expense, 0) +
                      COALESCE(blockexp.clean_expense, 0) + COALESCE(blockexp.block_electri_bill, 0) +
                      COALESCE(blockexp.staff_expense, 0) + COALESCE(blockexp.camera_exp, 0)) AS total_amount
              FROM blocks
              LEFT JOIN blockexp ON blockexp.bl_id = blocks.id";

    $run = mysqli_query($con, $query);

?>

<div class="card">
    <div class="card-header">
       <center><h5 class="card-title mb-0">All Block Expenses</h5></center>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0">
                <thead>
                    <tr>
                        <th>Blocks</th>
                        <th>Lift Expense</th>
                        <th>Security Expense</th>
                        <th>Parking Expense</th>
                        <th>Water Expense</th>
                        <th>Cleaning Expense</th>
                        <th>Block Electric Bill Expense</th>
                        <th>Staff Expense</th>
                        <th>Camera Expense</th>
                        <th>Total Amount</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch each row and display in the table
                    while ($data = mysqli_fetch_assoc($run)) {
                    ?>
                    <tr>
                        <td><?php echo ucfirst($data['block_name']); ?></td>
                        <td><?php echo $data['lift_expense']; ?></td>
                        <td><?php echo $data['security_expense']; ?></td>
                        <td><?php echo $data['parking_expense']; ?></td>
                        <td><?php echo $data['water_expense']; ?></td>
                        <td><?php echo $data['clean_expense']; ?></td>
                        <td><?php echo $data['block_electri_bill']; ?></td>
                        <td><?php echo $data['staff_expense']; ?></td>
                        <td><?php echo $data['camera_exp']; ?></td>

                        <td><?php echo $data['total_amount']; ?></td>
                        <td><?php echo $data['month_name']; ?></td>
                        <td><?php echo $data['year']; ?></td>
                        <td>
                           <a href="edit_blk_exp.php?id=<?php echo $data['block_exp_id']; ?>" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                             <iconify-icon icon="lucide:edit"></iconify-icon>
                            </a>
                            <a href="delete_blk_exp.php?id=<?php echo $data['block_exp_id']; ?>" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                           <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                         </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div><!-- card end -->
</div>


<?php $script = '<script src="assets/js/homeFiveChart.js"></script>';?>
<?php include './partials/layouts/layoutBottom.php' ?>
