<?php
//begin the session
session_start();
//DB connector
include 'include/connector.php';


//check for open session else redirect
if(isset($_SESSION['accountType']) && $_SESSION['accountType'] === "SimpleUser"){
    header("Location: Index.php");
} 

 

// define variables and set to empty values
$firstnError = $lastnError = $emailError = $pwdError1 = $pwdError2 = $phoneError = $genderError = $ageError =  " ";
$firstn = $lastn = $email = $pwd = $phone = $gender = $age =  " ";
$SignUpSucMessage = null;
$SignUpFailMessage = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //firstn validation
    if(empty($_POST["firstn"])){
        $firstnError= "First name is required";
    } 
    else {
        $firstn = val_input($_POST["firstn"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$firstn)) {
            $firstnError = "Only letters and white space allowed"; 
         }
    }
    
    //lastn validation
    if(empty($_POST["lastn"])){
        $lastnError = "Last name is required";
    } else {
        $lastn = val_input($_POST["lastn"]); 
        if (!preg_match("/^[a-zA-Z ]*$/",$lastn)) {
            $lastnError = "Only letters and white space allowed"; 
        }
    }
    

    //email validation
    if(empty($_POST["email"])){
        $emailError= "E-mail is required";
    } 
    else{
        $email = val_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format"; 
        }
        $sqlDuplicateEmail = "SELECT * FROM USERS WHERE EMAIL = '$email'";
        $resultDuplicateEmail = mysqli_query($conn, $sqlDuplicateEmail);
        if ($row = mysqli_fetch_assoc($resultDuplicateEmail)) {
            $emailError = "That email address is already in use. Sorry.";
        }
    }
    
    //pwd validation
    if(empty($_POST["pwd"]) || empty($_POST["conpwd"])){
        $pwdError1 = "password is required";
    } 
    elseif($_POST["pwd"] !== $_POST["conpwd"]){
        $pwdError2 = "passwords do not match!";
    }
    else{
        $pwd = val_input($_POST["pwd"]);
        if(!preg_match('/^(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $pwd)) {
        $pwdError1 = "the password does not meet the requirements!";
        }
    }
    
        //phone validation
    if(empty($_POST["phonenum"])){
        $phoneError = "Telephone is required";
    } 
    
    else{
        $phone = val_input($_POST["phonenum"]);
        if (!preg_match('/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/',$phone)) { 
            $phoneError = "Invalid telephone format (invalid characters)";      
        } else if(strlen($phone) < 10)
            {
                $phoneError = "Invalid telephone format (telephone too short)";
            }
        }
        
    //gender validation
    if(empty($_POST["gender"])){
        $genderError = " ";
        $gender = "Other";
    } 
    else {
        $gender = val_input($_POST["gender"]);
    }
    
    //age validation
    if(empty($_POST["age"])){
        $ageError = "Age needs to be specified";
    } 
    else {
        $age = val_input($_POST["age"]);
    }
    

    if($firstnError === " " && $lastnError === " " && $emailError === " " && $pwdError1 === " "  && $pwdError2 === " " && $phoneError === " " && $genderError === " " && $ageError ===  " "){
        $sql = "INSERT INTO users (FIRSTNAME, LASTNAME, EMAIL, PASSWORD, PHONE, GENDER, AGE, ISADMIN)
            VALUES ('$firstn', '$lastn', '$email', '$pwd', '$phone','$gender', '$age', 'SimpleUser')";
        $result = mysqli_query($conn,$sql);
            if ($result === TRUE) {
                $SignUpSucMessage = "Account created successfully";
            }
        } else {    $SignUpFailMessage = "Incorrect or Insufficient Data inserted"; }
        $conn->close();
     
}

function val_input($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
    <title>Onkel Felipe | Sign Up</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- Personal CSS & JavaScript -->
    <link rel="stylesheet" type="text/css" href="css/customcss.css">
    <script src="js & jquery/jquery.js"></script>
    <script>
        /*This function identifies the user of the page.
        *If he is an unregistered visitor the login & signup options will appear
        but in the case of a user, account & logout options will be shown*/
        $( document ).ready(function() {
            var userview = <?php echo json_encode($_SESSION['firstn']) ?>;

            if(userview != null){
            $("a[href='SignUp.php']").attr('href', 'Account.php');    
            $("a[href='Login.php']").attr('href', 'Logout.php');
            }
        });
    </script> 
    <style>
        .error {color: #FF0000;}
    </style>
</head>

<body>
     
<div class="container-fluid">
 
        <!-- Navbar -->
        <!-- Reference: W3Schools http://www.w3schools.com/bootstrap/bootstrap_navbar.asp-->
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
                <a class="navbar-brand" href="Index.php">Onkel Felipe</a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="Menu.php">Menu</a></li>
                    <li><a href="AboutUs.php">About Us</a></li>
                    <li><a href="ContactUs.php">Contact Us</a></li>
                    <li><a href="Reservations.php">Reservations</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="SignUp.php"><span class="glyphicon glyphicon-user"></span><?php if(isset($_SESSION['accountType'])) {echo " Account";} else {echo " SignUp";}?></a></li>
                    <li><a href="Login.php"><span class="glyphicon glyphicon-log-in"></span><?php if(isset($_SESSION['accountType'])) {echo " Logout";} else {echo " Login";}?></a></li>
                </ul>
            </div>
          </div>
        </nav>
    
<!--image credit: SnowBrains.com-->     
    <div class="row">     
        <div class="col-md-4"></div>
        <div class="col-md-4 hidden-xs hidden-sm"><a href ="index.php"><img class="img-responsive" src="images/4pints.png"></a></div>
        <div class="col-md-4"></div>
    </div> 
	
<!-- form -->   
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">  
            <div class="wrapper">
                <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="firstn">First Name:</label>
                        <div class="col-sm-6"> 
                        <input type="text" class="form-control" name="firstn" placeholder="Enter First Name">
                        </div>
                        <div class="col-sm-2"></div>
                        <span class="error"><?php echo $firstnError;?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="lastn">Last Name:</label>
                        <div class="col-sm-6"> 
                        <input type="text" class="form-control" name="lastn" placeholder="Enter Last Name">
                        </div>
                        <div class="col-sm-2"></div>
                        <span class="error"><?php echo $lastnError;?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="email">E-mail:</label>
                        <div class="col-sm-6">
                        <input type="email" class="form-control" name="email" placeholder="Enter e-mail">
                        </div>
                        <div class="col-sm-2"></div>
                        <span class="error"><?php echo $emailError;?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="pwd">Password:</label>
                        <div class="col-sm-6"> 
                        <input type="password" class="form-control" name="pwd" placeholder="Must Contain 1 capital , 1 number and be at least 8 chars long">
                        </div>
                        <div class="col-sm-2"></div>
                        <span class="error"><?php echo $pwdError1;?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="conpwd">Confirm Password:</label>
                        <div class="col-sm-6"> 
                        <input type="password" class="form-control" name="conpwd" placeholder="Confirm Password">
                        </div>
                        <div class="col-sm-2"></div>
                        <span class="error"><?php echo $pwdError2;?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="phonenum">Phone Number:</label>
                        <div class="col-sm-6"> 
                        <input type="text" class="form-control" name="phonenum" placeholder="Enter Phone Number">
                        </div>
                        <div class="col-sm-2"></div>
                        <span class="error"><?php echo $phoneError;?></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="radio">Gender:</label>
                        <div class="col-sm-6">
                            <label class="radio-inline"><input type="radio" name="gender" value="Male">Male</label>
                            <label class="radio-inline"><input type="radio" name="gender" value="Female">Female</label>
                            <label class="radio-inline"><input type="radio" name="gender" value="Other">Other</label>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4" for="radio2">Age Group:</label>
                        <div class="col-sm-6">
                            <label class="radio-inline"><input type="radio" name="age" value="18-25">18-25</label>
                            <label class="radio-inline"><input type="radio" name="age" value="26-35">26-35</label>
                            <label class="radio-inline"><input type="radio" name="age" value="36-45">36-45</label>
                            <label class="radio-inline"><input type="radio" name="age" value="46-55">46-55</label>
                            <label class="radio-inline"><input type="radio" name="age" value="55+">55+</label>
                        </div>
                        
                        <div class="col-sm-2"></div>
                        <span class="error"><?php echo $ageError;?></span>
                    </div>
                    <?php
                    if(isset($SignUpSucMessage)){
                        echo '<div class="alert alert-success text-centered">' . 
                            $SignUpSucMessage .
                        '</div>';
                    }
                    if(isset($SignUpFailMessage)){
                        echo '<div class="alert alert-danger text-centered">' . 
                            $SignUpFailMessage .
                        '</div>';
                    }
                    ?>
                     <div class="form-group"> 
                        <div class="col-sm-offset-4 col-sm-6">
                            <button type="submit" class="btn btn-default">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>  
<!--end form--> 
</div>  


</body>
</html>