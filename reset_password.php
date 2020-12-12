<?php

session_start();

// echo " session is <pre>"; 
// print_r($_SESSION); 


// echo "</pre>";


// echo "<hr> Request is is <pre>"; 
// print_r($_REQUEST); 


// echo "</pre>";
$error  = "";
$success =""; 
 

if (isset($_GET["reset_pass"]) && isset($_GET["t"]) && ($_GET["reset_pass"]  == "1") && isset($_GET["email"])) {


    $token_recieved = trim($_GET["t"]);
    $email = trim($_GET["email"]);
    
    if ($token_recieved == "" || $email == "") {
        $error = "token or email is empty "; 
        header("location:error.php");
    }
 

    include "conn_detail.php";
    $sql = "SELECT * FROM reset_pass where token='$token_recieved' AND email='$email'";


    $result = $conn->query($sql);

    if ($result->num_rows == "1") {
        $row = mysqli_fetch_assoc($result);
        // echo "row is <pre>";
        // print_r($row);
        // echo "</pre>";
        if ($row['time_expired'] <= (time())) {
            $error = "Token Expired. Please Try Again ";
        } else if ($row['token'] != $token_recieved) {
            $error = "Unknown Token.  Please Try Again ";
            header("location:error.php");
        } else {

            $_SESSION['this_token']  = $token_recieved; 
            $_SESSION['this_email'] = $email; 
        

        }
    }else{
        $error =  "something went wrong . Please Try Again ";
        header("Refresh:2; url=./recover_password_php.php");
    }
 $conn->close(); 
}
else if( isset($_REQUEST["submit"])  &&  isset($_SESSION['this_token'] )   &&  isset($_SESSION['this_email'] ) && isset($_REQUEST["new_pass"])  && isset($_REQUEST["conform_pass"])  ) {


    $token_recieved =($_SESSION['this_token']);
    $email = ($_SESSION['this_email']); 
    $new_pass = trim($_REQUEST["new_pass"]); 
    $conform_pass = trim($_REQUEST["conform_pass"]); 
    if($new_pass == "" || $conform_pass == ""){
        $error = "Fields Cannot be Empty"; 
    }else if($new_pass != $conform_pass ){
        $error = "Password Not Matched "; 
    }else if(strlen($new_pass)<6 ||  strlen($new_pass)>50  ){
        $error = "Password must be greater than 6 digit and less than 50 digit "; 
    }else{
        include "conn_detail.php";
        $sql = "UPDATE user_detail SET password='$new_pass' WHERE email='$email'"    ; 
        $result = $conn->query($sql);
        if($result!="1"){
            $error = "Something went wrong"; 
        }
        $sql = "DELETE FROM reset_pass WHERE email='$email'";;  
        $result = $conn->query($sql);
        if($result!="1"){
            $error = "Something went wrong"; 
        }
        else{
            $success = "New password Updated successfully"; 
           unset ( $_SESSION['this_token'] ); 

            session_destroy(); 
            
            header("Refresh:4; url=./login.php");
        }
      
        $conn->close(); 
    }

    


   
}
else{
    $error = "Not a Valid Request";
    // echo "$error "; 

    header("Refresh: 1; url=./login.php");
}


 

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" href="favicon.png" type="image/x-icon">
</head>

<style>
    body {
        background-color: rgb(34, 34, 34);
        min-height: 100vh;

        /* background-color: rgb(34, 34, 34); */
        background-image: url(quiz_image.jpg);
        /* background-repeat: no-repeat; */
        background-size: cover;
        margin: 0px;
    }

    #form_boundary {
        width: 380px;
        position: relative;
        top: 30px;
        margin: auto;
        border-style: solid;
        border-width: 1px;
        padding: 10px;
        border-radius: 3px;
        /* background-color: darkslategray; */
        background-color: rgba(0, 0, 0, 0.7);
        padding-bottom: 27px;
        margin-bottom: 86px;




    }

    input {
        background-color: transparent;
        /* margin: 5px; */
        /* padding:5px;  */
        position: relative;
        /* right: -10%; */
        right: 0px;
        color: rgb(255, 255, 255);
        width: 90%;

    }

    button {
        /* background-color: #008CBA; */
        /* background-color:     #0067ba85;;  */
        padding: 5px;
        color: black;
        font-size: large;
        color: whitesmoke;

        /* background-color: rgb(24, 145, 145); */
        background-color: black;
        color: white;
        font-size: 15px;
        /* width: 83%; */
    }

    input::placeholder {
        color: rgba(250, 250, 250, 0.7);
    }



    button:hover {
        /* background-color: rgb(24, 168, 168); */
        /* color: indigo; */
        /* box-shadow: 0px 0px 5px  1px white; */
        cursor: pointer;
        box-shadow: 0px 0px 5px 1px white;

    }

    button:focus,
    input:focus {
        /* background-color: rgb(24, 168, 168); */
        box-shadow: 0px 0px 5px 1px white;


    }

    #test {

        width: 259px;
        position: fixed;
        left: 10%;
        right: 10%;
        top: 10%;
        color: white;
        /* top: -144px; */
        z-index: 4;
        background-color: rgba(0, 0, 0, 0.7);
        border-style: solid;
        border-color: white;
        border-width: 1px;
        text-align: center;
        margin: auto;
        height: 200px;
        font-size: 30px;

    }

    .form_box {
        position: relative;
        /* border:1px solid  white; */

    }

    .input_field {
        position: relative;
        margin: 25px 5px;
    }

    .s1 {
        /* background-color:blue; */
        /* text-align:right;; */
        display: inline-block;
        width: 230px;
        position: absolute;
        text-align: right;
        right: 0px;
        /* border:1px solid yellow;  */


    }

    #heading2 {
        display: none;
    }

    @media screen and (max-width:700px) {
        .detail {
            display: none;
        }


        #heading2 {
            display: block;
        }

        .s1 {
            display: inline-block;
            position: relative;
            width: 90%;
        }

        h3 {
            text-align: center;
        }

        #form_boundary {
            width: 90%;
        }

        #submit_button {
            width: 82%;
            margin-left: 8%;
        }

        button {
            width: 80%;
        }


        body {
            height: 120vh;
        }

        .heading {
            text-align: center;
        }
    }
</style>

<body style="color:white">

    <div id="form_boundary">
       
   <?php
   
   if(isset($_GET["reset_pass"]) && isset($_GET["t"]) && ($_GET["reset_pass"]  == "1") && isset($_GET["email"])) {
       echo ' <p id="heading1" class="heading"> Enter Your Details </p>

        <hr>'; 
    }
       
 
    //   echo "error =$error and sucess = $success"; 
        if ($error != "") {
            echo "<h3 style='color:white; background-color:red;font-size:15px;padding:5px;'>$error</h3> ";
        } else  if ( $success != "") {

            echo "<h3 style='color:white; background-color:green;font-size:15px;padding:5px;'>$success </h3> ";
        }
           echo '<form  action="" method="GET" class="form_box" >'; 

        if (isset($_GET["reset_pass"]) && isset($_GET["t"]) && ($_GET["reset_pass"]  == "1") && isset($_GET["email"])) {

        echo '   
                <div id="heading2" class="heading" > Reset Password </div>
                <div class="input_field" > <span class="detail">   New Password : </span>  <span class = s1 > <input   id="new_pass" name="new_pass" type="password" placeholder="New Password">  </span>  </div> 
                <div class="input_field" > <span class="detail">   Conform Password : </span>  <span class = s1 > <input   id="conform_pass" name="conform_pass" type="password" placeholder="Conform Password">  </span>  </div>
               <p ><button id="submit_button" type="submit" name ="submit">Submit</button><p>  
        
            ';
        }
        echo '</form>
        </div>'; 


        ?>
</body>

</html>