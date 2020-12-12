<?php



session_start();

if (isset($_SESSION["user_db"]) != TRUE) {
    echo "<br>" . "->>>user not logined";
    header("location:login.php");
} 

if (isset($_SESSION["user_db"]) != 1  || $_SESSION["user_db"] === "") {
    header("location:login.php");
}

 

else if (isset($_REQUEST["submit"])) {
    $_SESSION["question_no"] =-1;

    
    header("location:display_score.php");
} else if (isset($_REQUEST["next"])) {
    $_SESSION["prev_no"] =   $_SESSION["question_no"];
    $_SESSION["question_no"]  = ($_SESSION["question_no"]% 10 ) + 1;

} else if (isset($_REQUEST["prev"])  ) {

    $_SESSION["prev_no"] =   $_SESSION["question_no"];
    $_SESSION["question_no"]  = ($_SESSION["question_no"] - 1);
    if ($_SESSION["question_no"]  == 0) {
        $_SESSION["question_no"] = 10;
    }
} else {

    if (isset($_SESSION["user_db"]) != TRUE) {
        echo "<br>" . "->>>user not logined";
        header("location:login.php");
    } 
  
    else {
        // echo "<br>" . "<br> current user is : " . $_SESSION["user_db"] . "<br>";
    }
    // $user_db = "epiz_26105613_quiz_table";
    // echo "<br>" . "<br> user db is:-> ", $user_db;
     include "table_detail.php"; 
    if ($conn->connect_error == "") {
        //  $sql = "CREATE DATABASE $user_db";
        $sql = "SELECT * FROM ".$_SESSION["user_db"]."test_detail";
        // echo"<br>"."query is: ".$sql;
        $result = $conn->query($sql);
        if ($result != "") {
            $row = $result->num_rows + 1;
            $_SESSION["test_no"] = $row;
            // echo "<br>" . "<br>total no of row is: ", $row;
            $sql = "CREATE TABLE ".$_SESSION["user_db"]."test_no$row ( question_no INT AUTO_INCREMENT PRIMARY KEY, question_id INT , answer VARCHAR(2))";
            // echo "<br>" . "<br>query is: " . $sql;
            if ($conn->query($sql) === TRUE) {
                // echo "<br>" . "<br>created test_no$row ";
                $str = date("Y-m-d");
                $str = substr($str, 8, 2) . "/" . substr($str, 5, 2) . "/" . substr($str, 0, 4);
                $time = time();
                $sql = "INSERT INTO  ".$_SESSION["user_db"]."test_detail (date,time) values('$str','$time')";
                // echo "<br>" . "query isof ->>: " . $sql;
                $num_row = 20;
                if ($conn->query($sql) === TRUE) {
                    // echo "<br>" . "new row inserted ";
                         include "conn3_detail.php"; 
                        // print_r($conn3); 
                    if ($conn3->connect_error == "") {
                        $sql3 =  "SELECT * FROM  question_answer  " ;
                        // echo "echoing".$conn3->query("SELECT * FROM  user_detail  WHERE 1" )."end"; 
                        $result = $conn3->query($sql3 );
                        // echo " result is: <br> "; 
                        //  print_r($result);
                        if ($result != "" && $result->num_rows != 0) {
                            // $row = $result->fetch_assoc();
                          global $num_row ; 
                          $num_row  = $result->num_rows;
                        //   echo "1  numb row is : <br> '; "; 
                        //   echo  $num_row; 
                        }    

                        // print_r($conn);
                        $conn3->close();
                    
                    }
                    // echo "2 numb row is : <br> '; "; 
                    // echo  $num_row; 
                    $count = $num_row + 1 ;

                    $array = [];
                    while ($count--) {
                        $array[$count] = "";
                    }
                    $count = 10;
                    // echo"<br>". "<-->br>" . $array[0];
                    while ($count--) {
                        $random = (rand() % $num_row) + 1;
                        
                             
                        while ($array[$random] != "") {
                            $random = rand() % 20 + 1;
                        }
                        $array[$random] = "r";

                        $sql = "INSERT into ".$_SESSION["user_db"]."test_no$row (question_id) values($random)";

                        if ($conn->query($sql) !== TRUE) {
                            echo "<br>" . "<br>not inserted $sql";
                            die("not able to prepare test");
                        }
                        $_SESSION["question_no"] = 1;
                    }
                    // echo "<pre>"; 
                    // print_r($array,); 
                    // echo "</pre>"; 
                    $conn->close();
                } else {
                    echo "<br>" . "<br> not able to insert new row ";
                }
            } else {
                // echo "<br>" . "<br> NOt able created test_no $row successfully";
            }

            // echo "<br>" . "no of row is";
        } else {
            echo "<br>" . "<br> not able to create database<br>";
            echo "<br>" . "connect error is<br>", $conn->error;


            $sql = "CREATE TABLE ".$_SESSION["user_db"]."test_detail( test_no INT AUTO_INCREMENT PRIMARY KEY, date VARCHAR(20), time VARCHAR(20), score INT)";
            if ($conn->query($sql) === TRUE) {
                echo "<br>" . " created succesfully new db ";

                header("location:test.php");
            } else {
                echo "<br>" . "NOt able to create table db";
                echo "<br>" . "connect error is<br>", $conn->error;
            }
            $conn->close();
        }
    } else {
        echo "<br>" . " not able to connect";
    }
}
?>
 

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <link rel="icon" href="favicon.png" type="image/x-icon">
</head>

<style>
    body {

        color: white;
        /* background-color: rgb(34, 34, 34); */
        margin: 0px;
        background-color: rgb(15, 37, 37);
        font-size: 20px;
        /* background-color: rgb(15, 37, 37); */
    }

    #test_box {
        /* background-color: blue; */
        width: 97%;
        margin: auto;
        padding: 3px;
        margin-top: 1%;
        background-color: rgb(177, 168, 168);
        border-radius: 1px;
        ;
        color: black;
        /* background-color:white; */
        text-align: left;
    }

    #submit_button {
        position: absolute;
        right: 2px;;
    }



    form {
        /* width: 80%; */
        border-style: solid;
        border-width: 1px;
        /* padding:10px; */
        /* background-color: blue; */
        border-width: 80%;
        margin:auto; 
        width:684px; 
        position:relative; 

        /* margin:50px; */
    }

    #form_boundaray {
        width: 80%;
        margin: auto;
        /* background-color: blue;; */

    }


    button {
        background-color: rgb(55, 55, 56);
        /* padding: 5px; */
        /* color:black */
        margin: 10px;
        padding:2px;
        width:110px; 
        font-size:15px;  
         color:whitesmoke ;
        /* border: white solid 0.1mm; */
    }


    button:hover {
        background-color: rgb(88, 88, 88);
    }
    #header{
        margin-top :4px;
        margin-left :25px;
        
        /* background-color: blue; */
    }

    @media screen and (max-width :800px){
       form{
           width:120%;
           margin:0px; 
           padding:0px;
           left :-57px; 
           height: fit-content;
       }

       #all_buttons{
           text-align:center; 
       }
        button{
            display: inline-block;
           
    width: 97%;
    margin-top: 12px;
    padding: 5px 0px;

         
        }
        #submit_button {
     position:unset; 
    
    }


 #test_box{
     font-size:18px; 
 }
    }

    @media screen and (max-width :650px){
       form{
           width:118%;
     
           left :-47px; 
         
       }

       #test_box{
     font-size:15px; 
 }


    }
    @media screen and (max-width :570px){
       form{
      left :-37px; 
      
       }

       button{
  
    width: 95%;


         
        }
   
    
 
    }


    @media screen and (max-width :400px){
       form{
         left :-27px; 
         width:110%; 
     }
     #header {
        font-size:15px; 
    }
   

    }
    @media screen and (max-width :280px){
       form{
         left :-17px; 
         /* width:100%;  */
     }
     #header {
        font-size:12px; 
    }
   


    }
</style>

<body>

    <div id="header">
        <span  id="time"></span>
    </div>

    <hr>
    <?php
    if (isset($_SESSION["question_no"]) &&   $_SESSION["question_no"] != -1) {
        $question_no = $_SESSION["question_no"];
        $question_id = 0;
        $answer ="";
        // echo "<br> question no - > ", $question_no;
          include "table_detail.php"; 
       
        if ($conn->connect_error == "") {


            $sql = "SELECT * FROM  " . $_SESSION["user_db"] . "test_no" . $_SESSION["test_no"] . " WHERE question_no=" . $question_no;
            // echo "<br>sql querys is: ", $sql;
            
            $result = $conn->query($sql);
            if ($result != "" &&  $result->num_rows != 0) {
                $row = $result->fetch_assoc();
                $question_id = $row["question_id"];
                $answer = $row["answer"];
                // echo "<br>--->>>>", $row["answer"];
            } else {
                // echo "question id not found ";
            }
            if (isset($_REQUEST["answer"])) {

                $sql = "UPDATE   " . $_SESSION["user_db"] . "test_no" . $_SESSION["test_no"] . " SET answer = '" . $_REQUEST["answer"] . "' WHERE question_no= " . $_SESSION["prev_no"];
                // echo "<br>sql querys is: ", $sql;

                if ($conn->query($sql) === TRUE) {
                    // echo "<<br>->> updated anser ";
                } else {
                    // echo "<br>not able to update answer ";
                    echo"<br>".$conn->connect_error;
                    // echo"<br>".$conn->error;
                    // echo"end";
                    
                }
            }


            $conn->close();
        } else {
            // echo "<br> not able to connect  to question database";
        }

        // echo "<br> question id-> " . $question_id;

         include "conn_detail.php"; 
         // echo $conn->error; 
        if ($conn->connect_error == "") {
           
            $sql = "SELECT * FROM question_answer WHERE id=" . $question_id;
            $result = $conn->query($sql);
            // print_r($result); 
            if ($result != "" && $result->num_rows != 0) {
                $row = $result->fetch_assoc();
                // echo " tiill  noew"; 
                echo '<div id="form_boundaray">
              <form action="" method = "post">
                  <div id="test_box">
                      <p id="question"> ' . $question_no . '. ' . $row["question"] . '</p>
                      <input type="radio" name="answer" value="a"';
                 if($answer == 'a') echo"checked";
                 echo'> ' . $row["opt_a"] . '
                    <br>
                      <input id="b" type="radio" name="answer" value="b" align="right" ';
                      if($answer == 'b') echo"checked"; echo'><span> ' . $row["opt_b"] . '
                          <br>
                          <input type="radio" name="answer" value="c"  ';
                          if($answer == 'c') echo"checked"; echo' > ' . $row["opt_c"] . '
                         <br> <input id="d" type="radio" name="answer" value="d" align="right"  ';
                         if($answer == 'd') echo"checked"; echo'> <span> ' . $row["opt_d"] . '
      
      
      
      
                  </div>
                  <div id="all_buttons">
                  <button type="submit" id="prev_button" name="prev">Previous</button>
                  <button align="right" type="submit" id="next_button" name="next">Save and Next</button>
                  <!-- <button type="submit" >fgf</button> -->
                  <button align="center" type="submit" id="submit_button" name="submit"> Exit </button>
                   </div>
              </form>
          </div>';
                    
                $conn->close();
            } else {
                // echo "question id's data  not found ";
            }
        } else {
            // echo "<br> not able to connect  to question database";
        }
    }

    ?>
    <script>
        var time = document.getElementById("time");
        var start ;
        var end ;
        var c =0; 
       
        start =    <?php 
            include "table_detail.php"; 
             
             if($conn->connect_error ==""){
                  $sql = "SELECT time FROM  ".$_SESSION["user_db"]."test_detail WHERE test_no =".$_SESSION["test_no"];
                  
                  $result = $conn->query($sql); 
                  if($result=="")
                   die("connection error");
                $result = $result->fetch_assoc();
                //  print_r($result);
                  echo $result["time"];
                $conn->close();
             }
            ?> ;
        end  = start + 120;
        if(sessionStorage.getItem("count") == null){
            sessionStorage.setItem("count","0");
            console.log( "count is set to 0 ");
        }

        setInterval(() => {
         start =    <?php 
        include "table_detail.php"; 
           if($conn->connect_error ==""){
                $sql = "SELECT time FROM  ".$_SESSION["user_db"]."test_detail WHERE test_no =".$_SESSION["test_no"];
                $result = $conn->query($sql); 
                if($result=="")
                 die("connection error");
              $result = $result->fetch_assoc();
              //  print_r($result);
                echo $result["time"];
              $conn->close();
           }
          ?> ;
          end  = start + 120;
            // console.log("time is: ", start);
         
           }, (5000));
          
         
           setInterval(() => {
             c=Number(sessionStorage.getItem("count"))+1;
          
              var temp = end - (start  ) - c ;
              sessionStorage.setItem("count",String(c));
            //   console.log(start, "and ",);
                if(temp <0) {
                    sessionStorage.removeItem("count")
                    window.location = "display_score.php";
                }
               time.textContent = "Time Left : " + Math.floor(temp/60)+ " minutes and " + temp%60+ " seconds" ;
            //    console.log("update time",temp);
           }, (1000));


        

        // console.log(history.back());
        time.textContent = "<?php echo $_SESSION["question_no"]?>";
    </script>


</body>


</html>