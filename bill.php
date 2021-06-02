<?php
  session_start();
    include 'config.php';
         
    /* Attempt to connect to MySQL database */
    $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
         
    // Check connection
    if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }  
  $username = $_SESSION['user'];
  $res1 = mysqli_query($conn,"select customer_id from customer_master where username = '$username'");
  $id = $res1->fetch_assoc();
  $cid = $id["customer_id"];
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="navigation.css">
<link rel="stylesheet" href="heading.css">
<style>
  .mtable
  {
    width: 100%;
    margin-left: 0%;
  }
  table,tr,td{
    margin: 1%;
    font-size: 20px;
    border: 0px solid #ddd;
    border-bottom: 1px solid #ddd;
    text-align: center;
  }
  th
  {
    height: 60px;
    border: 0px solid #ddd;
    border-bottom: 1px solid #ddd;
  }
  table
  {
    border-collapse: collapse;
  }
  .btns
  {
    width: 15%;
    height:10px;
    padding: 2% 5%;
    font-size: 12px;
    margin-left: 7.5%;
    margin-bottom:  3%;
  }

</style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="logo.png" class="im">
  <a href="home.php">Home</a>
  <a href="upload.php">Upload Photo</a>
  <a href="bill.php"  class="active">Download Bill</a>
  <a href="about.php">About Us</a>
  <a href="contact.php">Contact Us</a>
  <a href="meter.php">Add Meter</a>
  <div class="profile">
  <a href="profile.php"><img src="profile.png" class="profile"></a>
  </div>
</div>
<p class="heading">Download Bill</p>
<hr>
<?php
    $sql = "select bill_id,curr_reading_id,prev_reading_id from bill_master where customer_id='$cid' order by billing_date desc";
    $res = $conn->query($sql);
    if(mysqli_num_rows($res)>0)
    {
      echo '<table border="1" class="mtable"><tr><th>Date</th><th>Bills</th></tr>';
      while($row = $res->fetch_assoc())
      {
        $bill_id = $row['bill_id'];
        $curr_reading_id = $row['curr_reading_id'];
        $sql2= "select date_time from reading_history where reading_id='$curr_reading_id'";
        $res2 = $conn->query($sql2);
        $row2 = $res2->fetch_assoc();
        $date = $row2['date_time'];
        $date = date("d-m-Y", strtotime($date)); 
        echo "<tr><td>".$date."</td><td><a href = \"download_bill.php?bill_id=$bill_id\" class = \"btns\">Download Bill</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
      }
      echo "</table>";
    }
    else
    {
      echo '<script type="text/JavaScript">
                        alert("No records found!")
                        location.replace("upload.php")
                        </script>';
      die();
    }
?>


</body>
</html>