<?php include './partials/layouts/layoutTop.php';?>

<?php
// Query to fetch block expenses and calculate the total amount for each block
$q1 = "SELECT * FROM `staff` WHERE `depart` = 'Cleaning';";

$row = mysqli_query($con, $q1);  // Execute the query
?>

<div class="card">
    <div class="card-header">
       <center> <h5 class="card-title mb-0">Cleaning Satff</h5></center>
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
                    while ($data = mysqli_fetch_assoc($row)) {
                    ?>
                    <tr>
                        <td><?php echo $data['fname']; ?></td>
                        <td><?php echo $data['gender']; ?></td>
                        <td><?php echo $data['cnic']; ?></td>
                        <td><?php echo $data['contact']; ?></td>
                        <td><?php echo $data['address']; ?></td>
                        <td><?php echo $data['depart']; ?></td>
                        <td><?php echo $data['salary']; ?></td> 
                        <td><?php echo $data['position']; ?></td>
                        <td><?php echo $data['HireDate']; ?></td>
                        
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

<?php include './partials/layouts/layoutBottom.php'; ?>
