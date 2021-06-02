<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="navigation.css">
<link rel="stylesheet" href="heading.css">
<style>

input[type=submit] {
  width: 100%;
  background-color: #00a7de;
  color: white;
  padding: 14px 20px;
  margin: 0px 0px 0px 5px;
  border: none;
  border-radius: 3%;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: white;
  border: 1px solid #557A95;
  color: #00a7de;
}

select{
  padding: 5%;
  margin: 10% 3%;
  width: 100%;
  background-color: #00a7de;
  color: white;
  border-radius: 3%; 
}

select:focus{
  border-style: none;
}

div.tbox1{
  border: 1px solid #ffb602;
  position: absolute;
  color: #301b3f;
  top: 60%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 50px;
  border-radius: 3%;
  z-index: -1;
}
</style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="logo.png" class="im">
  <a href="home.php">Home</a>
  <a href="upload.php">Upload Photo</a>
  <a href="bill.php">Download Bill</a>
  <a href="about.php">About Us</a>
  <a href="contact.php">Contact Us</a>
  <a href="meter.php" class="active">Add Meter</a>
  <div class="profile">
  <a href="profile.php"><img src="profile.png" class="profile"></a>
  </div>
</div>
<p class="heading" >Add Meter</p><hr>
<div class="tbox1">
    
    <form name="f1" autocomplete="off" action="<?php $PHP_SELF ?>" method="POST">
        <select name="company" id="company">
          <option value="default">Select Company</option>
          <?php
              include 'config.php';
                   
                /* Attempt to connect to MySQL database */
              $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
              
                // Check connection
              if($conn === false){
                die("ERROR: Could not connect. " . mysqli_connect_error());
              }
              $result = mysqli_query($conn,"SELECT company_name FROM company_master");
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<option value=".$row["company_name"].">".$row["company_name"]."</option>" ;
                }
              }
          ?>   
        </select>
      <input type="submit" name="create" value="Create" class="searchbutton"><br><br>
      <?php
        if(isset($_POST['create']))
        {
          if($_POST['company'] == "default")
          {
            echo "<p style='color:red; margin-left:20px;'>Please select a company</p>";
          }
          else
          {
            $select = $_POST['company'];
            $sql1 = "select company_id from company_master where company_name='$select'";
            $res1 = mysqli_query($conn,$sql1);
            $cid = $res1->fetch_assoc();
            $id = $cid["company_id"];

            $username = $_SESSION['user'];
            $sql2 = "select customer_id from customer_master where username='$username'";
            $res2 = mysqli_query($conn,$sql2);
            $cust_id = $res2->fetch_assoc();
            $customer_id = $cust_id["customer_id"];

            $sql = "insert into meter_master values('','$customer_id','$id')";
            $res3 = mysqli_query($conn,$sql);
            if($res3)
            {
              echo "<p style='color:blue; margin-left:20px;'>Added successfully</p>";
            }
            else
            {
              echo "<p style='color:red; margin-left:20px;'>Try again!!</p>";
            }
          }
        }
      ?>
    </form>
  </div>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
</script>

</body>
</html>
