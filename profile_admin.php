<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="navigation.css">
<style>
  input[type=submit] {
    width: 100%;
    background-color: #00a7de;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 3%;
    cursor: pointer;
  }

  input[type=submit]:hover {
    background-color: white;
    border: 1px solid #00a7de;
    color: #00a7de;
  }
  .tbox{
    border: 1px solid #ffb602;
    position: absolute;
    color: #301b3f;
    top: 50%;
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
  <a href="home_admin.php">Home</a>
  <div class="profile">
  <a href="profile_admin.php"><img src="profile.png" class="profile"></a>
  </div>
</div>

<div class="tbox">
  <form name="f1" autocomplete="off" action="<?php $_PHP_SELF ?>" method="POST" >
      <input type="submit" name="btnSubmit" value="Logout" class="searchbutton"><br><br>
    </form>
</div>
<?php
      error_reporting(0);
      if($_POST['btnSubmit'] == "Logout")
        header("Location: login.php");
    ?>

</body>
</html>