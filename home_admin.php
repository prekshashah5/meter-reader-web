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
}
.display {
  width: 20%;
  float: left;
  margin-left: 20%;
  padding-right: 4%;
}
.btns{
  padding: 1% 2%;
  margin-left: 0%;
  font-size: 13px;
  margin-top: 1%;
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

input[type=text], select {
  width: 30%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 2%;
  box-sizing: border-box;
}

</style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="logo.png" class="im">
  <a href="home_admin.php" class="active">Home</a>
  <div class="profile">
  <a href="profile_admin.php"><img src="profile.png" class="profile"></a>
  </div>
</div>

<div>
  <?php
    include 'config.php';
         
    /* Attempt to connect to MySQL database */
    $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
         
    // Check connection
    if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $sql = "select photo,reading,reading_id,customer_id from reading_history where status='2'";
    $res = $conn->query($sql);
    while($row = $res->fetch_assoc())
    {
      $reading = $row['reading'];
      $rid = $row['reading_id'];
      $cid = $row['customer_id'];
      echo '<br><br><img class="display" src="data:image/png;base64,'.$row['photo'].'"/>';
      echo "<br><br><br><table><tr><td>Reading ID: </td><td>".$rid."</td></tr><tr><td>Reading:  </td><td>".$reading."</td></tr><tr><td>Customer ID: </td><td>".$cid."</td></tr></table>";
      echo "<form action = \"action.php\" method=\"POST\">";
      echo "<div>";
      echo "<br><input type=\"text\" name=\"ereading\" placeholder=\"Enter Reading\">";
      echo "<input type=\"hidden\" id=\"rid\" name=\"rid\" value=\"$rid\"><br>";
      echo "<input type=\"submit\" name=\"confirm\" value=\"Confirm\" class = \"btns\">";
      echo "</div></form><br><br><br><br><br><br><hr>";
    }
  ?>
</div>

</body>
</html>