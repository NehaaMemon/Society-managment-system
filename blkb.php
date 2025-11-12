<?php include './partials/layouts/layoutTop.php';

if(isset($_POST['sale'])){
    $s = $_POST['start'];
    $e = $_POST['end'];
    // Fetch block details within date range and filter by block name (Block A)
    $query = "SELECT blocks.block_name,
                     blockexp.lift_expense,
                     blockexp.security_expense,
                     blockexp.parking_expense,
                     blockexp.water_expense,
                     blockexp.clean_expense,
                     blockexp.block_electri_bill,
                     blockexp.staff_expense,
                     blockexp.camera_exp,
                     blockexp.total_house,
                     blockexp.date,
                     (blockexp.lift_expense + blockexp.security_expense + blockexp.parking_expense + blockexp.water_expense + blockexp.clean_expense + blockexp.block_electri_bill + blockexp.staff_expense + blockexp.camera_exp) AS total_amount
              FROM blockexp
              INNER JOIN blocks ON blockexp.bl_id = blocks.id
              WHERE blocks.block_name = 'Block B'
              AND blockexp.date BETWEEN '$s' AND '$e'";

    $run = mysqli_query($con, $query);
}
?>

<div class="card">
    <div class="card-header">
       <center> <h5 class="card-title mb-0"> Block A Details</h5></center>
    </div>
    <div class="card-body">
    <form  method="POST" >
        <div class="card mb-4">
            <div class="card-body">
                <label for="dateRangePicker">Month Sale Report</label>
                <div class="input-daterange input-group">
                    <input type="date" class="input-sm form-control" name="start" required />
                    <div class="input-group-prepend">
                        <span class="input-group-text">to</span>
                    </div>
                    <input type="date" class="input-sm form-control" name="end" required />
                </div>
                <br>
                <center> <button type="submit" class="btn btn-primary" name="sale">Search</button></center>
            </div>
        </div>
    </form>

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
                    <th>Total House</th>
                    <th>Total Amount</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch each row and display in the table
                if (isset($run)) {
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
                    <td><?php echo $data['total_house']; ?></td>
                    <td><?php echo $data['total_amount']; ?></td>
                    <td><?php echo $data['date']; ?></td>
                </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div><!-- card end -->

<?php include './partials/layouts/layoutBottom.php'; ?>
