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
<link rel="stylesheet" href="heading.css">
<link rel="stylesheet" href="navigation.css">
<style>

.btns{
  display: inline-block;
  color: white;
  padding: 1.5% 4%;
  font-family: sans-serif;
  margin-left: 43.8%;
}
.box { 
      border: 1px solid #00FF00; 
}
.reading{
  text-align: center; 
  font-size:30px;
  letter-spacing: 8px;
}
</style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="logo.png" class="im">
  <a href="home.php">Home</a>
  <a href="upload.php" class="active">Upload Photo</a>
  <a href="bill.php">Download Bill</a>
  <a href="about.php">About Us</a>
  <a href="contact.php">Contact Us</a>
  <a href="meter.php">Add Meter</a>
  <div class="profile">
  <a href="profile.php"><img src="profile.png" class="profile"></a>
  </div>
</div>
<p class="heading" >Reading</p><hr>
<div>
  <?php
    $reading = $_SESSION['reading'];
    echo "<p class=\"reading\">$reading</p>";
  ?>
  <form name="f1" autocomplete="off" action="<?php $_PHP_SELF ?>" method="POST" >
    <input type="submit" name="btnSubmit" value="Confirm" class="btns"><br>
    <input type="submit" name="btnSubmit" value="Discard" class="btns">
  </form>
  <?php
    error_reporting(0);
    if($_POST['btnSubmit'] == "Confirm")
    {
      $photo_id = $_SESSION['photo_id'];
      $sql2 = "select photo from photo_temp where id = '$photo_id'";
      $res2 = mysqli_query($conn,$sql2);
      $result=$res2->fetch_assoc();
      $photo = $result['photo'];

      $sql3 = "insert into reading_history(reading,photo,status,customer_id,date_time) values('".$reading."','".base64_encode($photo)."','0','".$cid."',Now())";
      $res3 = $conn->query($sql3);
      $sql4="DELETE p.* FROM photo_temp p WHERE id IN (SELECT id FROM (SELECT id FROM photo_temp WHERE ID=(SELECT max(id) from photo_temp)) x)";
      $res4=$conn->query($sql4);
      if($res3)
      {
        echo '<script type="text/JavaScript">
                        alert("Reading updated successfully!")
                        location.replace("home.php")
                        </script>';
        die();
      }
      else
      {
        echo '<script type="text/JavaScript">
                        alert("Reading updated successfully!")
                        location.replace("home.php")
                        </script>';
          die();                 
      }
    }
    if($_POST['btnSubmit'] == "Discard")
    {
      $sql4="DELETE p.* FROM photo_temp p WHERE id IN (SELECT id FROM (SELECT id FROM photo_temp WHERE ID=(SELECT max(id) from photo_temp)) x)";
      $res4=$conn->query($sql4);
      header("Location: upload.php");
    }
  ?>
</div>
</body>
</html>