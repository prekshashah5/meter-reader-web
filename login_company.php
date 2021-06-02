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
  			padding: 40px;
  			border-radius: 25px;
		}
		input.no-outline {
		  border-top-style: hidden;
		  border-right-style: hidden;
		  border-left-style: hidden;
		  border-bottom-style: hidden;
		  background-color: rgba(255,255,255,0);
		  margin:7px;
		  width: 87%;
		  height: 20px;
		  font-size: 13px;
		  text-align: center;
		}
		.no-outline:focus{
		  outline: none; 
		}
		div.field{
			border-radius: 2px;
			background-color: rgba(255,255,255,0.8);
			margin:10px;
		}
		input.searchbutton {
		  border-top-style: hidden;
		  border-right-style: hidden;
		  border-left-style: hidden;
		  border-bottom-style: hidden;
		  padding: 10px 15px 10px 15px;
		  font-family: Helvetica;
		  border-radius: 3px;
		  font-size: 13px;
		  text-align: center;
		  color: #301b3f;
		  width: 80%;
		  margin-left: 9.5%;
		  padding: 3%;
		  margin-top: 20px;
		  border-radius: 4px;
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
			font-size: 13px;
			padding-left: 5%;
		}
		a{
			color: black;
			font-size:13px;
		}
		h2{
			margin-left: 6%;
		} 
	</style>
	<title>Login Page</title>
</head>
<body>
	<div class="tbox">
		<h2>Company Login</h2>
		<?php
			if(isset($_POST['submit']))
			{
				session_start();
				include 'config.php';
						 
				/* Attempt to connect to MySQL database */
				$conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
						 
				// Check connection
				if($conn === false){
					die("ERROR: Could not connect. " . mysqli_connect_error());
				}

				$user= $_POST['username'];
				$_SESSION['user']=$user;
				$pass= $_POST['password'];
				$query= "select * from company_master where username = '$user' AND password = '$pass'";
				$result= mysqli_query($conn,$query);
				$count= mysqli_num_rows($result);
				if($count != 0){
					header("Location: home_company.php");
				}
				else{
					echo "<p style='color:red; margin-left:15px; font-size:13px;'>Username or Password incorrect</p>";
				}

			}
		?>   
		<form name="f1" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" >
			<label class="labels">Username:</label>
			<div class="field"><input type="text" name="username" class="no-outline" placeholder="Username"></div>
			<label class="labels">Password:</label>
			<div class="field"><input type="password" name="password" class="no-outline" placeholder="Password"></div>
			<input type="submit" name="submit" value="Login" class="searchbutton"><br><br>
		</form>
	</div>
</body>
</html>