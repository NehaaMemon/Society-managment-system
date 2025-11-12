<?php include './partials/layouts/layoutTop.php';?>

<?php
// Query to fetch block expenses and calculate the total amount for each block
$q1 = "SELECT * FROM `staff` WHERE `depart` = 'Reception';";

$row = mysqli_query($con, $q1);  // Execute the query
?>

<div class="card">
    <div class="card-header">
       <center> <h5 class="card-title mb-0">Reception Satff</h5></center>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>CNIC</th>
                        <th>Conatct</th>
                        <th>Address </th>
                        <th>Department</th>
                        <th>Salary </th>
                        <th>Positon </th>
                        <th>Hire-Date </th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Loop through each row fetched from the database
                    while ($data1 = mysqli_fetch_assoc($row)) {
                    ?>
                    <tr>
                        <td><?php echo $data1['fname']; ?></td>
                        <td><?php echo $data1['gender']; ?></td>
                        <td><?php echo $data1['cnic']; ?></td>
                        <td><?php echo $data1['contact']; ?></td>
                        <td><?php echo $data1['address']; ?></td>
                        <td><?php echo $data1['depart']; ?></td>
                        <td><?php echo $data1['salary']; ?></td>
                        <td><?php echo $data1['position']; ?></td>
                        <td><?php echo $data1['HireDate']; ?></td>

                        <!-- Calculate and print the total amount here -->
                    </tr>
                    <?php
                    } // End of while loop
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div><!-- card end -->
<?php $script = '<script src="assets/js/homeOneChart.js"></script>';?>
<?php include './partials/layouts/layoutBottom.php'; ?>

