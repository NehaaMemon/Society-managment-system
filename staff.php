<?php include './partials/layouts/layoutTop.php';?>
<?php

if (isset($_POST['addstaff'])) {

    // Fetch expense inputs from the form
    $name = $_POST['fname'];
    $block = $_POST['block'];
    $pos = $_POST['pos'];
    $sal = $_POST['salary'];
    $cont = $_POST['cont'];
    $date = $_POST['date'];
    $dp = $_POST['depart'];
    $time = $_POST['shift'];
    $sta = $_POST['stauts'];

    // Insert the block expenses along with the total amount
    $que = "INSERT INTO `staff`( `Name`, `Block`, `Position`, `Salary`, `PhoneNumber`, `JoiningDate`, `Department`, `ShiftTiming`, `Status`) 
     VALUES ('$name','$block','$pos','$sal','$cont','$date','$dp','$time','$sta')";

    // Execute the query
    $row = mysqli_query($con, $que);

    if($row) {
        // Success message
        echo '<div class="card-body p-24 d-flex flex-column gap-4">
                <div class="alert alert-primary bg-primary-50 text-primary-600 border-primary-50 px-24 py-11 mb-0 fw-semibold text-lg radius-8 d-flex align-items-center justify-content-between" role="alert">
                  Staff Added
                    <button class="remove-button text-primary-600 text-xxl line-height-1">
                        <iconify-icon icon="iconamoon:sign-times-light" class="icon"></iconify-icon>
                    </button>
                </div>';
    } else {
        // Error message
        echo 'Error: this entry is not add ';
    }
}
?>

<div class="row gy-4">
    <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Add Staff</h5>
                        </div>
                        <div class="card-body">
                        <form  method="POST" >
                            <div class="row gy-3">
                                <!-- <div class="col-12">

                                    <label class="form-label">Block </label>
                                    <input type="text" name="block" class="form-control" placeholder="Enter block Name">
                                </div> -->
                              
                                <div class="col-12">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="fname" class="form-control">
                                </div>  
                                <div class="col-12">
                                    <label class="form-label">block</label>
                                    <input type="text" name="block" class="form-control" >
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Position</label>
                                    <input type="number" name="pos" class="form-control" >
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Salary</label>
                                    <input type="number" name="salary" class="form-control">
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Contact</label>
                                    <input type="text" name="cont" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Department</label>

                                        <select class="form-select" name="depart">
                                        <option>Reception</option>
                                        <option>Cleaning</option>
                                        <option>Security</option>

                                        </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Joining Date</label>
                                    <input type="number" name="date" class="form-control">
                                </div>
                            
                                <div class="col-12">
                                    <label class="form-label">Shift</label>
                                    <input type="text" name="shift" class="form-control">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Status</label>
                                    <input type="date" name="stauts" class="form-control">
                                </div>
               
                                <br>
                                <div class="col-12">
                                    <button type="submit" name="addstaff" class="btn btn-primary-600">Submit</button>
                                </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include './partials/layouts/layoutBottom.php' ?>
