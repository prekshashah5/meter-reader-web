<?php
  session_start();
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
.tbox{
  top:43%;
  left: 62.5%;
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
<p class="heading">Previous Bills</p>
<hr>
<div class="main">
  <?php
    include 'config.php';
         
    /* Attempt to connect to MySQL database */
    $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
         
    // Check connection
    if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $sql = "select ";
    $res = $conn->query($sql);
    //$row = $res->fetch_assoc();
    //print_r($row);
    //$reading = $row['reading'];
    //echo $reading;
    if(mysqli_num_rows($res)<=0)
      echo "<p>No records found</p>";
    while($row = $res->fetch_assoc())
    {
      $reading = $row['reading'];
      $rid = $row['reading_id'];
      $cid = $row['customer_id'];
      $_SESSION['cid'] = $cid;
      $cname = $row['f_name'];
      $mno = $row['mobile'];
      $status = $row['status'];
      echo "<br>";
      echo '<img class="display" src="data:image/png;base64,'.$row['photo'].'"/>';
      echo "<br><br><br><table><tr><td>Reading ID: </td><td>".$rid."</td></tr><tr><td>Reading:  </td><td>".$reading."</td></tr><tr><td>Customer ID: </td><td>".$cid."</td></tr><tr><td>Customer name: </td><td>".$cname."</td></tr><tr><td>Customer mobile number: </td><td>".$mno."</td></tr></table>"."<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href = \"generateB.php?rid=$rid\" class = \"btns\">Approve</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href = \"generateQ.php?rid=$rid\" class = \"btns\">Reassess</a></p><br><br><hr>";
    }
    
  ?>
</div>

</body>
</html>