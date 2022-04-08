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
$query="SELECT * FROM employee where id =".$id;
//get result
$result = mysqli_query($conn,$query);
//fetch data
if(mysqli_num_rows($result)==1){
   $employee = mysqli_fetch_array($result);
   $fname = $employee['firstname'];
   $lname = $employee['lastname'];
   $address = $employee['address'];
   $office = $employee['office_id'];
}
//free result
mysqli_free_result($result);

 //check if submitted
 if(isset($_POST['submit'])){
    //get data
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $office = mysqli_real_escape_string($conn, $_POST['office']);
    //create query
    $query = "UPDATE employee SET lastname='$lname', firstname='$fname', office_id='$office', address='$address' WHERE id=".$id;
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
                                <h4 class="title">Edit Employee Record</h4>
                            </div>
                            <div class="content">
                                <form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" name="fname" value="<?php echo $fname; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" name="lname" value="<?php echo $lname; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Office</label>
                                                <select class="form-control" name="office">
                                                <?php 
                                                $query = "SELECT id, name FROM office";
                                                $result = mysqli_query($conn, $query);
                                                while($row = mysqli_fetch_array($result)){
                                                    if($row['id'] == $office){
                                                        echo "<option value=" . $row['id'] . " selected>" . $row['name'] . "</option>";
                                                    }
                                                    else{
                                                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>"; 
                                                    }
                                                }
                                                //close connection
                                                mysqli_close($conn);
                                                ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Address</label>
                                                <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
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
