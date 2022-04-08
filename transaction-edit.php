<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" type="image/png" href="assets/img/favicon.ico">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

	<title>Light Bootstrap Dashboard by Creative Tim</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />


    <!-- Bootstrap core CSS     -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="assets/css/animate.min.css" rel="stylesheet"/>

    <!--  Light Bootstrap Table core CSS    -->
    <link href="assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>


    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="assets/css/demo.css" rel="stylesheet" />


    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    <link href="assets/css/pe-icon-7-stroke.css" rel="stylesheet" />

</head>
<body>

<?php 
 require('config/config.php');
 require('config/db.php');

//getvalue sent
$id = $_GET['id'];
//create query
$query=$query = 'SELECT * from transaction where id ='.$id;
//get result
$result = mysqli_query($conn,$query);
//fetch data
if(mysqli_num_rows($result)==1){
   $transaction = mysqli_fetch_array($result);
   $documentcode = $transaction['documentcode'];
   $action = $transaction['action'];
   $remarks = $transaction['remarks'];
   $employeeid = $transaction['employee_id'];
   $officeid = $transaction['office_id'];
}
//free result
mysqli_free_result($result);

 //check if submitted
 if(isset($_POST['submit'])){
    //get data
    $employeeid = mysqli_real_escape_string($conn, $_POST['employeeid']);
    $officeid = mysqli_real_escape_string($conn, $_POST['officeid']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    $documentcode = mysqli_real_escape_string($conn, $_POST['documentcode']);
    //create query
    $query = "UPDATE transaction SET employee_id='$employeeid', office_id='$officeid', action='$action', remarks='$remarks', documentcode='$documentcode' WHERE id=".$id;
    //execute query
    if(mysqli_query($conn,$query)){

    }
    else{
        echo 'ERROR: '. mysqli_error($conn);
    }
 }
?>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="assets/img/sidebar-5.jpg">

    <!--

        Tip 1: you can change the color of the sidebar using: data-color="blue | azure | green | orange | red | purple"
        Tip 2: you can also add an image using data-image tag

    -->

    	<div class="sidebar-wrapper">
            <?php include('includes/sidebar.php'); ?>
    	</div>
        
    </div>

    <div class="main-panel">

        <?php include('includes/navbar.php'); ?>
        
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="header">
                                <h4 class="title">Edit Transaction Record</h4>
                            </div>
                            <div class="content">
                                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Document Code</label>
                                                <input type="text" class="form-control" name="documentcode" value="<?php echo $documentcode; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Action</label>
                                                <select class="form-control" name="action">
                                                    <?php
                                                    if($action=="IN"){ echo '<option value="IN" selectedd>IN</option>'; } else{ echo '<option value="IN">IN</option>'; }
                                                    if($action=="OUT"){ echo '<option value="OUT" selectedd>OUT</option>'; } else{ echo '<option value="OUT">OUT</option>'; }
                                                    if($action=="COMPLETE"){ echo '<option value="COMPLETE" selectedd>COMPLETE</option>'; } else{ echo '<option value="COMPLETE">COMPLETE</option>'; }
                                                    ?>    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Remarks</label>
                                                <input type="text" class="form-control" name="remarks" value="<?php echo $remarks; ?>">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Employee</label>
                                                <select class="form-control" name="employeeid">
                                                <option>Select...</option>
                                                <?php 
                                                $query = 'SELECT id, CONCAT(lastname, ", ", firstname) as employee_name FROM employee ORDER BY employee_name ASC';
                                                $result = mysqli_query($conn, $query);
                                                while($row = mysqli_fetch_array($result)){
                                                    if($row['id']==$employeeid){
                                                        echo "<option value=" . $row['id'] . " selected>" . $row['employee_name'] . "</option>";
                                                    }
                                                    else{
                                                        echo "<option value=" . $row['id'] . ">" . $row['employee_name'] . "</option>";
                                                    } 
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Office</label>
                                                <select class="form-control" name="officeid">
                                                <option>Select...</option>
                                                <?php 
                                                $query = "SELECT id, name FROM office ORDER BY name ASC";
                                                $result = mysqli_query($conn, $query);
                                                while($row = mysqli_fetch_array($result)){
                                                    if($row['id']==$officeid){
                                                        echo "<option value=" . $row['id'] . " selected>" . $row['name'] . "</option>"; 
                                                    }
                                                    else{
                                                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>"; 
                                                    }
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-info btn-fill" name="submit" value="Save">
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>             
                </div>  
            </div>
        </div>


        <?php include('includes/footer.php'); ?>

    </div>
</div>


</body>

    <!--   Core JS Files   -->
    <script src="assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="assets/js/chartist.min.js"></script>

    <!--  Notifications Plugin    -->
    <script src="assets/js/bootstrap-notify.js"></script>

    <!--  Google Maps Plugin    -->
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>

    <!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods, don't include it in your project! -->
	<script src="assets/js/demo.js"></script>
</html>
