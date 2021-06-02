<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="heading.css">
<link rel="stylesheet" href="navigation.css">
<style>
p{
  margin-left: 10%;
  font-size: 14px;
  font-family: sans-serif;
}

.display {
  width: 270px;
  height: 361px;
  float: left;
  margin-left: 20%;
  padding-right: 4%;
}

.btns{
  padding: 1.2% 2%;
  margin-left: 0%;
  font-size: 15px;
}
#file-chosen{
  margin-left: 2%;
  font-family: sans-serif;
}

.readings{
  font-family: sans-serif,Arial;
  margin-left: 45%;
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
  <a href="approve.php" class="active">Approve Bill</a>
  <a href="reports.php">Reports</a>
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
    $sql = "select photo,reading,reading_id,c.f_name,c.customer_id,c.mobile,status from reading_history as r inner join customer_master as c on r.customer_id = c.customer_id where status='0'";
    $res = $conn->query($sql);
    //$row = $res->fetch_assoc();
    //print_r($row);
    //$reading = $row['reading'];
    //echo $reading;
    if(mysqli_num_rows($res)<=0)
    {
        echo '<script type="text/JavaScript">
                        alert("No records found!")
                        location.replace("home_company.php")
                        </script>';
      die();
    }
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