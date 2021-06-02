<?php
  session_start();
  include 'config.php';     
  $user = $_SESSION['user'];
  /* Attempt to connect to MySQL database */
  $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  
  // Check connection
  if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }
  $result = mysqli_query($conn,"SELECT * FROM company_master WHERE username='$user'");
  $data = mysqli_fetch_assoc($result);

  $cname = $data["company_name"];
  $mobile = $data["mobile"];
  $email = $data["email"];

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="navigation.css">
<style>
  input{
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  }

  input[type=submit] {
    width: 40%;
    background-color: #00a7de;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin-left:  30%;
  }

  input[type=submit]:hover {
    background-color: white;
    color: #557A95;
  }
  .tbox{
    border-radius: 5px;
    padding: 20px;
  }

</style>
</head>
<body>

<div class="topnav" id="myTopnav">
  <img src="logo.png" class="im">
  <a href="home_company.php">Home</a>
  <a href="approve.php">Approve Bill</a>
  <a href="reports.php">Reports</a>
  <a href="about_company.php">About Us</a>
  <a href="contact_company.php">Contact Us</a>
  <div class="profile">
  <a href="profile_company.php"><img src="profile.png" class="profile"></a>
  </div>
</div>

<div class="tbox">
  <form name="f1" autocomplete="off" action="<?php $_PHP_SELF ?>" method="GET" >
    <div class="field"><input type="text" class="no-outline" name="cname" placeholder="Compnay name" required value="<?php echo "$cname"?>"></div><br>
    <div class="field"><input type="tel" class="no-outline" name="mobileno" placeholder="Mobile number" pattern="[0-9]{10}" required value="<?php echo "$mobile"?>"></div><br>
    <div class="field"><input type="Email" class="no-outline" name="em" placeholder="Email id" required value="<?php echo "$email"?>"></div><br>
    <input type="submit" name="btnSubmit" value="Edit" class="searchbutton"><br><br>
    <input type="submit" name="btnSubmit" value="Back To Profile" class="searchbutton"><br><br>
  </form>
</div>
<?php
      error_reporting(0);
      if($_GET['btnSubmit'] == "Edit")
      {
        $cname=$_GET['cname'];
        $uname=$_GET['username'];
        $mno=$_GET['mobileno'];
        $em=$_GET['em'];
        $sql="UPDATE company_master SET company_name='$cname',mobile='$mno',email='$em' WHERE username='$user'";

        if(mysqli_query($conn,$sql) === TRUE){
          echo '<script>alert("Details Updated Successfully!")</script>';
          ?>
          <META HTTP-EQUIV="Refresh" CONTENT="0; URL=http://localhost/project/profile.php#">
          <?php  
        }
        else{
          echo "<p>Something went wrong please try again!!!</p>";
        }
      }
      if($_GET['btnSubmit'] == "Back To Profile")
        header("Location: profile_company.php");
      
    ?>

</body>
</html>