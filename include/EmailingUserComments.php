<?php
//Reference:http://www.freecontactform.com/email_form.php

if(isset($_POST['emailsender'])) {
 
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
 
    $email_to = "amaryllisndrt@yahoo.gr";
 
    $email_subject = $_POST['subject'];
 

    function died($error) {
 
        // your error code can go here
 
        echo "We are very sorry, but there were error(s) found with the form you submitted. ";
 
        echo "These errors appear below.<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['subject']) ||
 
        !isset($_POST['details']) ||
 
        !isset($_POST['emailsender'])
            
      ) 
        
        {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');       
 
    }
 
 
    $subject = $_POST['subject']; // required
    
    $email_from = $_POST['emailsender']; // required
 
    $details = $_POST['details']; // not required
 

 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
 
  if(strlen($details) < 2) {
 
    $error_message .= 'The Comments you entered do not appear to be valid.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Form details below.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "Topic: ".clean_string($subject)."\n";
 
    $email_message .= "Details: ".clean_string($details)."\n";
 
     
 
     
 
// create email headers
 
$headers = 'From: '.$email_from."\r\n".
 
'Reply-To: '.$email_from."\r\n" .
 
'X-Mailer: PHP/' . phpversion();
 
@mail($email_to, $email_subject, $email_message, $headers);  
 
?>
 
 
 
<!-- Success Message and redirection back to home -->
Thank you for contacting us. We will be in touch with you very soon.<br>
You will be redirected back in a moment...
<script>
window.setTimeout(function() {
    window.location = '../index';
  }, 4000);
</script>
  
<?php

}
 
?>



