<?php

session_start();
$display_form = "true";
   if (isset($_REQUEST["submit"])) {
    $error  = "";
    $name = trim($_REQUEST["name"]);
    $mobile_no = trim($_REQUEST["mobile_no"]);
    $email = trim($_REQUEST["email"]);
    $password = trim($_REQUEST["password"]);
    $confirm_password = trim($_REQUEST["confirm_password"]);
    if(empty($name) ||empty($mobile_no) ||empty($password) ||empty($email) ||empty($confirm_password) ){
        $error = "Please fill all the fields";
    }
     else if (strlen($mobile_no)!=10)  {
        $error = "Please Enter a Valid mobile number ";
    } else if (strcmp($password, $confirm_password) != 0) {
        $error = "Password does not match ";
    } else if (strlen($password) < 6) {
        $error = "Password must be greater than 5 digit ";
    }

   
    if ($error === "") {
         include "conn_detail.php"; 
       
         
        if ($conn->connect_error == "") {
            // echo "connected sucessfully ";
            // echo  "----> ".$conn->connect_error ; 
            if ( false && $_REQUEST["submit"] == "update") {
                $sql = "UPDATE user_detail SET name='$name' ,email ='$email',password = '$password' WHERE id= '$mobile_no'";
                if($conn->query($sql) === TRUE){
                    // echo "updated sucessfully";
                }
             

            } 
          else{
            $sql = "SELECT * FROM user_detail WHERE mobile_no = '$mobile_no'";
            $result = $conn->query($sql);
            // echo "<br>result of table creation si" ;
            //  print_r($result); 
            // echo "<pre>" .$result ."</pre>"; 
            // echo "<br>**". $conn->connect_error; 
            if($result==""){
                // echo "working"; 
                $sql_1=  "CREATE TABLE user_detail(name VARCHAR(50) ,email VARCHAR(50) ,password VARCHAR(50), mobile_no VARCHAR(15))";
                echo $conn->query($sql_1 );
                  
                  
            }
            //  echo "type of result is:-> ". $result;
            if ( $result!="" &&  $result->num_rows > 0) {
                $error = "Phone number already exist try another number ";
            }
            else {
                // echo "connectino ***"; 
                // echo $conn->error;
                $sql  = "INSERT INTO user_detail (name,email,password,mobile_no) VALUES('$name','$email','$password','$mobile_no')";
                // echo "reslult of query is: <br>"; 
                // echo ($conn->query($sql)) ; 
                // echo $conn->error; 
                if ($conn->query($sql) === TRUE) {
                    // echo "<br> sucessfully inserted table in quiz db ";
                     $conn->close();
                     include "table_detail.php"; 

                     if($conn->connect_error !=""){
                        //  echo "<br>not able to connect to table db";
                         echo $conn->error;
                         die("not connected");
                     }
                    $sql = "CREATE TABLE ".$mobile_no."test_detail(test_no INT AUTO_INCREMENT PRIMARY KEY,date VARCHAR(20) ,time VARCHAR(20), score INT)";
                    //   echo "<br>" .$sql;

                   if ($conn->query($sql)=== TRUE){
                        //  echo"created new table_detail successfully";
                   }
                   else{
                       echo" Not created new table_detail";
                   }
                     

                    $conn->close();

                    // $sql = "CREATE TABLE test_detail( test_no INT AUTO_INCREMENT PRIMARY KEY, date VARCHAR(20), time VARCHAR(20), score INT)";
                    // if ($conn->query($sql) === TRUE) {
                    //     echo " created succesfully new db ";
                    //     header("location:test.php");
                    // } else {
                    //     echo "NOt able to create new db";
                    // }
                    $display_form = "false"; 
                    echo ' <div id="test" ><form action="login.php" method="POST"> <p style="padding-top:25px">Registered Sucessfully</p>
                    <button type=submit name="success">OK</button></div>
                     ' ;

                }
                else{

                    echo "erro is: <br>";
                    echo $conn->connect_error;
                    echo "<br>Not inserted table in quiz db ";
                }
            }
         
          }
        }
      
    }
        




    //   else{
    //       echo "not able to connect ";
    //   }


}




 

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
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
      margin:0px; 
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
        background-color: rgba(0,0,0,0.7);
        padding-bottom:27px; 
        margin-bottom: 86px;

        <?php if($display_form === "false"){
           echo' display:none;';  
        
        }
        ?>
      
    }

    input {
        background-color: transparent; 
        /* margin: 5px; */
        /* padding:5px;  */
        position: relative;
        /* right: -10%; */
        right: 0px; 
        color: rgb(255, 255, 255);
        width:90% ; 
    
    }

    button {
        /* background-color: #008CBA; */
        /* background-color:     #0067ba85;;  */
        padding:5px; 
        color: black;
        font-size: large;
        color:whitesmoke;
        
    /* background-color: rgb(24, 145, 145); */
    background-color: black;
    color: white;
    font-size: 15px;
    /* width: 83%; */
}

input::placeholder{
        color:rgba(250,250,250,0.7);
    }

   

    button:hover {
        /* background-color: rgb(24, 168, 168); */
        /* color: indigo; */
        /* box-shadow: 0px 0px 5px  1px white; */
        cursor:pointer; 
        box-shadow: 0px 0px 5px  1px white;
      
    }
    
    button:focus,input:focus {
        /* background-color: rgb(24, 168, 168); */
        box-shadow: 0px 0px 5px  1px white;
    

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
    background-color: rgba(0,0,0,0.7) ;
    border-style: solid;
    border-color: white;
    border-width: 1px;
    text-align: center;
    margin: auto;
    height: 200px;
    font-size: 30px;

    }
    .form_box  {
     position:relative; 
     /* border:1px solid  white; */
     
 }
 .input_field{
     position:relative; 
     margin:25px 5px; 
 }
 .s1{
     /* background-color:blue; */
     /* text-align:right;; */
     display:inline-block;
     width:230px;
     position:absolute;
text-align:right; 
     right:0px; 
     /* border:1px solid yellow;  */

  
 }


 @media screen and (max-width:700px) {
  .detail{
      display:none; 
  }
  .s1{
      display:inline-block; 
      position :relative; 
      width:90%; 
  }
  h3{
      text-align:center; 
  }
  #form_boundary{
      width:90%; 
  }
  #submit_button{
      width:82%; 
     margin-left:8%; 
  }
  button{
      width:80%; 
  }

  body{
      height:120vh;
  }
  #heading {
      text-align:center;
  }
}

</style>

<body style="color:white">

    <div id="form_boundary">

        <p id="heading"> Enter Your Details :</p>
        <hr>
        <?php
        if (isset($_REQUEST["submit"]) && $error != "") {
            echo "<h3 style='color:red'>$error</h3> ";
        }


        
        if ( false && isset( $_SESSION["update"]) && $_SESSION["update"] ="update"  ) {
    //         $_SESSION["update"]="";
    
    //         $name = "";
    //         $password = "";
    //         $email = "";
    //         $mobile_no  =  $_SESSION["user_db"];


    //         if ($conn->connect_error == "") {

    //             echo " connected sucessfully";
    //             $sql = "SELECT * FROM user_detail WHERE mobile_no =$mobile_no";

    //             $result =    $conn->query($sql);
    //             // print_r($result);
    //             echo "num row -->", $result->num_rows;
    //             if ($result !== FALSE && $result->num_rows == 1) {
    //                 echo "result is: ";
    //                 // print_r($result);
    //                 $row = $result->fetch_assoc();
    //                 echo "<br> row is:";
    //                 // print_r($row);
    //                 $name = $row["name"];
    //                 $password = $row["password"];
    //                 $email = $row["email"];

    //                 //  $name = explode(" ",$name);
    //                 // print_r($name);        
    //                 $conn->close();
    //             }
    //             echo '   <form  action=""  method="POST"   >

    //    Name: <input   required id= "name" type="text" name = "name" value="' . $name . '" >
    //      <br>Mobile No:<input  required id="mobile_no" name="mobile_no" type ="number"  value =' . $mobile_no . '>
    //      <br>Email Address: <input  required id="email" name="email" type="email" placeholder="example@gmail.com" value=' . $email . '>
    //      <br>Password :<input required  id="password" name = "password" type ="password" value="' . $password . '">
    //      <br>Confirm Password:<input  required name="confirm_password" type ="password" value="' . $password . '" >
    //      <p><button type="submit" name ="submit" value="update">Update</button><p>
    //  </form>
    // </div>';
    //       }
        }
        
 
        else {
         
             if($display_form==="true"){
                echo '   <form action=""  method="POST" class="form_box" >
       
                <div class="input_field" > <span class="detail">   Name: </span>  <span class = s1 > <input    id= "name" type="text" name = "name"  placeholder="Name" >  </span>  </div> 
                <div class="input_field" > <span class="detail">   Mobile No: </span>  <span class = s1 > <input   id="mobile_no" name="mobile_no" type ="text"  placeholder="Mobile No"  >  </span>  </div>
                <div class="input_field" > <span class="detail">   Email Address: </span>  <span class = s1 > <input   id="email" name="email" type="email" placeholder="example@gmail.com">  </span>  </div> 
                <div class="input_field" > <span class="detail">   Password : </span>  <span class = s1 > <input   id="password" name = "password" type ="password"  placeholder="Password">  </span>  </div>
                <div class="input_field" > <span class="detail">   Confirm Password: </span>  <span class = s1 >  <input   name="confirm_password" type ="password" placeholder="Password"  > </span>  </div>
               <p ><button id="submit_button" type="submit" name ="submit">Submit</button><p>  
        
            </form>
           </div>';
             }
        }

        ?>
</body>

</html>