<?php
session_start();

$user_db = "";
if (     isset($_REQUEST["take_test"])) {

    header("location:test.php");
}



// if (isset($_REQUEST["user_db"])) {
//     // echo "-->>", $_SESSION["user_db"];
// }


$name = "";

if (isset($_REQUEST["logout"])) {
    $_SESSION["user_db"] = "";
   if( $_SESSION["admin_db"]!="")
    session_destroy();
    header("location:login.php");
}
// $_SESSION["user_db"]="";
// echo "testing session";
if (isset($_SESSION["quiz_data"]) && $_SESSION["quiz_data"] != "") {
 $_SESSION["user_db"] = $_SESSION["quiz_data"];
 $user_db =  "quiz". $_SESSION["user_db"] ;
//    echo "user db set to ",$user_db;
    $_SESSION["quiz_data"] = "";
}
else if(isset($_SESSION["user_db"]) && $_SESSION["user_db"]!=""){
    $user_db =  "quiz". $_SESSION["user_db"] ;
}

if (isset($_SESSION["user_db"]) != 1  || $_SESSION["user_db"] === "") {
    header("location:login.php");
} else {
    // $temp = "mohan";
   
    $mobile_no  =  $_SESSION["user_db"];
    include "conn_detail.php"; 
  
    if ($conn->connect_error == "") {
        $sql = "SELECT name FROM user_detail WHERE mobile_no ='$mobile_no'";
        $name =  $conn->query($sql)->fetch_assoc()["name"];
        // echo "user name =->>", $name;
        $conn->close();
    } else {
        echo "not able to take out name ";
    }
    // echo "user name =->>",$name;

}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<style>
    body {

        color: white;
        /* background-color: rgb(34, 34, 34); */
        margin: 0px;
        background-color: rgb(15, 37, 37);
        font-size: 20px;
        /* width:900px;  */
        /* margin:auto; */
    }

    #header {
        height: 60px;
        background-color: rgb(19, 16, 16);
        position :relative; 
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

        width: 90%;
        margin: auto;
        /* padding:5px; */
        margin-top: 15px;
      
        border-style: solid;
        border-color: rgb(148, 126, 126);
        border-radius: 2px;
        border-width: 0.1px;
        display: flex;
        align-items: center;
        justify-content: space-around;

  text-align:center;
    }

    #test_box:hover {
        background-color: rgb(34, 46, 46);
    }

    #last_form {
        width: 90%;
        /* background-color: blue; */
        margin: auto;
        margin-top: 20px;
        text-align: center
    }
    a{
        text-decoration: none;
        color:white;        
    }

    .s1{
        /* padding-left:40px; */
        width: 20%;
    }

    #logout{
        padding:5px; 
    }
    @media screen and (min-width:1200px){
       .detail_box {
            width:1000px; 
            margin:auto; 
            /* border:2px solid white;  */
        }
        

    }


    @media screen and (max-width :800px){
 
        button{
            display:inline-block; 
            width:100%;
            padding:5px 0px; 
         
        }

    }



    @media screen and (max-width :570px){
        .detail_box {
           font-size:17px; 
        }
       

    }
    
    @media screen and (max-width :490px){
        .detail_box {
           font-size:13px; 
        }

        #test_box {

        width: 98%;
        justify-content:space-between ; 
    }
    #welcome {
          font-size:15px; 
      }
      button{
    
            width:105%;
            position:relative; 
            left:-10px; 
         
        }

    }

   
</style>

<body>
 
    <div id="header">
        <form id="first_form">
            <span id="welcome">Welcome <?php echo $name ?></span>
            <span id="top_buttons">
                <!-- <button id="update" hidden type=submit name="update">Update Profile</button> -->
                <button id="logout" type=submit name="logout">Log Out</button>

            </span>

        </form>
    </div>
<div class="detail_box">




    <div id="test_box">
        <span class="s1" id="test_no">Test No</span>
        <span class="s1" id="date">Date</span>
        <span class="s1" id="time">Time</span>
        <span class="s1" id="score">Score </span>
        <span class="s1" id="mark">Total Marks<span>

    </div>
    <?php
    // $user_db = "quiz".$_SESSION["user_db"];
    //  echo "user db =",$user_db;
     echo '<form>';
    
     include "table_detail.php"; 
    if($conn->connect_error ==""){

        // echo " connected";
        // echo $user_db;
        $date ; $time ;$test_no;$score;
        $sql = "SELECT * FROM ".$mobile_no."test_detail";
        $result ="";
        $result = $conn->query($sql);
        // print_r($result);    
        // echo "result is:",$result;
        if($result!=""){
            while($row = $result->fetch_assoc()){
                $date= $row["date"];
                $test_no= $row["test_no"];
                $score= $row["score"];
                $time= ($row["time"]);
                $temp1 =($time)%60;
                $str1=$temp1<10? '0'.$temp1:$temp1;
                 $time =(($time)/60);
                //  echo "time=".$time;
                 $temp1 =($time + 30 )%60;
                 $str1=  ($temp1<10? '0'.$temp1:$temp1).":". $str1;
                 $time =($time)/60;
                 $temp1 =($time+12-5)%24  ;
                 $str1=  ($temp1<10? '0'.$temp1:$temp1).":". $str1;
                echo ' <a href =display_score.php?value='.$test_no.'> <div id="test_box">
                <span  class="s1" id="test_no">'.$test_no.'</span>
                <span  class="s1" id="date">'.$date.'</span>
                <span  class="s1" id="time">'.$str1.'</span>
                <span  class="s1" id="score">'.$score.' </span>
                <span  class="s1" id=marks">50</span>
        
            </div></a>'    ;
            }
        }
    //  $result = $conn->query($sql);
     $conn->close();

    }
    else{
        echo "not able to coneect";
    }
    
     echo '</form>';
?>

    <form id=last_form>
        <button type="submit" name="take_test">Start New Test</button>
    </form>

    </div>
</body>

</html>