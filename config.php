<?php 
/* 
 * This is - PayPal and database configuration -  
*/ 
  
// PayPal configuration 
define('PAYPAL_ID', 'marchant_22@business.com'); 
define('PAYPAL_SANDBOX', FALSE); //TRUE or FALSE 
 
define('PAYPAL_RETURN_URL', 'http://localhost/course_n3ml\payment_gataway_integration/paypal_success.php'); 
define('PAYPAL_CANCEL_URL', 'http://localhost/course_n3ml\payment_gataway_integration/paypal_cancel.php'); 
define('PAYPAL_NOTIFY_URL', 'http://localhost/course_n3ml\payment_gataway_integration/ipn.php'); 
define('PAYPAL_CURRENCY', 'EGY'); 

// Database configuration 
define('DB_HOST', 'localhost'); 
define('DB_USERNAME', 'root'); 
define('DB_PASSWORD', ''); 
define('DB_NAME', 'donation_paypal'); 

// Change not required 
define('PAYPAL_URL', (PAYPAL_SANDBOX == true)?"https://www.sandbox.paypal.com/cgi-bin/webscr":"https://www.paypal.com/cgi-bin/webscr");

// [ b_boy@gmail.com ]