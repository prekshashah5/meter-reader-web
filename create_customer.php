<html>
<head>
	<style>
		body{
			background-image: url("4.jpg");
			background-size: 100% 100%;
			position: relative;
			font-family: Arial,Helvetica,sans-serif;
		}
		div.tbox{
			background-color: rgba(250,250,250,0.6);
			position: absolute;
			color: #301b3f;
 			top: 50%;
 			left: 50%;
  			transform: translate(-50%, -50%);
  			padding: 1%;
  			padding-left: 3%;
  			padding-right: 8%;
  			border-radius: 25px;
		}
		input.no-outline {
		  border-top-style: hidden;
		  border-right-style: hidden;
		  border-left-style: hidden;
		  border-bottom-style: hidden;
		  background-color: rgba(255,255,255,0);
		  margin:5px;
		  width: 100%;
		  height: 20px;
		  font-size: 13px;
		  text-align: center;
		}
		.no-outline:focus{
		  outline: none; 
		}
		div.field{
			border-radius: 4px;
			background-color: rgba(255,255,255,0.8);
			margin: 10px;
			width: 120%;
		}
		input.searchbutton {
		  border-top-style: hidden;
		  border-right-style: hidden;
		  border-left-style: hidden;
		  border-bottom-style: hidden;
		  font-family: Helvetica;
		  border-radius: 3px;
		  font-size: 13px;
		  text-align: center;
		  color: #301b3f;
		  width: 80%;
		  margin-left: 23%;
		  padding: 3%;
		  margin-top: 20px;
		}
		.searchbutton:hover{
			color: black;
			cursor: pointer;			
			box-shadow: 0 0 2px black; 
		}
		.searchbutton:focus {
			outline-color: gray;
		}
		.labels
		{
			font-size:13px;
			padding-left: 6%;
		}
		a{
			color: black;
			font-size:13px;
		} 
		h2
		{
			margin-left: 50px;
		}
	</style>
<title>Login Page</title>
</head>
<body>
	<div class="tbox">
		<h2>Create Account</h2>
		<?php
			if(isset($_POST['create']))
			{
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$email = $_POST['email'];
				$mno = $_POST['mobileno'];
				$username = $_POST['uname'];
				$password = $_POST['password'];

				include 'config.php';
			       
			    /* Attempt to connect to MySQL database */
			    $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
			  
			    // Check connection
			    if($conn === false){
			    	die("ERROR: Could not connect. " . mysqli_connect_error());
			    }
			    $result = mysqli_query($conn,"SELECT * FROM customer_master WHERE username='$username'");
			    $row = mysqli_num_rows($result);

			    if($row>0)
			    	echo "<p style='color:red; margin-left:15px;'>Username not available</p>";
			    else
			    {
			    	$sql = "insert into customer_master(username,f_name,l_name,mobile,email,password) values('$username','$fname','$lname','$mno','$email','$password')";
			    	$res = mysqli_query($conn,$sql);
			    	if($res)
			    	{
			    		session_start();
			    		$_SESSION['user'] = $username;
			    		header("Location: add_meter.php");
			    	}
			    }

			}
		?>   
		<form name="f1" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
			<label class="labels">First Name:</label>
			<div class="field"><input type="text" name="fname" class="no-outline" placeholder="First Name"></div>
			<label class="labels">Last Name:</label>
			<div class="field"><input type="text" name="lname" class="no-outline" placeholder="Last Name"></div>
			<label class="labels">Username:</label>
			<div class="field"><input type="text" name="uname" class="no-outline" placeholder="Username"></div>
			<label class="labels">Email:</label>
			<div class="field"><input type="email" name="email" class="no-outline" placeholder="Email ID"></div>
			<label class="labels">Mobile number:</label>
			<div class="field"><input type="number" name="mobileno" class="no-outline" placeholder="Mobile Number"></div>
			<label class="labels">Password:</label>
			<div class="field"><input type="password" name="password" class="no-outline" placeholder="Password"></div>
			<input type="submit" name="create" value="Create" class="searchbutton"><br><br>
		</form>
	</div>
</body>
</html>