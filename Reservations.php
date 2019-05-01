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
    <title>Onkel Felipe | Reservations</title>
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
        <!--JQuery UI Datepicker Reference:https://jqueryui.com/datepicker/ -->
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
            $( function() {
                $( "#datepicker" ).datepicker();
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

<!--image credit: clipartbest.com-->     
    <div class="row">     
        <div class="col-md-4"></div>
        <div class="col-md-4 hidden-xs hidden-sm"><a href ="index.php"><img class="img-responsive" src="images/ResBeer.png"></a></div>
        <div class="col-md-4"></div>
    </div></br>
	
<!-- form -->   
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">  
            <div class="wrapper">
                <form class="form-horizontal" action="ResHandler.php" method="POST">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="select">Date:</label>
                    <div class="col-sm-6">
                    <input name="dateofres" id="datepicker" required>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
			
                <div class="form-group">
                    <label class="control-label col-sm-4" for="select2">Time:</label>
                    <div class="col-sm-6">
                    <select class="form-control" name="timeofres" required>
                            <option>16:00</option>
                            <option>17:00</option>
                            <option>18:00</option>
                            <option>19:00</option>
                            <option>20:00</option>
                            <option>21:00</option>
                    </select>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
				
                <div class="form-group">
                    <label class="control-label col-sm-4" for="select3">Party Size:</label>
                    <div class="col-sm-6">
                        <select class="form-control" name="PartySize" required>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>>12: Please contact us at (+30)210.5566777</option>
                        </select>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="fname">First Name:</label>
                    <div class="col-sm-6"> 
                    <input type="name" class="form-control" name="fname" placeholder="Enter First Name" required>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="lname">Last Name:</label>
                    <div class="col-sm-6"> 
                    <input type="name" class="form-control" name="lname" placeholder="Enter Last Name" required>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="email">E-mail:</label>
                    <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" placeholder="Enter e-mail" required>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="phonenum">Phone Number:</label>
                    <div class="col-sm-6"> 
                    <input type="text" class="form-control" name="phonenum" placeholder="Enter Phone Number" required>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="radio">Smokers:</label>
                    <div class="col-sm-6">
                        <label class="radio-inline"><input type="radio" name="smoke" value="yes" required>Yes</label>
                        <label class="radio-inline"><input type="radio" name="smoke" value="no">No</label>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
		<div class="form-group">
                    <label class="control-label col-sm-4" for="radio2">Pick Occasion:</label>
                    <div class="col-sm-6">
			<label class="radio-inline"><input type="radio" name="occasion" value="visit" required>Just A Visit</label>
                        <label class="radio-inline"><input type="radio" name="occasion" value="bday">Birthday</label>
                        <label class="radio-inline"><input type="radio" name="occasion" value="anniv">Anniversary</label>
                        <label class="radio-inline"><input type="radio" name="occasion" value="backelor">Bachelor Party</label>
			<label class="radio-inline"><input type="radio" name="occasion" value="thanksgiving">To Say Thanks</label>
                    </div>
                    <div class="col-sm-2"></div>
                </div>
                <?php  
                if(isset($_SESSION['accountType']) && $_SESSION['accountType'] === "Admin"){
                echo '<div class="form-group">
                    <label class="control-label col-sm-4" for="reserved-via">Reserved Via:</label>
                        <label class="radio-inline"><input type="radio" name="reserved-via" value="Website" required>Website</label>
			<label class="radio-inline"><input type="radio" name="reserved-via" value="Telephone">Telephone</label>
                </div>';
                }
                ?>
                <div class="form-group">
                        <label class="control-label col-sm-4" for="comment">Special Requests:</label>
                        <div class="col-sm-6">
                        <textarea class="form-control" rows="5" name="comment" placeholder="Type here any special requests"></textarea>
                        </div>
                        <div class="col-sm-2"></div>
                </div>

                <div class="form-group"> 
                    <div class="col-sm-offset-4 col-sm-6">
                        <button type="submit" class="btn btn-default" <?php if (!isset($_SESSION['sessionid'])){ ?> disabled title="Please Login or Sign up" <?php ;} ?> >Submit</button>
                    </div>
                </div>
            </form>
        </div>
        </div>
        </div>
        <div class="col-md-3"></div>
    </div>  
<!--end form-->
    
</body>
</html>