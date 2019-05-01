<?php
//session start
session_start();
//DataBase connection
include 'include/connector.php';

//check for open session else redirect
if(!isset($_SESSION['accountType'])){
    header("Location: Index.php");
}

if(isset($_SESSION['accountType'])){
$accType = $_SESSION['accountType'];  
}

//settings date & time variables
date_default_timezone_set("Europe/Athens"); 
$today = date("m/d/Y");

//variables sent from the form
$ReservationDate = date($_POST['dateofres']);
$ReservationTime = val_input($_POST['timeofres']);
$ReservationEndTime = date("G:i",strtotime('+2 hours',strtotime($ReservationTime)));
$ReservationPartySize = val_input($_POST['PartySize']);
$ReservationFName = val_input($_POST['fname']);
$ReservationLName = val_input($_POST['lname']);
$ReservationEmail = val_input($_POST['email']);
$ReservationPhoneNum = val_input($_POST['phonenum']);
$ReservationSmoke = val_input($_POST['smoke']);
$ReservationOccasion = val_input($_POST['occasion']);
$ReservationComments = val_input($_POST['comment']);
$ReservationOperator = null;
$ReservationWay = null;

if($_SESSION['accountType'] === "Admin"){
    $ReservationOperator = "Admin";
}elseif($_SESSION['accountType'] === "SimpleAcc"){
    $ReservationOperator = "Self";
}

if(isset($_POST['reserved-via'])){
   $ReservationWay = val_input($_POST['reserved-via']) ;
}
//variables for reservations
$availTabs = array();
$firstReservationTable = 0;
$secondReservationTable = 0;
$thirdReservationTable = 0;
$reservationUserID = $_SESSION['sessionid'];
//messages for showing the results of the reservation attempt
$SuccessMessage;
$ErrorMessage;
//variables that store the results of the availability query
$tableOne;
$tableTwo;
$tableThree;

//finding out the available tables based on the reservations located at the selected time
$sqlAvailability = "SELECT TABLEID FROM reservations WHERE RESDATE = '$ReservationDate' AND RESDATE = '$ReservationTime'";
$resultAvailability = mysqli_query($conn, $sqlAvailability);
    while ($row = mysqli_fetch_assoc($resultAvailability)) {
        $tableOne = $row['TABLEID'];
        $tableTwo = $row['TABLE2'];
        $tableThree = $row['TABLE3'];
        $sqlAvailUpdate = "UPDATE tables SET STATUS = 'Unavailable' WHERE TABLEID = '$tableOne' OR TABLE2 = '$tableTwo' OR TABLE3 = '$tableTwo'";
        $resultAvailUpdate = mysqli_query($conn, $sqlAvailUpdate);
    }

//checking if the date are coming from the form that was submitted with post method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //switch statement that will examine the smoking habits of the reservation
    switch($ReservationSmoke){
        case "yes":
            switch($ReservationPartySize){
                case 1:
                case 2:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND SEATS = 2 AND SECTIONID = 1";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 2 AND SECTIONID = 1";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $firstReservationTable = $availTabs[array_rand($availTabs)];

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlThree = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', null, null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultThree = mysqli_query($conn,$sqlThree);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFour = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    //in case of succes, storing a success message
                                        if ($resultThree === TRUE && $resultFour === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlThree = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', null, null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultThree = mysqli_query($conn,$sqlThree);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFour = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    //in case of succes, storing a success message
                                        if ($resultThree === TRUE && $resultFour === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                         //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                    break;
                case 3:
                case 4:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $firstReservationTable = $availTabs[array_rand($availTabs)];

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlThree = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', null, null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultThree = mysqli_query($conn,$sqlThree);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFour = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    //in case of succes, storing a success message
                                        if ($resultThree === TRUE && $resultFour === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlThree = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', null, null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultThree = mysqli_query($conn,$sqlThree);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFour = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    //in case of succes, storing a success message
                                        if ($resultThree === TRUE && $resultFour === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                    break;
                case 5:
                case 6:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND (SEATS = 2 OR SEATS = 4) AND SECTIONID = 1";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 2 AND SECTIONID = 1";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $firstReservationTable = $availTabs[array_rand($availTabs)];
                                echo $firstReservationTable;
                                //array cleaning from 2 chair tables, then filling with 4 chair tables
                                $availTabs = array();
                                $sqlThree = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                                $resultThree = mysqli_query($conn, $sqlThree);
                                while ($row = mysqli_fetch_assoc($resultThree)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $secondReservationTable = $availTabs[array_rand($availTabs)];
                                echo$secondReservationTable ; 

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                    break;
                case 7:
                case 8:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $firstReservationTable = $availTabs[array_rand($availTabs)];
                                
                                //array cleaning from 2 chair tables, then filling with 4 chair tables
                                $availTabs = array();
                                $sqlThree = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                                $resultThree = mysqli_query($conn, $sqlThree);
                                while ($row = mysqli_fetch_assoc($resultThree)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                if(($key = array_search($firstReservationTable, $availTabs)) !== false) {
                                    unset($availTabs[$key]);
                                }
                                $secondReservationTable = $availTabs[array_rand($availTabs)];
                                

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                               //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                case 9:
                case 10:
                case 11:
                case 12:  
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                //setting table 1
                                $firstReservationTable = $availTabs[array_rand($availTabs)];
                                
                                //array cleaning from 2 chair tables, then filling with 4 chair tables
                                $availTabs = array();
                                $sqlThree = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                                $resultThree = mysqli_query($conn, $sqlThree);
                                while ($row = mysqli_fetch_assoc($resultThree)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                //looking for the first reservation table and deleting it to avoid duplicate values
                                if(($key = array_search($firstReservationTable, $availTabs)) !== false) {
                                    unset($availTabs[$key]);
                                }
                                //setting table 2
                                $secondReservationTable = $availTabs[array_rand($availTabs)];
                                
                                //array cleaning from 2 chair tables, then filling with 4 chair tables
                                $availTabs = array();
                                $sqlThree = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                                $resultThree = mysqli_query($conn, $sqlThree);
                                while ($row = mysqli_fetch_assoc($resultThree)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                //checking for both table 1 and 2 in current reservation for duplicate values then removing them
                                if(($key = array_search($secondReservationTable, $availTabs)) !== false) {
                                    unset($availTabs[$key]);
                                }
                                if(($key = array_search($firstReservationTable, $availTabs)) !== false) {
                                    unset($availTabs[$key]);
                                }
                                //setting table 3
                                $thirdReservationTable = $availTabs[array_rand($availTabs)];

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', '$thirdReservationTable', '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', '$thirdReservationTable', '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                    break;
            }
        break;
        case "no":
            switch($ReservationPartySize){
                case 1:
                case 2:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND SEATS = 2 AND SECTIONID = 2";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 2 AND SECTIONID = 2";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $firstReservationTable = $availTabs[array_rand($availTabs)];

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlThree = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', null, null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultThree = mysqli_query($conn,$sqlThree);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFour = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    //in case of succes, storing a success message
                                        if ($resultThree === TRUE && $resultFour === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlThree = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', null, null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultThree = mysqli_query($conn,$sqlThree);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFour = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    //in case of succes, storing a success message
                                        if ($resultThree === TRUE && $resultFour === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                         //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Cant make a reservation sooner than now " . "(Inserted Time is " . $ReservationTime . ") & (Current Time is " . date("G:i") . ")";
                                    }
                                }else{
                                    $ErrorMessage = "Cant make reservation before today" . "(Inserted Date is " . $ReservationDate . ") & " . "(Current Date is " . $today . ")" . "<br>";
                                }            
                            } else {
                                $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime. "). <br> Try another visit hour please!" ;
                            }
                    break;
                case 3:
                case 4:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $firstReservationTable = $availTabs[array_rand($availTabs)];

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlThree = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', null, null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultThree = mysqli_query($conn,$sqlThree);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFour = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    //in case of succes, storing a success message
                                        if ($resultThree === TRUE && $resultFour === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlThree = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', null, null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultThree = mysqli_query($conn,$sqlThree);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFour = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    //in case of succes, storing a success message
                                        if ($resultThree === TRUE && $resultFour === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                                //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                    break;
                case 5:
                case 6:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND (SEATS = 2 OR SEATS = 4) AND SECTIONID = 2";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 2 AND SECTIONID = 2";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $firstReservationTable = $availTabs[array_rand($availTabs)];
                                echo$firstReservationTable;
                                //array cleaning from 2 chair tables, then filling with 4 chair tables
                                $availTabs = array();
                                $sqlThree = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                                $resultThree = mysqli_query($conn, $sqlThree);
                                while ($row = mysqli_fetch_assoc($resultThree)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $secondReservationTable = $availTabs[array_rand($availTabs)];
                                echo$secondReservationTable;

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                                 //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                    break;
                case 7:
                case 8:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                $firstReservationTable = $availTabs[array_rand($availTabs)];
                                
                                //array cleaning from 2 chair tables, then filling with 4 chair tables
                                $availTabs = array();
                                $sqlThree = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                                $resultThree = mysqli_query($conn, $sqlThree);
                                while ($row = mysqli_fetch_assoc($resultThree)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                if(($key = array_search($firstReservationTable, $availTabs)) !== false) {
                                    unset($availTabs[$key]);
                                }
                                $secondReservationTable = $availTabs[array_rand($availTabs)];
                                

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', null, '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                                 //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                    break;
                case 9:
                case 10:
                case 11:
                case 12:
                        $sqlOne = "SELECT COUNT(*) as totnum FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                        $resultOne = mysqli_query($conn, $sqlOne);
                        $tables = mysqli_fetch_assoc($resultOne);
                            if($tables['totnum'] > 0){
                                //query for picking the table of the reservation  
                                $sqlTwo = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                                $resultTwo = mysqli_query($conn, $sqlTwo);
                                while ($row = mysqli_fetch_assoc($resultTwo)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                //setting table 1
                                $firstReservationTable = $availTabs[array_rand($availTabs)];
                                
                                //array cleaning from 2 chair tables, then filling with 4 chair tables
                                $availTabs = array();
                                $sqlThree = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 2";
                                $resultThree = mysqli_query($conn, $sqlThree);
                                while ($row = mysqli_fetch_assoc($resultThree)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                //looking for the first reservation table and deleting it to avoid duplicate values
                                if(($key = array_search($firstReservationTable, $availTabs)) !== false) {
                                    unset($availTabs[$key]);
                                }
                                //setting table 2
                                $secondReservationTable = $availTabs[array_rand($availTabs)];
                                
                                //array cleaning from 2 chair tables, then filling with 4 chair tables
                                $availTabs = array();
                                $sqlThree = "SELECT * FROM tables WHERE STATUS = 'Available' AND SEATS = 4 AND SECTIONID = 1";
                                $resultThree = mysqli_query($conn, $sqlThree);
                                while ($row = mysqli_fetch_assoc($resultThree)) {
                                    array_push($availTabs,$row['TABLEID']);
                                }
                                //checking for both table 1 and 2 in current reservation for duplicate values then removing them
                                if(($key = array_search($secondReservationTable, $availTabs)) !== false) {
                                    unset($availTabs[$key]);
                                }
                                if(($key = array_search($firstReservationTable, $availTabs)) !== false) {
                                    unset($availTabs[$key]);
                                }
                                //setting table 3
                                $thirdReservationTable = $availTabs[array_rand($availTabs)];

                               //validation for correct date/time inputs & reservation query
                                if(strtotime($ReservationDate) > strtotime($today)){
                                    //query to fill reservattions table
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', '$thirdReservationTable', '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                        //in case of failure, storing a success message
                                        else { $ErrorMessage = "No tables are available for " . $ReservationDate . " at the time you picked(" . $ReservationTime . "until" . $ReservationEndTime . "). <br> Try another visit hour please!"; }
                                }elseif(strtotime($ReservationDate) === strtotime($today)){
                                    if (strtotime(date("G:i")) < strtotime($ReservationTime)){
                                    $sqlFour = "INSERT INTO reservations (USERID, TABLEID, TABLE2, TABLE3, RESDATE, RESTIME, RESEND, CLOSEDBY, CLOSEDVIA)
                                        VALUES ('$reservationUserID', '$firstReservationTable', '$secondReservationTable', '$thirdReservationTable', '$ReservationDate', '$ReservationTime', '$ReservationEndTime', '$ReservationOperator', '$ReservationWay')";
                                    $resultFour = mysqli_query($conn,$sqlFour);
                                    $ReservationGenID = mysqli_insert_id($conn);
                                    //query to fill reservation details table
                                    $sqlFive = "INSERT INTO res_details (RESID, PARTY, FIRSTNAME, LASTNAME, EMAIL, PHONE, OCCASION, REQUESTS)
                                        VALUES ('$ReservationGenID', '$ReservationPartySize', '$ReservationFName', '$ReservationLName', '$ReservationEmail', '$ReservationPhoneNum', '$ReservationOccasion', '$ReservationComments')";
                                    $resultFive = mysqli_query($conn,$sqlFive);
                                    //in case of succes, storing a success message
                                        if ($resultFour === TRUE && $resultFive === TRUE) {
                                            $SuccessMessage = "reservation closed for " . $ReservationDate . $ReservationTime . "<br>";
                                        }
                                                   //in case of failure, storing a failure message
                                        else { $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!"; }
                                    }else{
                                        $ErrorMessage = "Can't make a reservation for a time passed ";
                                    }
                                }else{
                                    $ErrorMessage = "Can't make reservation before today";
                                }            
                            } else {
                                $ErrorMessage = "No tables for " . $ReservationDate . " at the time you picked <br> Try another visit hour please!" ;
                            }
                    break;
            }
        break;
    }
}
    //query for initializing the table availability after reservation is closed
    $sqlClear = "UPDATE tables SET status_id = 1";
    $result = mysqli_query($conn, $sqlClear);
    $conn->close();


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
                
        
        
        <?php
            if(isset($ErrorMessage)){
                echo '<div class="alert alert-danger text-centered">' . 
                    $ErrorMessage .
                '</div>';
            }elseif(isset($SuccessMessage)){
                echo '<div class="alert alert-success text-centered">' . 
                    $SuccessMessage .
                '</div>';
            }         
        ?>
        </div>
    </body>
</html>
