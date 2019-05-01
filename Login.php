<?php
//session start
session_start();
//DB connection
include 'include/connector.php';

//check for open session else redirect
if(isset($_SESSION['accountType']) && $_SESSION['accountType'] === "SimpleUser"){
    header("Location: Index.php");
}
if(isset($_SESSION['accountType'])){
$accType = $_SESSION['accountType'];  
}

//define variables ans set to empty values
$emailError = $pwdError = "";
$email = $pwd = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    //email validation
    if(empty($_POST["email"])){
        $emailError= "E-mail is required";
    } 
    else{
        $email = val_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailError = "Invalid email format"; 
        }
    }
    
    //pwd validation
    if(empty($_POST["pwd"])){
        $pwdError = "password is required";
    } 
    else{
        $pwd = val_input($_POST["pwd"]);
        if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/', $pwd)) {
            $pwdError = "the password does not meet the requirements!";
        }
    }

    $sql = "SELECT * FROM users WHERE EMAIL = '$email' AND PASSWORD = '$pwd' ";
    $result = mysqli_query($conn, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            $_SESSION['accountType'] = $row['ISADMIN'];
            $_SESSION['firstn'] = $row['FIRSTNAME'];
            $_SESSION['lastn'] = $row['LASTNAME'];
            $_SESSION['sessionid'] = $row['USERID'];
            $_SESSION['sessionEmail'] = $row['EMAIL'];
            $_SESSION['sessionPhone'] = $row['PHONE'];
            $_SESSION['sessionPassword'] = $row['PASSWORD'];
            if($_SESSION['accountType'] === "Admin"){
            header("Location: AdminPage.php");
            }else if($_SESSION['accountType'] === "SimpleUser"){
                header("Location: index.php");
                }
            }
            
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
  <title>Onkel Felipe | Login</title>
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
                    <?php
                        if(isset($_SESSION['accountType']) && $accType === "Admin"){
                    ?>
                    <li><a href="AdminPage.php">Administrator's Page</a></li>
                    <?php
                        ;}
                    ?>
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
                    <label class="control-label col-sm-4" for="email">E-mail:</label>
                    <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" placeholder="Enter e-mail">
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="pwd">Password:</label>
                    <div class="col-sm-6"> 
                    <input type="password" class="form-control" name="pwd" placeholder="Enter Password">
                    </div>
                    <div class="col-sm-2"></div>
                </div>
          
                <div class="form-group"> 
                    <div class="col-sm-offset-4 col-sm-6">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </div>
            </form>

            <div class="col-md-3"></div>
            </div>
        </div>  
    </div>
    
  
    
    
</body>
</html>

