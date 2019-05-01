<?php
//begin the session
session_start();
//DB connector
include 'include/connector.php';
if(isset($_SESSION['accountType'])){
$accType = $_SESSION['accountType'];  
}

//check for open session else redirect
if(!isset($_SESSION['accountType'])){
    header("Location: Index.php");
}

$userid = $_SESSION['sessionid'];

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
  <link rel="stylesheet" type="text/css" href="css/customcss.css">
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

                <div class="wrapperCon">
                    <h2 class="text-center">Personal Information</h2>
                    <hr>
                    <ul>
                        <?php 
                        
                        //Query for selectting the current user of the application
                        $sql = "SELECT FIRSTNAME, LASTNAME, EMAIL, PASSWORD, PHONE, GENDER, AGE, ISADMIN FROM users WHERE USERID = '$userid' ";
                        $result = mysqli_query($conn, $sql);
                                // output data row found
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo    "<li> Name: " . $row["FIRSTNAME"]. "<br>" . 
                                            "<li> Lastname: " . $row["LASTNAME"] . "<br>" . 
                                            "<li> E-mail: " . $row["EMAIL"] . "<br>" . 
                                            "<li> Password: " . $row["PASSWORD"] . "<br>" . 
                                            "<li> Telephone: " . $row["PHONE"] . "<br>" .
                                            "<li> Gender: " . $row["GENDER"] . "<br>" .
                                            "<li> Age: " . $row["AGE"]. "<br>" ;
                                    if($row["ISADMIN"] === "Admin"){
                                        echo "<li> Account Type: " . $row["ISADMIN"] . "</li>" ."<br>" ;
                                    }
                                }
                        ?>
                    </ul>  
                </div>


            <div class="col-md-0" style="margin-top: 15px;"></div>
            <div class="col-md-12" style="margin-top: 15px;">
                <div class="wrapperCon">
                    <h2 class="text-center">Reservation History</h2>
                    <hr>
                    <table class="table table-hover">
                        <thead>
                            <th>Reservation ID</th>
                            <th>Table #1</th>
                            <th>Table #2</th>
                            <th>Table #3</th>
                            <th>Reservation Made on</th>
                            <th>Reservation Date</th>
                            <th>Arrival</th>
                            <th>Departure</th>
                            <th>Reserved from</th>
                            <th>Reserved via</th>
                        </thead>
                        <tbody id="myTable"></tbody>
                    <?php
                    $sql4 = "SELECT RESERVEID, TABLEID, TABLE2, TABLE3, RESMADEIN, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA FROM RESERVATIONS WHERE USERID = '$userid' ORDER BY RESDATE ASC, RESTIME ASC";
                    $result4 = mysqli_query($conn, $sql4);
                    if(mysqli_num_rows($result4) >  1){
                        while($row = mysqli_fetch_assoc($result4)){
                            echo '<tr class="numOfRows">';
                                foreach($row as $field) {
                                    if($field === null){
                                        echo '<td>' .  " - " . '</td>'; 
                                    }else{
                                    echo '<td>' . htmlspecialchars($field) . '</td>';
                                    }
                                }
                            echo '</tr>';
                        }
                    
                    }else{
                        echo "<center><b><i>No Reservation history available!</i></b></center>";
                    }
                   
                    ?>
                        </tbody>
                    </table>   
                </div>
            </div>
            <div class="col-md-0" style="margin-top: 15px;"></div> 