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

    $search = '';
    if(isset($_GET['submit'])){
        //getvalue from search
        $search = $_GET['search'];
    }
   

    //define number of results per page
    $results_per_page = 25;

    //find total number of results in the database
    $query = 'SELECT * from transaction';
    $result = mysqli_query($conn,$query);
    $result_num = mysqli_num_rows($result);

    //determine total number of pages available
    $number_of_page = ceil($result_num / $results_per_page);

    //determine which page number visitor is currently on
    if(!isset($_GET['page'])){
        $page = 1;
    }
    else{
        $page = $_GET['page'];
    }

    //determine sql limit starting number for the result on the display
    $page_first_result = ($page-1) * $results_per_page;

    if( strlen($search)>0){
        //Create Query
        $query = 'SELECT transaction.id, transaction.datelog, transaction.action, transaction.remarks, transaction.documentcode, office.name as office_name, CONCAT(employee.lastname, ", ", employee.firstname) as employee_name  FROM transaction, employee, office WHERE transaction.employee_id = employee.id AND transaction.office_id = office.id AND transaction.documentcode = "' . $search . '" ORDER BY transaction.documentcode, transaction.datelog DESC LIMIT '.$page_first_result.','.$results_per_page;
        //Get Result
        $result = mysqli_query($conn, $query);
    }else{
        //Create Query
        $query = 'SELECT transaction.id, transaction.datelog, transaction.action, transaction.remarks, transaction.documentcode, office.name as office_name, CONCAT(employee.lastname, ", ", employee.firstname) as employee_name  FROM transaction, employee, office WHERE transaction.employee_id = employee.id AND transaction.office_id = office.id ORDER BY transaction.datelog DESC LIMIT '.$page_first_result.','.$results_per_page;
        //Get Result
        $result = mysqli_query($conn, $query);
    }

    //Fetch Data
    $transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);
    //Free Result
    mysqli_free_result($result);
    //Close Connection
    mysqli_close($conn);
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
                            <br>
                            <div class="col-md-12">
                                <form action="transactions.php" method="GET">
                                    <input type="text" name="search" >
                                    <input type="submit" class="btn btn-info btn-fill" value="search" name="submit">
                                </form>
                            </div>
                            <div class="col-md-12">
                                <a href="transaction-add.php">
                                    <button class="btn btn-info btn-fill pull-right">Add New Transaction</button>
                                </a>
                            </div>
                            <div class="header">
                                <h4 class="title">Transactions</h4>
                                <p class="category">Here is the list of all transaction records in the database.</p>
                            </div>
                            <div class="content table-responsive table-full-width">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>Date Log</th>
                                        <th>Document Code</th>
                                        <th>Action</th>
                                        <th>Office</th>
                                        <th>Employee</th>
                                        <th>Remarks</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach($transactions as $transaction):?>
                                        <tr>
                                            <td><?php echo $transaction['datelog']?></td>
                                            <td><?php echo $transaction['documentcode']?></td>
                                            <td><?php echo $transaction['action']?></td>
                                            <td><?php echo $transaction['office_name']?></td>
                                        	<td><?php echo $transaction['employee_name']?></td>
                                            <td><?php echo $transaction['remarks']?></td>   
                                            <td>
                                                <a href="transaction-edit.php?id=<?php echo $transaction['id']; ?>">
                                                    <button type="submit" class="btn btn-warning btn-fill">Edit</button>
                                                </a>
                                            </td>   
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    for($page=1; $page<=$number_of_page; $page++){
                        echo '<a href=transactions.php?page='.$page.'>' . $page . '</a>';
                    } 
                ?>
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
	<script src="assets/js/demo.js"></script>>

</html>
