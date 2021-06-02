<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="heading.css">
<link rel="stylesheet" href="navigation.css">
<style>
.display {
	margin-top: 3%;
	width: 30%;
	display: block;
	margin-left: auto;
	margin-right: auto;
  border-radius: 2%;
}
.sub
{
  text-align: center;
  font-size: 16px;
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
  <a href="about.php" class="active">About Us</a>
  <a href="contact.php">Contact Us</a>
  <a href="meter.php">Add Meter</a>
  <div class="profile">
  <a href="profile.php"><img src="profile.png" class="profile"></a>
  </div>
</div>

<div>
  <p class="heading">About Us</p>
  <hr>
  <img src="about.jpg" class="display">
  <p class="sub">This website extracts reading from the image you capture and generates bill 
  	accordingly. We will be providing payment gateway soon.<br> <b>Making life easier</b></p>
</div>
</body>
</html>
