<?php
  session_start();
?>
<html>
<head>
  <style>
    body{
      background-image: url("4.jpg");
      background-size: 100% 100%;
      position: relative;
      font-family: sans-serif;
    }
    div.tbox{
      background-color: rgba(250,250,250,0.5);
      position: absolute;
      color: #301b3f;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      border-radius: 25px;
    }
    input.no-outline {
      border-top-style: hidden;
      border-right-style: hidden;
      border-left-style: hidden;
      border-bottom-style: hidden;
      background-color: rgba(255,255,255,0);
      width: 87%;
      height: 30px;
      font-size: 16px;
      text-align: center;
    }
    .no-outline:focus{
      outline: none; 
    }
    input.searchbutton {
      border-style: hidden;
      padding: 10px;
      font-family: Helvetica;
      border-radius: 3px;
      font-size: 14px;
      text-align: center;
      color: #301b3f;
      margin-left: 35%;
      margin-top: 7%;
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
    select{
      border-style: hidden;
      padding: 10px;
      font-family: Helvetica;
      border-radius: 3px;
      font-size: 14px;
      text-align: center;
      color: #301b3f;
      float: center;
      margin-left: 15%;
      margin-top: 7%;
    }
  </style>
  <title>Login Page</title>
</head>
<body>
  <div class="tbox">
    <h1 style="text-align: center;">Add Meter</h1>
    
    <form name="f1" autocomplete="off" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
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

            $sql = "insert into meter_master(customer_id,company_id) values('$customer_id','$id')";
            $res3 = mysqli_query($conn,$sql);
            if($res3)
            {
              header("Location: home.php");
            }
            else
            {
              "<p style='color:red; margin-left:20px;'>Try again!!</p>";
            }
          }
        }
      ?>
    </form>
  </div>
</body>
</html>