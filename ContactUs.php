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
	<title>Onkel Felipe | Contact Us</title>
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


        <!-- Contact page content -->   
        <div class="container-fluid wrapperCon">
            <div class="col-md-6">
            <strong>We Are Here:</strong><br><br><br>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3144.85440892264!2d23.744795115791202!3d37.98052687972247!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14a1bd4f69eec063%3A0xda9a02edfc541b3f!2zzprOu861zr_OvM6tzr3Ov8-Fz4IgNTYsIM6RzrjOrs69zrEgMTA2IDc2!5e0!3m2!1sel!2sgr!4v1494178474799" 
                    width="90%"
                    height="260px" 
                    frameborder="0" style="border:0" allowfullscreen>  
                </iframe>
            </div>   

            <div class="col-md-6">
                <strong>Store Hours</strong><br><br>
                <br>
                <em>Mondays - Thursdays</em><br>
                16:00pm - 22:00pm<br><br>

                <em>Fridays - Sundays</em><br>
                16:00pm - 23:30pm<br><br>            

                <?php include 'include/Store_Hours.php';?>   
            </div>


            <div class="col-md-2"></div> 
            <div class="col-md-8" style="margin-left: 15%; margin-top: 5%;">
                <center><strong>LET IT BE KNOWN!!!<br>Your comments can make us better so don't hesitate!</strong></center><br><br>
                <form action="include/EmailingUserComments.php" method="post">
                        <div class="form-group">
                            <label for="subject"><b>Your Subject:</b></label>
                            <input type="text" name="subject" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="emailsender"><b>E-mail:</b></label>
                            <input type="text" name="emailsender" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="details"><b>Details:</b></label>
                            <textarea name="details" class="form-control"  cols="30" rows="8" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
            </div>    
            <div class="col-md-2"></div>        
        </div>
        <!--End of contact form-->  
    </body>
</html>