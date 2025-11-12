
<?php include './partials/layouts/layoutTop.php';?>
<?php
$q1 = "SELECT * FROM `blocks`";
$row = mysqli_query($con,$q1);

?>


<!-- <div class="col-lg-3"></div>
<div class="col-lg-6"> -->
                    <div class="card">
                        <div class="card-header">
                           <center> <h5 class="card-title mb-0">All Block Details</h5></center>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table basic-border-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>Blocks </th>
                                            <th> Total Lift</th>
                                            <th>Total Houses</th>
                                            <th>Total Houses Status</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                      while($data=mysqli_fetch_assoc($row)){
                        $_SESSION['id'] = $data['id'];


                        ?>
                                        <tr>
                                            <!-- <td>
                                                <a href="javascript:void(0)" class="text-primary-600">#526534</a>
                                            </td> -->
                                            <td><?php echo $data['block_name'];?></td>
                                            <td><?php echo $data['total_lift'];?></td>
                                            <td><?php echo $data['total_house'];?></td>
                                            <td><?php echo $data['total_house_status'];?></td>





                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- card end -->
                <!-- </div> -->
                <?php include './partials/layouts/layoutBottom.php' ?>
