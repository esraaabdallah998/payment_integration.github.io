<?php

//Include Configuration File
include_once 'config.php';

//Include Database Connection File
include_once 'db_con.php';

/*
Read Post Data
Reading posted data directly from $_POST causes serialization
Issues with array data in POST
Reading raw POST data from input stream intend.
*/

$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();

foreach($raw_post_array as $keyval){
    $keyval = explode('=', $keyval);
    if(count($keyval) == 2)
        $myPost[$keyval[0]] = urldecode($keyval[1]);
}

//Read the post from paypal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')){
    $get_magic_quotes_exists = true;
}

foreach($myPost as $key => $value){
    if($get_magic_quotes_exists == true){
        $value = urlencode(stripslashes($value));
    }else{
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}

/*
Post IPN data back to paypal to validate the IPN data is genuine
Without this step anyone can fake IPN data
*/

$paypalURL = PAYPAL_URL;
$ch = curl_init($paypalURL);
if($ch == FALSE){
    return FALSE;
}

curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSLVERSION, 6);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

//Set TCP timeout to 30 seconds
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
$res = curl_exec($ch);

/*
Inspect IPN validation result and act accordingly 
Split response headers and payload, a better way for strcmp
*/

$tokens = explode("\r\n\r\n", trim($res));
$res = trim(end($tokens));

if(strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0){

    //Retrive transaction infro from paypal
    $donor_name = $_POST['name'];
    $donor_email = $_POST['email'];
    $amount = $_POST['amount'];
    $currency_code = $_POST['mc_currency'];
    $payment_status = $_POST['payment_status'];

    //Check if transation data exists with the same TXN ID
    $prevPayment = $db->query("SELECT donation_id FROM donations WHERE donor_email = '".$donor_email."'");

    if($prevPayment->num_rows > 0){
        exit();
    }else{
        //Insert transaction data into the database
        $insert = $db->query("INSERT INTO donations(donor_name,donor_email,amount,currency_code,status) VALUES('" . $donor_name . "','" . $donor_email . "','" . $amount . "','" . $currency_code . "','" . $payment_status . "')");
    }

}