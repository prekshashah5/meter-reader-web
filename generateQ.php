<?php
  $reading_id = $_GET['rid'];
  include 'config.php';
       
  /* Attempt to connect to MySQL database */
  $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
       
  // Check connection
  if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  $sql = "update reading_history set status = '2' where reading_id = '$reading_id'";
  $res = $conn->query($sql);
  header("Location: approve.php");
?>