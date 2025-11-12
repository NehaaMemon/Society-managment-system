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


<?php include './partials/layouts/layoutTop.php';

    // Fetch all blocks, including blocks without expense data
    $query = "SELECT blocks.block_name,
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
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch each row and display in the table
                    while ($data = mysqli_fetch_assoc($run)) {
                    ?>
                    <tr>
                        <td><?php echo $data['block_name']; ?></td>
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
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div><!-- card end -->
</div>

<?php include './partials/layouts/layoutBottom.php'; ?>
