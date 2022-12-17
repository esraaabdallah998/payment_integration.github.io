<?php
//Include Configuration File
include_once 'config.php';

//Inlcude Database Connection File
include_once 'db_con.php';

//If Transaction Data is Available in the URL
if (!empty($_GET['name']) && !empty($_GET['email']) && !empty($_GET['amount']) && !empty($_GET['currency_code']) && !empty($_GET['status'])) {
    //Get Transaction Information from URL
    $donor_name = $_GET['name'];
    $donor_email = $_GET['email'];
    $amount = $_GET['amount'];
    $currency_code = $_GET['currency_code'];
    $payment_status = $_GET['status'];

    //Check if transaction data exists with the same TXN ID
    $donationResult = $db->query("SELECT * FROM donations WHERE donor_email = '" . $donor_email . "'");

    if ($prevPaymentResult->num_rows > 0) {
        $paymentRow = $prevPaymentResult->fetch_assoc();
        $donation_id = $paymentRow['donation_id'];
        $amount = $paymentRow['amount'];
        $payment_status = $paymentRow['status'];
    } else {
        //Insert transaction data into the database
        $insert = $db->query("INSERT INTO donations(donor_name,donor_email,amount,currency_code,status) VALUES('" . $donor_name . "','" . $donor_email . "','" . $amount . "','" . $currency_code . "','" . $payment_status . "')");
        $donation_id = $db->insert_id;
    }
}
?>
<?php include_once "partials/header.php" ?>
<div class="container">
    <div class="main">
        <div class="thanks-message text-center" id="text-message"> <img src="https://i.imgur.com/O18mJ1K.png" width="100" class="mb-4">
            <h3>successful Donation!</h3> <span>Your donation has been entered!</span>
        </div>
        <?php if (!empty($payment_id)) { ?>

            <h4>Payment Information</h4>
            <p><b>Reference Number:</b> <?php echo $payment_id; ?></p>
            <p><b>Transaction ID:</b> <?php echo $txn_id; ?></p>
            <p><b>Paid Amount:</b> <?php echo $payment_gross; ?></p>
            <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>

            <h4>Product Information</h4>
            <p><b>Name:</b> <?php echo $productRow['name']; ?></p>
            <p><b>Price:</b> <?php echo $productRow['price']; ?></p>
        <?php } else { ?>
            <h1 class="error">Your Payment has failed</h1>
            <div class="thanks-message text-center" id="text-message"> <img src="images/error.jpg" width="100" class="mb-4">
                <h3>Your Payment has failed!</h3>
            </div>
        <?php } ?>
    </div>
</div>
<?php include_once "partials/footer.php" ?>