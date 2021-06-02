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
  <a href="home_company.php">Home</a>
  <a href="approve.php">Approve Bill</a>
  <a href="reports.php">Reports</a>
  <a href="about_company.php">About Us</a>
  <a href="contact_company.php"  class="active">Contact Us</a>
  <div class="profile">
  <a href="profile_company.php"><img src="profile.png" class="profile"></a>
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
