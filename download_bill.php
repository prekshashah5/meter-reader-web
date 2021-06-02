<?php
            $bill_id = $_GET['bill_id'];
            session_start();      
            include 'config.php';
            $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
            // Check connection
            if($conn === false){
              die("ERROR: Could not connect. " . mysqli_connect_error());
            }
            $username = $_SESSION['user'];
            $res = mysqli_query($conn,"select customer_id from customer_master where username = '$username'");
            $id = $res->fetch_assoc();
            $cid = $id["customer_id"];
            $sql3 = "select customer_id,username,f_name,l_name,mobile,email from customer_master where customer_id='$cid'";
            $res3 = $conn->query($sql3);
            $row = $res3->fetch_row();
            echo $bill_id;
            $file = fopen("bill_details.txt","w");
            foreach ($row as $line) 
            {
                $txt=$line."\n";
                fwrite($file, $txt);
            }
            fwrite($file, $bill_id);
            ob_start();
            passthru('bill_generate.py');
            $filename="Bill.pdf";
            $file="$filename";
            $len = filesize($file); // Calculate File Size
            ob_clean();
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: public"); 
            header("Content-Description: File Transfer");
            header("Content-Type:application/pdf"); // Send type of file
            $header="Content-Disposition: attachment; filename=$filename;"; // Send File Name
            header($header );
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ".$len); // Send File Size
            @readfile($file);
            exit;
?>