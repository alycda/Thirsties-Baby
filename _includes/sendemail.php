<?php
if($_SERVER['REQUEST_METHOD'] != "POST"){
   echo("Unauthorized attempt to access page.");
   exit;
}

$mailTo = $_POST['emailTo'];
$mailFrom = $_POST['fromName'].' <'.$_POST['emailFrom'].'>';
$subject = $_POST['subject'];
$message = $_POST['message'];
		
mail($mailTo.', alyssa@nikkelkrome.com', $subject, $message, "From: ".$mailFrom); ?>
 
 
 <?php
// multiple recipients
$to  = 'alyda@me.com' . ', '; // note the comma
$to .= 'alyssa@nikkelkrome.com';

// subject
$subject = 'Birthday Reminders for August';

// message
$message = '
<html>
<head>
  <title>Birthday Reminders for August</title>
</head>
<body>
  <p>Here are the birthdays upcoming in August!</p>
  <table>
    <tr>
      <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
    </tr>
    <tr>
      <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
    </tr>
    <tr>
      <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
    </tr>
  </table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Additional headers
$headers .= 'To: Mary <alyssa@youneedtherapy.tv>, Kelly <nachosyumm@gmail.com>' . "\r\n";
$headers .= 'From: Birthday Reminder <birthday@example.com>' . "\r\n";
//$headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
//$headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

// Mail it
if(mail($to, $subject, $message, $headers)) {
	echo"worked";	
} else {
	echo "something went wrong";
} ?>