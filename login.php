<html>
<head>
	<style>
		body{
			background-image: url("4.jpg");
			background-size: 100% 100%;
			position: relative;
			font-family: sans-serif;
			font-size: 11px;
		}
		.tbox{
			background-color: rgba(250,250,250,0.5);
			position: absolute;
			color: #301b3f;
 			top: 50%;
 			left: 50%;
  			transform: translate(-50%, -50%);
  			padding: 3.5%;
  			border-radius: 25px;
		}
		
		input.searchbutton {
		  border-top-style: hidden;
		  border-right-style: hidden;
		  border-left-style: hidden;
		  border-bottom-style: hidden;
		  padding: 10px;
		  border-radius: 3px;
		  text-align: center;
		  color: #301b3f;
		  margin-top: 5%;
		  margin-left: 3%;
		}
		.searchbutton:hover{
			color: black;
			cursor: pointer;			
			box-shadow: 0 0 2px black; 
		}
		.searchbutton:focus {
			outline-color: gray;
		}
		a{
			color: black;
		} 
		@media only screen and (max-width: 600px) {
		   .tbox{
		   	width: 100%;
		   	height: 100%;
		   }
		}
	</style>
	<title>Login Page</title>
</head>
<body>
	<div class="tbox">
		<h1>Meter Reader</h1>   
		<form name="f1" autocomplete="off" action="<?php $_PHP_SELF ?>" method="POST" >
			<input type="submit" name="btnSubmit" value="Login As Customer" class="searchbutton"><br><br>
			<input type="submit" name="btnSubmit" value="Login As Company" class="searchbutton"><br><br>
			<input type="submit" name="btnSubmit2" value="&nbsp;&nbsp;&nbsp;Login As Admin&nbsp;&nbsp;&nbsp;" class="searchbutton"><br><br>
			<center><a href="create_customer.php">Create account</a></center>
		</form>
		<?php
			error_reporting(0);
			if($_POST['btnSubmit'] == "Login As Customer")
				header("Location: login_customer.php");
			if($_POST['btnSubmit'] == "Login As Company")
				header("Location: login_company.php");
			if($_POST['btnSubmit2'])
				header("Location: login_admin.php");
		?>
	</div>
</body>
</html>