<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="heading.css">
<link rel="stylesheet" href="navigation.css">
<style>

.uploadbtn{
  display: inline-block;
  background-color: #557A95;
  color: white;
  padding: 1.5% 4%;
  font-family: sans-serif;
  border-radius: 10%;
  cursor: pointer;
  margin-top: 10%;
  
}

table,tr,td{
  margin-left: 10%;
  font-size: 14px;
  border: 1px solid #bbb;
  padding:2%;
  width:  30%;
}

table
{
  border-collapse: collapse;
}

.display {
  width: 20%;
  float: left;
  margin-left: 20%;
  padding-right: 4%;
}

.results{
  margin-left: 20%;
  font-family: sans-serif,Arial;
  font-size:  14px;
}
.topnav
{
  position: fixed;
  width: 100%;
}
.main
{
  padding-top: 9%;
}

</style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="logo.png" class="im">
  <a href="home_company.php">Home</a>
  <a href="approve.php">Approve Bill</a>
  <a href="reports.php" class="active">Reports</a>
  <a href="about_company.php">About Us</a>
  <a href="contact_company.php">Contact Us</a>
  <div class="profile">
  <a href="profile_company.php"><img src="profile.png" class="profile"></a>
  </div>
</div>

<div class="main">
  <?php
    include 'config.php';
         
    /* Attempt to connect to MySQL database */
    $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
         
    // Check connection
    if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    echo "<p class=\"results\">Total Bills Generated: ";
    $sql1 = "select * from reading_history where status='1'";
    $res1 = $conn->query($sql1);
    echo mysqli_num_rows($res1)."</p>";
    echo "<p class=\"results\">Total Bills Generated this month: ";
    $sql2 = "select * from reading_history where status='1' and month(date_time)=month(NOW())";
    $res2 = $conn->query($sql2);
    echo mysqli_num_rows($res2)."<br></p>";

    $sql3 = "select photo,reading,reading_id,c.f_name,c.customer_id,c.mobile,status from reading_history as r inner join customer_master as c on r.customer_id = c.customer_id";
    $res3 = $conn->query($sql3);
    echo "<hr>";  
    while($row = $res3->fetch_assoc())
    {
      $reading = $row['reading'];
      $rid = $row['reading_id'];
      $cid = $row['customer_id'];
      $cname = $row['f_name'];
      $mno = $row['mobile'];
      $status = $row['status'];
      $str = 'No';
      if($status == '1')
      {
        $str = 'Yes';
      }
      $q = 'No';
      if($status == '2')
      {
        $q = 'Yes';
      }
      echo '<br><img class="display" src="data:image/png;base64,'.$row['photo'].'"/><br><br><br>';
      echo "<table><tr><td>Reading ID: </td><td>".$rid."</td></tr><tr><td>Reading:  </td><td>".$reading."</td></tr><tr><td>Customer ID: </td><td>".$cid."</td></tr><tr><td>Customer name: </td><td>".$cname."</td></tr><tr><td>Customer mobile number: </td><td>".$mno."</td></tr><tr><td>Approved: </td><td>".$str."</td></tr><tr><td>Reassessed: </td><td>".$q."</td></tr></table><br><br><br><br><br><hr>";
    }
    
  ?>
</div>

</body>
</html>