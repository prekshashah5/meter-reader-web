<?php
	if(isset($_POST['confirm']))
	{
		$ereading = $_POST['ereading'];
		$rid = $_POST['rid'];
		include 'config.php';
	    /* Attempt to connect to MySQL database */
	    $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
	         
	    // Check connection
	    if($conn === false){
	      die("ERROR: Could not connect. " . mysqli_connect_error());
	    }
	    $sql = "update reading_history set reading = '$ereading' where reading_id = '$rid'";
	    $res = mysqli_query($conn,$sql);
	    echo $res;
	    $sql2 = "update reading_history set status = '0' where reading_id = '$rid'";
	    $res2 = mysqli_query($conn,$sql2);
	    header("Location: home_admin.php");
	}
?>