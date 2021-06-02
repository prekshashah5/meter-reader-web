<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="heading.css">
<link rel="stylesheet" href="navigation.css">
<style>
.sub
{
  text-align: center;
  font-size: 20px;
  padding-top:1%;
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
  <a href="contact.php" class="active">Contact Us</a>
  <a href="meter.php">Add Meter</a>
  <div class="profile">
  <a href="profile.php"><img src="profile.png" class="profile"></a>
  </div>
</div>

<p class="heading">Contact Us</p>
  <hr>
  <p class="sub">It will be our greatest pleasure to help you.<br>
  Drop an email on meterreader@gmail.com <br>Call us on 904943899</p>
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
