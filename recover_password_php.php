<?php

session_start();

if (isset($_REQUEST["submit"])) {
  $error  = "";
  $success = "";
  $email = trim($_REQUEST["email"]);


  if (empty($email)) {
    $error = "Please fill all the fields";
  }



  if ($error === "") {
    include "conn_detail.php";


    if ($conn->connect_error == "") {
      // echo "connected sucessfully ";
      // echo  "----> ".$conn->connect_error ; 


      $sql = "SELECT * FROM user_detail WHERE email = '$email'";
      $result = $conn->query($sql);
      // echo "<br>result of table creation si" ;
      //  print_r($result); 
      // echo "<pre>" .$result ."</pre>"; 
      // echo "<br>**". $conn->connect_error; 

      //  echo "type of result is:-> ". $result;
      $is_email_already_present  = false;
      $is_token_expire = true;
      if ($result != "" &&  $result->num_rows > 0) {

        $sql = "SELECT * FROM information_schema.tables WHERE table_schema = 'quiz_website' AND table_name = 'reset_pass' LIMIT 1";
        // $sql = "SHOW TABLES LIKE '';"; 
        $result = $conn->query($sql);


        if ($result->num_rows == "0") {
          $sql =  "CREATE TABLE reset_pass( email VARCHAR(50) , token VARCHAR(53), time_created VARCHAR(30) ,time_expired VARCHAR(30) )";
          $result = $conn->query($sql);
          //    echo "working to create table<-";
          //   print_r($result ) ; 
          //    echo "->"; 
        } else {
          $sql = "SELECT * FROM reset_pass WHERE email='$email'";
          // $sql = "SHOW TABLES LIKE '';"; 
          $result = $conn->query($sql);
          if ($result->num_rows > "0") {
            $is_email_already_present = true;
            $row = $result->fetch_assoc();
            // echo $row['time_expired'] ." , ".(time()+60); 
            if ($row['time_expired'] > time() + 60) {
              $is_token_expire = false;
              // echo "token  is not expired "; 
            }
          }
        }


        include "admin_detail.php";
        $token  = bin2hex(random_bytes(25));

        $reset_url = $admin_domain_address. "/reset_password.php?reset_pass=1&t=$token&email=$email";
        // echo "$reset_url"; 
        // $reset_url = "http://localhost/quizwebsite/reset_password.php?reset_pass=1&t=$token&email=$email";
        // echo "$token ";
        // echo"<br> url is:$reset_url"; 
        //  echo $token; 
        // $url = 'http://localhost:3000/send-mail';
        $email_url = 'https://glacial-hollows-10994.herokuapp.com/send-mail';

        $sql = "";
        if ($is_email_already_present) {


          $sql = "UPDATE reset_pass SET token='$token' ,time_created=" . time() . ",time_expired=" . (time() + 600) . " WHERE email='$email'";
          // echo "udaed the token "; 


        } else {

          $sql = "INSERT INTO reset_pass (email,token,time_created,time_expired) VALUES('$email','$token'," . time() . "," . (time() + 600) . ")";
          //  echo "inserted the token "; 
        }



        //    $result = $conn->query($sql); 
        //if token is   expired  insert or update token and send verfication email   
        //  echo "checking is token expire <-$is_token_expire->"; 
        if ($is_token_expire  && $conn->query($sql) == "1") {

          include "admin_detail.php";
          $temp = '
          <div style=" background-color: #f4f4f4;margin:0px ; padding:0px;font-family: Helvetica, Arial, sans-serif;  font-weight: 400; line-height: 25px;height:1000px" > 
          <div   style="background-color:#7c72dc;height:100px;">
          </div>
          
        
          <div   style="background-color:#7c72dc;height: 90px;">
               <h1 style="background-color:#ffffff; width:500px;;margin:auto;border-radius: 4px 4px 0px 0px; color: #978582; font-family:  Helvetica, Arial, sans-serif; font-weight: 400; letter-spacing: 4px; line-height: 120px;text-align: center;">   Trouble signing in?</h1>
      
          </div>
          <div  style="background-color:#ffffff;height: 450px;width:500px;;margin:auto;border-radius: 3px ;text-align:center ">
         
               
             
              <p style="  padding: 20px 30px 40px 30px; color: #666666;  font-size: 18px; text-align:left">
                  Resetting your password is easy. Just press the button below and follow the instructions. We w’ll have you up and running in no time.</p>
              <div style="  padding: 20px 30px 40px 30px; ">
                  <p style="width: 327px;   min-height: 70px;;background-color: #7c72dc;margin:auto; text-align: center;border-radius: 4px; "><a href="'.$reset_url.'" style="font-size: 20px; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding:15px 25px;  display: inline-block;line-height: 35px;"> Reset Password</a> </p>
              </div>
              <div style="background-color: #444444;  padding: 20px 30px ;">
                   <p style="font-size: 24px; color:#ffffff; ">Unable to click on the button above?</p>
              </div>
              <div  style="background-color:#eeeeee;  padding: 20px 30px ;text-align: left;  border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;">
                  <p style="color: #666666;">See how easy it is to get started</p>
                  <p  ><a  href="'.$reset_url.'"  target="_blank" style="font-size: 20px;font-weight: 500;  color: #7c72dc;">Click on this  link or copy/paste in the address bar.</a><p>
              </div>
              <div   
              style=" background-color: #C6C2ED; padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-size: 18px; font-weight: 400; line-height: 25px;margin:25px 0px 10px 0px;min-height:100px; ">
      
                  <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
                  <span style="color:black;">Email us at <b style="color: #7c72dc">  magicmasala500@gmail.com</b>. We’re here, ready to talk </span>
              </div>
      
              <div         padding: 0px 30px 30px 30px; color: #666666; font-size: 14px;  line-height: 18px;text-align:left;min-height: 50px; >
                  <p style="margin: 0;">You received this email because you requested a password reset. If you did not, <span target="_blank" style="color: #111111; font-weight: 700;">Please Ignore This Message.</span></p>
              </div>
         
       
        
        </div>
      
      </div>
        <div style="min-height: 50px; background-color: #f4f4f4">
      
      </div>';



          $data = [
            'sender_email' => $admin_email_address,
            'sender_pass' => $admin_email_pass,
            'reciever_email' => $email,
            'sub' => 'Reset password ',
            'body' =>    $temp
          ];

          $options = array(
            'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
              'method'  => 'POST',
              'content' => http_build_query($data)
            )
          );
          $context  = stream_context_create($options);
          $result = file_get_contents($email_url, false, $context);
          if ($result == "ok") {

            $success = " Reset Password Link  is sended to your Email. Please check your Email Account.   ";
          } else {
            $error = "Failed to Send Email. For more Information , Please Contact us at <b><u>magicmasala@gmail.com</u></b>";
          }
        } else {
          if ($is_token_expire) {
            $error = "Failed to Send Email. For more Information , Please Contact us at <b><u>magicmasala@gmail.com</u></b>";
          } else {
            $success = " Reset Password Link  is sended to your Email. Please check your Email Account.   ";
          }
        }


        $conn->close();
      } else {
        $error = "Email Not Found";
      }
    }
  }
}



 


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recover Password</title>
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

    <p id="heading1" class="heading"> Enter Your Details </p>

    <hr>
    <?php
    if (isset($_REQUEST["submit"]) && $error != "") {
      echo "<h3 style='color:white; background-color:red;font-size:15px;padding:5px;'>$error</h3> ";
    } else  if (isset($_REQUEST["submit"]) && $success != "") {
      echo "<h3 style='color:white; background-color:green;font-size:15px;padding:5px;'>$success</h3> ";
    }




    echo '   <form action=""  method="POST" class="form_box" >
                <div id="heading2" class="heading" > Email Address </div>
                <div class="input_field" > <span class="detail">   Email Address: </span>  <span class = s1 > <input   id="email" name="email" type="email" placeholder="example@gmail.com">  </span>  </div> 
             
               <p ><button id="submit_button" type="submit" name ="submit">Submit</button><p>  
        
            </form>
           </div>';



    ?>
</body>

</html>