<?php
//begin the session
session_start();
//DB connector
include 'include/connector.php';

//check for open session else redirect
if(!isset($_SESSION['accountType']) || $_SESSION['accountType'] === "SimpleUser"){
    header("Location: Index.php");
}


$userid = $_SESSION['sessionid'];
if(isset($_SESSION['accountType'])){
$accType = $_SESSION['accountType'];  
}
$resId = null;

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
  <title>Onkel Felipe | Admin Page</title>
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
            /* Styling for the res_details modal - Reference:https://www.w3schools.com/howto/howto_css_modals.asp */
            /* The Modal (background) */
            .modal {
                display: none; /* Hidden by default */
                position: fixed; /* Stay in place */
                z-index: 1; /* Sit on top */
                left: 0;
                top: 0;
                width: 100%; /* Full width */
                height: 100%; /* Full height */
                overflow: auto; /* Enable scroll if needed */
                background-color: rgb(0,0,0); /* Fallback color */
                background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            }

            /* Modal Content/Box */
            .modal-content {
                background-color: #fefefe;
                margin: 15% auto; /* 15% from the top and centered */
                padding: 20px;
                border: 1px solid #888;
                width: 80%; /* Could be more or less, depending on screen size */
            }

            /* The Close Button */
            .close {
                color: #aaa;
                float: right;
                font-size: 28px;
                font-weight: bold;
            }

            .close:hover,
            .close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
            }
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



        <!-- reservation history tab -->
        <div class="col-md-0" style="margin-top: 15px;"></div>
        <div class="col-md-12" style="margin-top: 15px;">
            <div class="wrapperCon">
                <h2 class="text-center">Reservation History</h2>
                <hr>
                <table class="table table-hover">
                    <thead>
                        <th>Reservation ID</th>
                        <th>User ID</th>
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
                $sql4 = "SELECT RESERVEID, USERID, TABLEID, TABLE2, TABLE3, RESMADEIN, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA FROM RESERVATIONS ORDER BY RESDATE ASC, RESTIME ASC";
                $result4 = mysqli_query($conn, $sql4);
                if(mysqli_num_rows($result4) > 1){
                    while($row = mysqli_fetch_assoc($result4)){
                        echo '<tr>';
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
                <button id="myBtn">See Reservation details</button>
                <!-- The Reservation Modal -->
                <div id="myModal" class="modal">

                    <!-- Modal content -->
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <form method="POST">
                            <div class="form-group">
                            <label for="resId"><b> Reservation ID:</b></label>
                            <input type="text" name="resId" required>
                            </div>

                            <button type="submit" class="btn btn-default">Submit</button>    
                        </form>
                    </div>
                </div>

                <?php
                //preparing the data that will update the attendance field in the DB
                if(isset($_POST['resId'])){
                $resId = val_input($_POST['resId']);
                }

                $sqlResDet = "SELECT * FROM res_details WHERE RESID = '$resId'";
                $resultResDet = mysqli_query($conn,$sqlResDet);
                echo "<center><h2>Reservation Details For Selected Row</h2></center>" . "<br>" . "<hr>" . "<br>";
                echo "<ul>";
                while($row = mysqli_fetch_assoc($resultResDet)){
                    echo    "<li> Reservation Details ID: " . $row["RESDETID"]. "</li>" . "<br>" . 
                            "<li> Reservation ID: " . $row["RESID"] . "</li>" . "<br>" . 
                            "<li> Party Size: " . $row["PARTY"] . "</li>" . "<br>" . 
                            "<li> First Name: " . $row["FIRSTNAME"] . "</li>" . "<br>" . 
                            "<li> Last Name: " . $row["LASTNAME"] . "</li>" . "<br>" .
                            "<li> Email: " . $row["EMAIL"] . "</li>" . "<br>" .
                            "<li> Telephone: " . $row["PHONE"]. "</li>" . "<br>" .
                            "<li> Occasion: " . $row["OCCASION"]. "</li>" . "<br>" .
                            "<li> Requests/Comments : " . $row["REQUESTS"] . "</li>" . "<br>" ;  
                }
                echo "</ul>";
                ;
                ?>

                <script>
                // Get the modal
                var modal = document.getElementById('myModal');

                // Get the button that opens the modal
                var btn = document.getElementById("myBtn");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];

                // When the user clicks on the button, open the modal 
                btn.onclick = function() {
                    modal.style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }

                </script>
            </div>
        </div>
        <div class="col-md-0" style="margin-top: 15px;"></div> 

</body>
</html>