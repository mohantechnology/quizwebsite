 <?php
// print_r($_SESSION);
session_start();
$error = "";
if(!isset($_SESSION["admin_db"]) || $_SESSION["admin_db"]== ""){
    header("location:login.php");
    echo "admin_db Not set ";
    echo "<br>admin_db is: ".$_SESSION["admin_db"];
}

if (isset($_REQUEST["back"])) {
    header("location:admin.php");
    // echo "going to admin";
}

if (isset($_REQUEST["login"])) {
    $question = trim($_REQUEST["question"]);
    $answer = trim($_REQUEST["answer"]);
    $opt_a = trim($_REQUEST["opt_a"]);
    $opt_b = trim($_REQUEST["opt_b"]);
    $opt_c = trim($_REQUEST["opt_c"]);
    $opt_d = trim($_REQUEST["opt_d"]);
    if(empty($question)|| empty( $answer)|| empty($opt_a)|| empty($opt_b)||empty($opt_c)||empty($opt_d)){
        $error = "<div style='text-align:center;font-size:25px; color:black;background-color:red; '>Field Cannot Be Blank</div>";
    }
    
    
else{    
  
    // echo"ready to insert";

    include "conn_detail.php"; 

   $sql = "SELECT * From question_answer"; 
   $result = $conn->query($sql); 
   if($result == ""){
       $sql = "CREATE TABLE question_answer ( id INT AUTO_INCREMENT PRIMARY KEY , question VARCHAR(300),answer VARCHAR(10),opt_a  VARCHAR(300),opt_b  VARCHAR(300),opt_c  VARCHAR(300),opt_d  VARCHAR(300) )  "; 
        $conn->query($sql); 
   }

   
//   $count = 20; 
//   $sql = " INSERT INTO question_answer (question,answer,opt_a,opt_b,opt_c,opt_d) VALUES('who am i ','a','i don t know ','antying ','a machine ','a resposnbible person ')"; 

//   while($count--){
//  $conn->query($sql); 
//   }

//    INSERT INTO question_answer (question,answer,opt_a,opt_b,opt_c,opt_d) VALUES('who am i ','a','i don t know ','antying ','a machine ','a resposnbible person ')
//    echo $result; 
//   echo"eresult is: "; 

    $sql = "INSERT INTO question_answer (question,answer,opt_a,opt_b,opt_c,opt_d) VALUES('$question','$answer','$opt_a','$opt_b','$opt_c','$opt_d')";
    // echo "query is: ",$sql;
    if($conn->connect_error ==""){
        // echo "connected sucessfully";

    if($conn->query($sql) === TRUE){
        echo " <div style='text-align:center;font-size:25px; color:black;background-color:green; '>inserted succesfully</div>";
        
    }
    else{
         echo  $conn->error; 
        echo "NOt able --to insert";
    }
    }
   else{
       echo "not able to insert";
   }


}
}
else{
    // echo "not ready to insert";
}

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Question</title>
</head>

<style>
    body{
        
    
        background-color: rgb(34,34,34);
    }
    #form_boundary{
    
        width: 300px;
        margin :auto;
        border-style :solid;
        padding:10px;
        position: relative;
        top:30px;
        border-radius:3px;
        text-align:center;
        background-color:rgb(43, 75, 75);
        color:whitesmoke;
    }
    input{
        background-color:rgb(59, 54, 54) ;
         margin-bottom:15px;
         position: relative;
         /* right: -10%; */
         /* left:10px; */
         width: 80%;
         color:rgb(255, 255, 255);
    }
    button{
        background-color: rgb(24, 145, 145);
        color:black;
        font-size: 15px;
        width: 83%;  
        margin:4px;  
        color:whitesmoke;
    }
    button:hover{
        background-color: rgb(24, 168, 168);
        color:black;
      
    }

    body {
        background-color: rgb(34, 34, 34);
        min-height: 100vh;
      
      /* background-color: rgb(34, 34, 34); */
      background-image: url(quiz_image.jpg);
      background-repeat: no-repeat;
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
    width: 92%;
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
      width:92%; 
  }
  p{
      /* text-align:center;  */
      
  }
  body{
      height:120vh;
  }
  #heading {
      text-align:center;
  }
}
</style>
<body>
    
      <div id = "form_boundary">
       <form >
        <p style="font-weight: 800;font-size:larger;"> Add New Question</p>
      <hr >
      <?php if ($error != "") echo "<p style='color:black'>$error<p>"; ?>
        <br><input type="text" name="question" placeholder="Enter question">
        <br><input type ="text"" name="answer" placeholder="Enter correct option">
        <br><input type ="text"" name="opt_a" placeholder="Enter Answer A">
        <br><input type ="text"" name="opt_b" placeholder="Enter Answer B">
        <br><input type ="text"" name="opt_c" placeholder="Enter Answer C">
        <br><input type ="text"" name="opt_d" placeholder="Enter Answer D">
       
        <br><button type="submit" name="login">Add</button>
       <button type = "submit" name="back"> Back</button>
    
        <!-- <p>Don't have a account?<a href="registration_form.php">Sign up</a></p> -->
   
       </form>
      
    </div>
 

</body>
</html>