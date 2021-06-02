<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="navigation.css">
<link rel="stylesheet" href="heading.css">
<style>
#file-chosen{
  margin-left: 5.5%;
  font-family: sans-serif;
}
.rules{
  text-align: center;
  font-size: 16px;
  font-weight: bold;
}
.rulebody
{
    text-align: center;
    font-size: 15px;
}

</style>
</head>
<body>
<div class="topnav" id="myTopnav">
  <img src="logo.png" class="im">
  <a href="home.php">Home</a>
  <a href="upload.php" class="active">Upload Photo</a>
  <a href="bill.php">Download Bill</a>
  <a href="about.php">About Us</a>
  <a href="contact.php">Contact Us</a>
  <a href="meter.php">Add Meter</a>
  <div class="profile">
  <a href="profile.php"><img src="profile.png" class="profile"></a>
  </div>
</div>
<div class="main">
<p class="heading" >Upload Photo</p><hr>
<p class="rules">Rules: </p>
    <p class="rulebody">File should not exceed 1MB<br>
    File should be png or jpg only<br>
  </p>    
<div class="tbox">
  <form action="<?php $_PHP_SELF ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="upload" hidden>
    <label for="upload" class="btns">&nbsp;&nbsp;Choose file&nbsp;&nbsp;</label>
    <br><br><span id="file-chosen">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No file chosen</span><br>
    <input type="submit" value="Upload Image" name="submit" class="btns"><br><br>
    <?php
      include 'config.php';
      if(isset($_POST['submit']))
      {
        /* Attempt to connect to MySQL database */
        $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                 
        // Check connection
        if($conn === false)
        {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        if($conn== true)
        {
            echo "connected";
        }
        $file = $_FILES['fileToUpload'];
        $filerr= $file['error'];
        $filesize= $file['size'];
        if($filerr != 4)
        {
          $filename = $conn -> real_escape_string($file['name']);
          $filext= $conn -> real_escape_string($file['type']);
          $fileContent = $conn -> real_escape_string(file_get_contents($file['tmp_name']));
          if(substr($filext,0,5)=="image")
          {
            if($filerr===0)
            {
              if($filesize<=10485760)
              {
                $username = $_SESSION['user'];
                $res = mysqli_query($conn,"select customer_id from customer_master where username = '$username'");
                $id = $res->fetch_assoc();
                $cid = $id["customer_id"];
                $sql = "INSERT INTO photo_temp(name,photo,customer_id) VALUES('$filename','$fileContent','$cid')";
                $res = $conn -> query($sql);
                if ($res != 0)
                {
                  $sql2 = "SELECT IFNULL(MAX(ID),0) AS MAX_ID FROM PHOTO_TEMP";
                  $res2 = mysqli_query($conn,$sql2);
                  $pid = $res2->fetch_assoc();
                  $photo_id = $pid["MAX_ID"];
                  echo $photo_id;
                  $myfile = fopen("myFile.txt", "w") or die("Unable to open file!");
                  fwrite($myfile, $photo_id);
                  fclose($myfile);
                  ob_start();
                  passthru('ocr.py');
                  $fh = fopen('output.txt','r');
                  $line = fgets($fh);
                  $_SESSION['photo_id'] = $photo_id;
                  $_SESSION['reading'] = $line;
                  header("Location: display_reading.php");
                }
                else
                {
                  echo "<p>There is some problem while uploading file, try again!</p>";
                }

              }
              else
              {
                echo "<p>File Size must be less then 10MB!</p>";
              }
            }
            else
            {
              echo "<p>File has error while uploading!</p>";
            }
          }
          else
          {
            echo "<p>File type invalid!</p>";
          }
        }
        else
        {
          echo "<p>Please choose file to upload!</p>";
        }
      }

    ?>
  </form>
</div>
</div>
<script>
const upload = document.getElementById('upload');

const fileChosen = document.getElementById('file-chosen');

upload.addEventListener('change', function(){
  fileChosen.textContent = this.files[0].name
})
</script>
<hr class="hr1">
</body>
</html>