<style>
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
error_reporting(0); // Disable error reporting

if (isset($_POST['report'])) {

    // Sanitize inputs
    $m = mysqli_real_escape_string($con, $_POST['months']);
    $y = mysqli_real_escape_string($con, $_POST['years']);
    $b = mysqli_real_escape_string($con, $_POST['blocks']);

    // Query to get block expenses
    $q1 = "SELECT blocks.block_name,
                  blockexp.b_id AS block_exp_id,  /* Fetch blockexp.id for edit and delete */
                  blockexp.lift_expense,
                  blockexp.security_expense,
                  blockexp.parking_expense,
                  blockexp.water_expense,
                  blockexp.clean_expense,
                  blockexp.block_electri_bill,
                  blockexp.bill_image,
                  blockexp.staff_expense,
                  blockexp.camera_exp,

                  blockexp.month_name,
                  blockexp.year,
                  (blockexp.lift_expense + blockexp.security_expense + blockexp.parking_expense + blockexp.water_expense + blockexp.clean_expense +  blockexp.block_electri_bill +  blockexp.staff_expense + blockexp.camera_exp) AS total_amount
           FROM blockexp
           INNER JOIN blocks ON blockexp.bl_id = blocks.id
           WHERE month_name = '$m' AND year = '$y' AND bl_id = '$b'";

    // Execute query
    $result = mysqli_query($con, $q1);
    if (!$result) {
        echo "SQL Error: " . mysqli_error($con);
    } else {
        $num_rows = mysqli_num_rows($result);
        if ($num_rows <= 0) {
            echo "<div class='alert alert-warning'>No records found for the selected month, year, and block.</div>";
        }
    }
}
?>

<div class="row gy-4">
    <div class="card">
    <div class="card-header">
                <h6 class="card-title mb-0">All Blocks Report</h6>
            </div>
        <div class="card-body">
            <fieldset class="wizard-fieldset show">

                <form method="POST">
                    <div class="row gy-3">
                        <div class="col-sm-4">
                            <label class="form-label">Month Name</label>
                            <div class="position-relative">
                                <select class="form-select" name="months">
                                    <?php
                                    $q4 = "SELECT DISTINCT month_name FROM `blockexp`";
                                    $row_months = mysqli_query($con, $q4);
                                    while ($data = mysqli_fetch_assoc($row_months)) {
                                    ?>
                                        <option value="<?php echo $data['month_name']; ?>"><?php echo $data['month_name']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Year</label>
                            <div class="position-relative">
                                <select class="form-select" name="years">
                                    <?php
                                    $q4 = "SELECT DISTINCT year FROM `blockexp`";
                                    $row_years = mysqli_query($con, $q4);
                                    while ($data = mysqli_fetch_assoc($row_years)) {
                                    ?>
                                        <option value="<?php echo $data['year']; ?>"><?php echo $data['year']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">Block Name</label>
                            <select class="form-select" name="blocks">
                                <?php
                                $q4 = "SELECT * FROM `blocks`";
                                $row_blocks = mysqli_query($con, $q4);
                                while ($data = mysqli_fetch_assoc($row_blocks)) {
                                ?>
                                    <option value="<?php echo $data['id']; ?>"><?php echo $data['block_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="mb-3">
                        <button type="submit" name="report" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>

<?php if (mysqli_num_rows($result) > 0) { ?>
    <div class="card">
        <div class="card-header">
            <center><h5 class="card-title mb-0"> Block Details</h5></center>
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
                            <th>Block Electric Bill Image</th>
                            <th>Staff Expense</th>
                            <th>Camera Expense</th>
                            <th>Total Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $total_sum = 0; // Initialize total sum variable
                        while ($data = mysqli_fetch_assoc($result)) {

                            $total_sum += $data['total_amount']; // Accumulate total amount
                        ?>
                            <tr>
                                <td><?php echo $data['block_name']; ?></td>
                                <td><?php echo $data['lift_expense']; ?></td>
                                <td><?php echo $data['security_expense']; ?></td>
                                <td><?php echo $data['parking_expense']; ?></td>
                                <td><?php echo $data['water_expense']; ?></td>
                                <td><?php echo $data['clean_expense']; ?></td>
                                <td><?php echo $data['block_electri_bill']; ?></td>
                                <td><img src="<?php echo $data['bill_image']; ?>" width="100"></td>
                                <td><?php echo $data['staff_expense']; ?></td>
                                <td><?php echo $data['camera_exp']; ?></td>
                                <td><?php echo $data['total_amount']; ?></td>
                                <td>
                                    <a href="edit_blk_exp.php?id=<?php echo $data['block_exp_id']; ?>" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="lucide:edit"></iconify-icon>
                                    </a>
                                    <a href="delete_blk_exp.php?id=<?php echo $data['block_exp_id']; ?>" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                        <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        <!-- <tr>
                            <td colspan="11" style="text-align: right;"><strong>Total Expense of <?php echo $m; ?> :</strong></td>
                            <td colspan="2"><strong><?php echo $total_sum; ?></strong></td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php } ?>
<?php
// Footer and layout bottom
include './partials/layouts/layoutBottom.php';
?>
