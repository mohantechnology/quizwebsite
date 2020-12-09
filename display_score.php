<?php session_start();


if(!isset($_SESSION["user_db"])  || $_SESSION["user_db"] ==""){
   header("location:login.php");
}
// echo print_r($_SESSION); 
 if(isset($_REQUEST["value"])){
      
        $_SESSION["test_no"] = $_REQUEST["value"];
        // echo "test no is: ", $_SESSION["test_no"];
 }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
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

 

    button {
        background-color: rgb(30, 30, 32);
        padding: 5px;
        margin-bottom:10px;
        width:100px;
         color:whitesmoke ;
    }

    button:hover {
        background-color: rgb(88, 88, 88);
    }

    #first_form {
        /* background-color: teal; */
        height: 50px;
    }

  #test_box {
        /* height: 40px; */
        background-color: rgb(15, 37, 37);

        width: 98%;
        margin: auto;
        padding:5px;

        margin-top: 15px;
       /* overflow-wrap:break-word; */
        border-style: solid;
        border-color: rgb(148, 126, 126);
        border-radius: 2px;
        border-width: 0.1px;
        display: flex;
        align-items: center;
        justify-content: space-around;


  /* text-align:center; */
    }

 

    #last_form {
       
        margin: auto;
        margin-top: 20px;
        padding:10px;     
    
    }
    a{
        text-decoration: none;
        color:white;        
    }
    #test_no {
        width:50%;
        /* text-align: center; */
       /* word-wrap:normal; */
    
       /* height: 100px; */
    }


    @media screen and (min-width:1200px){
       .detail_box {
            width:1000px; 

            border:1px solid white; 
            /* height:fit-content;  */
            /* height:1000px;  */
            padding:20px;
            margin:10px auto;  
        }
        #back_button{
            
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
        
            <span id="welcome"> Test No. <?php echo $_SESSION["test_no"];?></span>
            <span id="top_buttons">
             
            </span>


    </div>


  <div class="detail_box">
  
  <div id="test_box" class="test_box">
        <span style="padding-left:4px;"> Q. No.</span>
        <span align =center id="test_no">Description</span>
        <span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Marked Answer</span>
        <span >Correct Answer</span>
        <span >Decision&nbsp;</span>

    </div>



    <?php
 
    if(!isset($_SESSION["test_no"])){
        header("location:profile.php");
    }
    
    $test_no = $_SESSION["test_no"];
    $user_db = "epiz_26105613_quiz_table";
    $total_mark =0;
    $wrong_attempt =0;
    //  echo "user db =",$user_db;
      include "table_detail.php"; 
      $conn1 = $conn; 
   
     include "conn2_detail.php"; 

    
    if($conn2->connect_error !=""){
        echo "<br> connection error for 2nd ";
        echo $conn2->connect_error;
        die("not able to connect ");
    }
    if($conn1->connect_error ==""){
        // echo " connected";
        // echo $user_db;
  
        $sql = "SELECT * FROM ".$_SESSION["user_db"]."test_no".$test_no;
        $result1 ="";
        $result1 = $conn1->query($sql);

        // print_r($result);    
        // echo "result is:",$result;
        if($result1!=""){
         
            while($row = $result1->fetch_assoc()){
                // $date= $row["date"];
                // $test_no= $row["test_no"];
                // $score= $row["score"];
                // $time= $row["time"];
                echo ' <div id="test_box">
                <span > '.$row["question_no"].' </span>';
                 
        $sql = "SELECT * FROM question_answer WHERE id= ".$row["question_id"];
        // echo "<br>squl is: ",$sql;
        $result2 ="";
        $result2 = $conn2->query($sql);
        // echo "<r><br><br>";
        if($result2=="" || $result2->num_rows == 0 ){
            echo "<br> not able to fetch the question ";
            // die("eroor fetching data ");
            echo $conn2->connect_error;
        }  
        $result2 = $result2->fetch_assoc();     
        if($row["answer"] =="" ){
            $row["answer"]=" ' ' ";
        }
        echo'  <span  id="test_no">'.$result2["question"].'</span>
                <span id="time"> '.$row["answer"].'&nbsp;&nbsp;&nbsp; </span>
                <span id="score"> '.$result2["answer"].'</span>
                <span id=marks">';
        if($result2["answer"] == $row["answer"]) 
         {
             echo"Correct" ;
             $total_mark ++;
        }
        else{
            echo "Wrong";
            // echo"-".$row["answer"] ."-";
            if($row["answer"]!=" ' ' ") {
                // echo"(o-o)";
                $wrong_attempt ++;
            }
          
        } 
        echo '</span> </div>'    ;
            }
        }
    //  $result = $conn->query($sql);

    $sql = "UPDATE ".$_SESSION["user_db"]."test_detail SET score=".(5*$total_mark)." WHERE test_no =".$test_no;
//    echo"<br>".  $sql;
 
    if($conn1->query($sql)===TRUE){
        // echo"updated successfullly";
    }
    else{
        // echo "Not able to update";
    }
    $conn2->close();
     $conn1->close();

    }
    else{
        echo "not able to coneect";
    }
    
  echo'  <br><hr><div id="test_box" style="justify-content:space-around;font-size:30px"  >
  <span >Result</span>

</div>';

echo'  <div id="test_box"   >

  <span  >Correct Attempts </span>
  <span >Wrong Attempts </span>
  <span >Total Attempts  </span>
  <span >Total Question  </span>
  <span > Marks obtain  </span>
  <span >  Total Marks  </span>
</div>';

echo'  <div id="test_box" style="text-align:center ;" >

<span  > '.$total_mark.'</span>
<span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'. ($wrong_attempt).' </span>
<span > '.($wrong_attempt + $total_mark).'  </span>
<span >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 10 </span>

<span > '. 5 *$total_mark.'  </span>
<span >  50  </span>


</div>';
?>



    <form  id="last_form" action="profile.php">
        <button type="submit" id="back_button"> Back </button>
    </form>
  
  </div>
   
<script>
sessionStorage.removeItem("count");
</script>

</body>

</html>
