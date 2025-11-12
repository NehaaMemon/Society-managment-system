<?php include './partials/layouts/layoutTop.php';



$q1 =  "SELECT * FROM `blk_flor_detail` INNER JOIN `blocks` ON blk_flor_detail.`blk_id` = blocks.`id`
       WHERE blocks.block_name = 'Block A'";


$row = mysqli_query($con, $q1);


if (!$row) {

    echo "Error: " . mysqli_error($con);
} else {
?>


<div class="card">
    <div class="card-header">
       <center> <h5 class="card-title mb-0"> Block A  Honour Details</h5></center>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table basic-border-table mb-0">
                <thead>
                    <tr>
                     <th>society id</th>
                        <th>Honour Name</th>
                        <th>House Status</th>
                        <th>NIC No</th>
                        <th>Contact No</th>
                        <th>Maintance Amount</th>
                        <th>Block Name</th>


                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($data = mysqli_fetch_assoc($row)) {
                    ?>
                    <tr>
                    <td><?php echo $data['socid']; ?></td>
                        <td><?php echo $data['honour_name']; ?></td>
                        <td><?php echo $data['house_status']; ?></td>
                        <td><?php echo $data['nic_no']; ?></td>
                        <td><?php echo $data['contact_no']; ?></td>
                        <td><?php echo $data['maintance']; ?></td>
                        <td value="<?php echo $data['blk_id'];?>"><?php echo $data['block_name']; ?></td>

                    </tr>
                    <?php
                    } // While loop ka end
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div><!-- card ka end -->

<?php
} // If-else ka end
include './partials/layouts/layoutBottom.php';
?>
