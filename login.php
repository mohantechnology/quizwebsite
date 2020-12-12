<?php

 $error = "";
 session_start();  

if (isset($_REQUEST["login"])) {
    $mobile_no = trim($_REQUEST["mobile_no"]);
    $password = trim($_REQUEST["password"]);
    include "admin_detail.php"; 
     
    if(strcmp($mobile_no , $admin_mobile_no)=== 0 && strcmp( $password, $admin_pass)=== 0 ){
    //    echo"admini login";
       $_SESSION["admin_db"] ="TTTTT";
        //  echo "qoing to admin db ";
        header("location:admin.php");
     }
  
    include "conn_detail.php"; 
   
    if($conn->errno != 0){
        die("error found"); 
    }
   
  if (strlen($mobile_no)  !=10) {

        $error = "Please Enter a valid mobile number";
    } else if ($conn->connect_error == "") {

        // echo " connected sucessfully";
       
 
 

        $sql = "SELECT password FROM user_detail WHERE mobile_no ='$mobile_no'";

        $result =    $conn->query($sql);
        // print_r($result);
        // echo "num row -->", $result->num_rows;
        if ($result !== FALSE && $result->num_rows == 1) {
            if (strcmp($password, $result->fetch_assoc()["password"]) == 0) {
          
               $_SESSION["quiz_data"]= $mobile_no;
             
                //  header("location:profile.php");
 
           $conn->close();
            header("location:profile.php");    
            } else {
                $error = "Wrong Password";
            }
        } else {
            $error = "User Not Registered";
        }
    } else {
        // echo "Not able to connect ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="icon" href="favicon.png" type="image/x-icon">
</head>

<style>
    body {

          margin:0px;
          padding:0px;
           min-height: 100vh;
      
        /* background-color: rgb(34, 34, 34); */
        background-image: url(quiz_image.jpg);
        /* background-repeat: no-repeat; */
        background-size: cover;
        /* background-size: 100%; */
    
    }
   /* img ,#img{  */
         /* he:100%; */
          /* width:100%;
          position:fixed; */
         /* position:absolute; */
         /* background-attachment: fixed; */
         /* background-repeat: no-repeat; */
   /* } */
    #form_boundary {    

        width: 220px;
        margin: auto;
        /* display: flex; */

        border-style: solid;
        padding: 10px;
        position: relative;
        top: 30px;
        border-radius: 3px;
        border-color:    rgb(231, 221, 255);
          /* opacity:0.9; */
          

        
        border-width:1px;
        text-align: center;
    
        background-color: rgba(0,0,0,0.7);
   /* background: transparent; */
        /* background-color: rgb(43, 75, 75); */
        /* background:transparent; */
    }

    input {
    
        /* background-color: rgb(59, 54, 54); */
        margin-bottom: 15px;
        /* opacity:0.5; */
        position: relative;
        /* right: -10%; */
        /* left:10px; */
        width: 80%;
        color: rgb(255, 255, 255);
        background:transparent;
    }

    button {
        
        /* background-color: rgb(24, 145, 145); */
        background-color: black;
        color: black;
        font-size: 15px;
        width: 83%;
    }

    button:hover{
        /* background-color: rgb(24, 168, 168); */
        box-shadow: 0px 0px 5px  1px white;
        

    }

    button:focus,input:focus {
        /* background-color: rgb(24, 168, 168); */
        box-shadow: 0px 0px 5px  1px white;
    

    }

    a {
        text-decoration: none;
        color: rgb(205, 205, 222 );;
    }

    a:hover {
        /* text-decoration: none; */
        color: rgb(5, 4, 255);;

    }
    input::placeholder{
        color:white;
    }
    
</style>

<body>
   <!-- <img id="img" src="quiz_image.jpg" alt=""> -->
     
    <div id="form_boundary">
        <form action="" method="post">
            <p style="font-weight: 800;font-size:larger ;color:whitesmoke"> QUIZ</p>
            <hr>
            <!-- value ="1111111111" value = "1234767890" -->
            <?php if ($error != "") echo "<p  style='color:red' >$error<p>"; ?>
            <br><input required type="text" name="mobile_no"   placeholder="Enter your mobile number">
            <br><input required type="password" name="password" placeholder="Enter your Password">
            <br><button style="color:whitesmoke" type="submit" name="login">Log In</button>

            <a href="recover_password_php.php">
                <p>Forgot password?</p>
            </a>
            <p style="color:white" >Don't have an account?  &nbsp;<a href="registration_form.php">Sign up</a></p>

        </form>

    </div>
    <div id="img">
    </div>

</body>

</html>