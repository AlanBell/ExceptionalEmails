<?php
$to="alanbell@ubuntu.com";
$subject="a subject";
$message="test";
$headers = 'From: exceptional@exceptionalemails.com' . "\r\n" .
    'Reply-To: nobody' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
mail ( $to , $subject , $message,$headers );
?>
