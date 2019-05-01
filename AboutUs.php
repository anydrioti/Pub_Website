<?php
//begin the session
session_start();
//DB connector
include 'include/connector.php';
if(isset($_SESSION['accountType'])){
$accType = $_SESSION['accountType'];  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Onkel Felipe | About Us</title>
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
    
<!-- About Us info -->   
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="wrapper">
            
                <h2><center><b>Few Words About Us!</b></center></h2><br>
			<p><center><b><i>Felipe Industries is a company with heavy influence over the food market<br>
                            We Have Over a Hundred different kinds of beer<br>
                            We are proud to offer you a seat in our tables<br>
                        Join Us!!! &nbsp-Felipe</i></b></center>
                        
                        
                        </p>
                   
            </div>
		</div>
		<div class="col-md-3"></div>  
    </div>

    
</body>
</html>