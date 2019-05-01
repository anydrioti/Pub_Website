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
        <title>Onkel Felipe | Home</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Link to Bootstrap CSS & JavaScript -->
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


           <!--Carousel--> 


                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div id="myCarousel" class="carousel slide" data-ride="carousel">

                    <!-- Indicators -->

                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                         <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">

                        <div class="item active">
                                        <!--credit: sobify.com-->
                            <img src="images/c1.png" alt="Huge Beer Collection">
                            <div class="carousel-caption">
                                <h3>Our Collection</h3>
                                <p>A great collection of beer to choose from</p>
                            </div>
                        </div>

                        <div class="item">
                            <!--credit: domainhudson.com-->
                            <img src="images/c2.png" alt="Deli Meat Variety" class="img-responsive">
                            <div class="carousel-caption">
                                <h3>Deli, Cheese & Meet</h3>
                                <p>A wide variety to enjoy with your beer</p>
                            </div>
                        </div>

                        <div class="item">
                                        <!--credit: el-studio.ro-->
                            <img src="images/c3.png" alt="Barrel Aged Beer">
                            <div class="carousel-caption">
                                <h3>Unmatched Quality</h3>
                                <p>Enjoy the unique taste of our barrel aged beer</p>
                            </div>
                        </div>

                        <div class="item">
                                        <!--credit: pinterest.com-->
                            <img src="images/c4.png" alt="Real Food">
                            <div class="carousel-caption">
                                <h3>Real Food</h3>
                                <p>Witness unforgettable taste experiences</p>
                            </div>
                        </div>
                    </div>


                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>

                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                <div class="col-md-3"></div>
            </div>
            <div class="container-fluid" style="margin-top: 20cm;">
                <div class="col-md-5"></div>
                <div class="col-md-1">
                    <div class="col-md-1"></div>
                    <div class="col-md-0">
                    <center><a href="Reservations.php"<button class="btn btn-default" style="width:240px;">Make Reservation</button></a></center>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </body>
</html>
