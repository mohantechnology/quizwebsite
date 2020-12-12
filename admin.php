<?php 
session_start();

if(!isset($_SESSION["admin_db"]) || $_SESSION["admin_db"]==""){
   header("location:login.php");

}

if (isset($_REQUEST["logout"])) {
    $_SESSION["admin_db"] = "";
    session_destroy();
    header("location:login.php");
}
else if (isset($_REQUEST["insert"])) {
    // $_SESSION["admin_db"] = "";
    // session_destroy();
    header("location:insert_question.php");
}

else if(isset($_REQUEST["delete"])) {
    // $_SESSION["delete_db"] = $_REQUEST["delete"] ;
//    echo"delteed accountis:",$_SESSION["delete_db"];
    // header("location:delete.php");

    if(!isset($_SESSION["admin_db"]) || $_SESSION["admin_db"]==""){
        header("location:login.php");
     
     }
     include "table_detail.php"; 
    $user_db =  $_REQUEST["delete"];
 if ($conn->connect_error == "") {
     
    //  $sql = "DROP DATABASE quiz".$user_db;
    $num_row = 0;
    $sql = "SELECT *  FROM $user_db"."test_detail";
    // echo "<br>".$sql;
    $name= "";
     $name =  $conn->query($sql);
     
    if($name != "" ){
        $num_row = $name->num_rows;
        
        // echo "deleted from first detail ";
        $sql = "DROP TABLE $user_db"."test_detail";
        // echo "<br>".$sql;
        $name= "";
         $name =  $conn->query($sql);
         
       if($name != "" ){
           for($i =1; $i<=$num_row; $i++){
            $sql = "DROP TABLE $user_db"."test_no".$i;
            // echo "<br>".$sql;
            $name =  $conn->query($sql);
         
            if($name != "" ){
                // echo "succesfullly delted table no $i";
           }
        }
    }
}
    else{
        // echo "not able to delete first ";
        // echo $conn->error;
    }


     // echo "user name =->>", $name;
     $conn->close();
 } else {
    //  echo "not able to take out name ";
    //  echo $conn->connect_error;
 }
  include "conn_detail.php"; 
 if ($conn->connect_error == "") {
 
    $sql = "DELETE FROM user_detail WHERE mobile_no=".  $user_db;
    $name =  $conn->query($sql);
    // echo "query result is".$name;
    
    // echo "user name =->>", $name;
    $conn->close();
} else {
    // echo "not able to take out name ";
    // echo $conn->connect_error;
}
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administator</title>
    <link rel="icon" href="favicon.png" type="image/x-icon">
</head>

<style>
    body {

        color: white;
        /* background-color: rgb(34, 34, 34); */
        margin: 0px;
        background-color: rgb(15, 37, 37);
        font-size: 20px;
    }

    #header {
        height: 60px;
        background-color: rgb(19, 16, 16);
    }

    #welcome {
        /* position: relative; */
        /* background-color: blue; */
        position: absolute;
        padding: 20px;
    }

    #top_buttons {
        position: absolute;
        right: 3px;
        padding: 20px;
        /* background-color: blue; */
    }

    button {
        background-color: rgb(30, 30, 32);
        padding: 5px;
        margin-bottom:10px;
        color:whitesmoke;
    }

    button:hover {
        background-color: rgb(88, 88, 88);
    }

    #first_form {
        /* background-color: teal; */
        height: 50px;
    }

    #test_box {
        height: 40px;
        background-color: rgb(15, 37, 37);
        /* text-align:center; */
        width: 97%;
        margin: auto;
        padding:10px;
        margin-top: 15px;
        border-style: solid;
        border-color: rgb(148, 126, 126);
        border-radius: 2px;
        border-width: 0.1px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        /* height: 10%; */
        font-size:smaller;
    
    }

    #test_box:hover {
        background-color: rgb(34, 46, 46);
    }

    #test_no {
        width:50%;
        /* text-align: center; */
       /* word-wrap:normal; */
    
       /* height: 100px; */
    }
    .s1{
        width: 20%;
    }
    .s2{
        text-align:center;
    }

    
    @media screen and (min-width:1200px){
       .detail_box {
            width:1000px; 

            border:1px solid white; 
            /* height:fit-content;  */
            /* height:1000px;  */
            min-height:800px; 
            padding:20px;
            margin:10px auto;  
        }
     
        

        
 
    }

    @media screen and (max-width :900px){
        .detail_box {
          font-size:15px; 
        }
 
    }


    @media screen and (max-width :700px){
        .detail_box {
          font-size:13px; 
        }
 
    }

    
    @media screen and (max-width :600px){
        .detail_box {
          font-size:10px; 
        }
 
    }


    @media screen and (max-width :500px){
      .test_box #test_no{
      width:40%;
        }
 
    }
    @media screen and (max-width :400px){
        .test_box {
      font-size:8px; 
        }
 
    }

</style>

<body>

    
    <div id="header">
        <form id="first_form" >
            <span id="welcome">User Details</span>
            <span id="top_buttons">
            <button id="update"  type=submit name="insert">Insert Question</button>
                   
            <button id="logout" type=submit name="logout">Log Out</button>

            </span>

        </form>
    </div>
  <div class="detail_box">
  
  <div id="test_box" style="font-size:20px">
        <span  style=" text-align:left" class ="s1">Account No.</span>
        <span  class ="s1" >User Name</span>
        <span  class ="s1">Mobile No.</span>
        <span  class ="s1">Password</span>
        <span    class ="s1">Email</span>
        <span   style=" text-align:right" " class ="s1" >Action</span>
    </div>



    <?php
     
    

    
     echo"<form method ='POST' >";
     
    // $conn1 = new mysqli("localhost","root","",$user_db);
 include "conn2_detail.php"; 
     if($conn2->connect_error !=""){
        // echo "<br> connection error for 2nd ";
        // echo $conn2->connect_error;
        die("not able to connect ");
    }

  
        $sql = "SELECT * FROM user_detail";
        $result1 ="";
    $result1 = $conn2->query($sql);
        if($result1!=""){
            $count=1;
            while($row = $result1->fetch_assoc()){
                // $date= $row["date"];
                // $test_no= $row["test_no"];
                // $score= $row["score"];
                // $time= $row["time"];
                echo ' <div id="test_box" >
                <span   class ="s1" >  '.$count++.'  </span>
                <span class ="s1" >  '.$row["name"].'  </span>
                <span class ="s1" >  '.$row["mobile_no"].'   </span>
                <span class ="s1" >  '.$row["password"].'  </span>
                <span class ="s1" >  '.$row["email"].'  </span>
             <span class ="s1" style="text-align:right;"> <button  type="submit" name="delete" value="'.$row["mobile_no"].'">Delete</button>  </span>
         
                  </div>';
                
                 
            }
     $conn2->close();
 

    }
    else{
        // echo "not able to fetch";
    }
    
echo"</form>";

?>
  
  </div>





</body>

</html>
