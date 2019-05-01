<?php 
// -------- Reference below ---------
// -------- PHP STORE HOURS ---------
// ---------- Version 1.1 -----------
// -------- BY CORY ETZKORN ---------
// -------- coryetzkorn.com ---------


// -------- EDIT FOLLOWING SECTION ONLY ---------

// Set your timezone (codes listed at http://php.net/manual/en/timezones.php)
// Delete the following line if you've already defined a timezone elsewhere.
date_default_timezone_set('Europe/Athens'); 

// Define daily open hours. Must be in 24-hour format, separated by dash.
$time_range_mon = '16.00-22.00';
$time_range_tue = '16.00-22.00';
$time_range_wed = '16.00-22.00';
$time_range_thu = '16.00-22.00';
$time_range_fri = '16.00-23.30';
$time_range_sat = '16.00-23.30';
$time_range_sun = '16.00-23.30';

// Place HTML for output here. Image paths or plain text (H1, H2, p) are all acceptable.
$open_output = '<strong style="color:#228B22"> "Come in, we\'re open!" </strong><br>';
$closed_output = '<strong style="color:#d9534f"> "Sorry, we\'re closed!" </strong><br>';

// OPTIONAL: Output current day's open hours 
$echo_daily_hours = true; // Switch to FALSE to hide numerical display of current hours
$time_output = 'g.ia'; // Enter custom time output format (options listed here: http://php.net/manua...nction.date.php)
$time_separator = ' until '; // Choose how to indicate range (i.e XX - XX, XX to XX, XX until XX)

// -------- END EDITING -------- 

// Gets current day of week
$status_today = date("D"); 

// Gets current time of day in 00:00 format
$current_time = date("G:i");
// Makes current time of day computer-readable
$current_time_x = strtotime($current_time);

// Builds an array, assigning user-defined time ranges to each day of week
$all_days = array("Mon" => $time_range_mon, "Tue" => $time_range_tue, "Wed" => $time_range_wed, "Thu" => $time_range_thu, "Fri" => $time_range_fri, "Sat" => $time_range_sat, "Sun" => $time_range_sun);
foreach ($all_days as &$each_day) {
    $each_day = explode("-", $each_day);
    $each_day[0] = strtotime($each_day[0]);
$each_day[1] = strtotime($each_day[1]);
}

// Defines array of possible days of week
$week_days = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");

// Compares current day of week to possible days of week and determines open vs closed output based on current day and time.
foreach ($week_days as &$each_week_day) {
if ($status_today == $each_week_day) {
echo '<div class="open-closed-sign"><div class="opening-times-title"></div>';
if (($all_days[$each_week_day][0] <= $current_time_x) && ($all_days[$each_week_day][1] >= $current_time_x)) {
echo $open_output;
} else {
echo $closed_output;
}
if ($echo_daily_hours) {
echo '<br /><strong class="opening-times-font">We are open today from <span class="time_output">';
echo date($time_output, $all_days[$each_week_day][0]) . $time_separator . date($time_output, $all_days[$each_week_day][1]);
}
echo '</div>';
} 
}
?> 



