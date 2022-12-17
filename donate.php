<?php
// require "Classes/UserValidator.php";

// if (isset($_POST['submit'])) {

//     // validate entries
//     $validation = new UserValidator($_POST);

//     $errors = $validation->validateForm();
//     // option to sava data to a database

// }
include_once 'config.php';
include_once 'db_con.php';
require "partials/header.php";
?>
<div class="container mt-5">
    <div class="row d-flex justify-content-center align-items-center">
        <div class="col-md-6">
            <form id="regForm" action="<?php echo PAYPAL_URL; ?>" method="POST">
                <h1 id="register">Donate</h1>
                <div class="all-steps" id="all-steps"> <span class="step"></span> <span class="step"></span> <span class="step"></span></div>
                <div class="tab">
                    <h3>Donation Amount:</h3>
                    <p><input type="text" placeholder="0.00 EGY" oninput="this.className = ''" name="amount"></p>
                </div>
                <div class="tab">
                    <p><input placeholder="full Name" oninput="this.className = ''" name="name"></p>
                    <p><input placeholder="Email" oninput="this.className = ''" name="email"></p>
                    <p><input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>"></p>
                    <p><input type="hidden" name="cmd" value="_xclick"></p>
                    <p><input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>"></p>
                    <p><input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>"></p>
                    <p><input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>"></p>

                </div>
                <div class="tab">
                    <div class="row justify-content-center align-items-center">
                        <h3 class="mb-5">Donation payment method:</h3>
                        <div class="col-6 mb-5">
                            <img src="images/paypal.png" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div style="overflow:auto;" id="nextprevious">
                    <div style="float:right;">
                        <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                        <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<?php require_once "partials/footer.php" ?>