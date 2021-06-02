<?php
  session_start();
?>
<div>
  <?php
    $reading_id = $_GET['rid'];
    $customer_id = $_SESSION['cid'];
    include 'config.php';
    /* Attempt to connect to MySQL database */
    $conn= mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
         
    // Check connection
    if($conn === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    //Get Current Reading and Reading_id
    $sql1="SELECT reading,reading_id from reading_history where reading_id=(SELECT max(reading_id) from reading_history where customer_id='$customer_id')";
    $res1 = $conn->query($sql1);
    $reading_curr_arr = $res1->fetch_assoc();
    $reading_curr=$reading_curr_arr['reading'];
    $reading_id_curr=$reading_curr_arr['reading_id'];

    //Get Previous Reading and Reading_id
    $sql2 = "SELECT reading,reading_id from reading_history where reading_id<(select max(reading_id) from reading_history where customer_id='$customer_id') and customer_id='$customer_id' order by reading desc limit 1";
    $res2 = $conn->query($sql2);
    if(mysqli_num_rows($res2)==0)
    {
        $reading_id_prev=$reading_id_curr;
    }
    else
    {
        $reading_prev_arr = $res2->fetch_assoc();
    $reading_prev=$reading_prev_arr['reading'];
    $reading_id_prev=$reading_prev_arr['reading_id'];
    }
    //Get company_id
    $sql3="SELECT company_id from meter_master where customer_id='$customer_id'";
    $res3 = $conn->query($sql3);
    $company_id_arr = $res3->fetch_row();
    $company_id=$company_id_arr[0];

    //Calculating total units that are consumed
    $units=$reading_curr-$reading_prev;

    //Get gst and per_unit_charge
    $sql4="SELECT gst,per_unit_charge from company_master where company_id='$company_id'";
    $res4 = $conn->query($sql4);
    $company_details_arr = $res4->fetch_assoc();
    $gst=$company_details_arr['gst'];
    $per_unit_charge=$company_details_arr['per_unit_charge'];

    //Calculating amount_without_gst
    $amount_without_gst=$per_unit_charge*$units;

    //Calculating total_amount
    $total_amount=$amount_without_gst+($amount_without_gst*15)/100;

    //Inserting into bill_master
    $sql5 = "INSERT into bill_master(customer_id,company_id,curr_reading_id,prev_reading_id,units,amount_without_gst,total_amount,billing_date) values('$customer_id', '$company_id','$reading_id_curr','$reading_id_prev','$units','$amount_without_gst','$total_amount',Now())";
    $res5 = $conn->query($sql5);

    if($res5)
    {
      //Updating bill in reading_history
      $sql6 = "update reading_history set status = '1' where reading_id = '$reading_id'";
      $res6 = $conn->query($sql6);
    }
    header("Location: approve.php");
  ?>
</div>