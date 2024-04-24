<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    // Redirect the user to the login page if not logged in
    header("Location: index.html");
    exit(); // Stop executing the rest of the code
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card Form</title>
    <link rel="stylesheet" href="card.css">
</head>
<body>
    <form action="thankyou.php" method="post" id="paymentForm">
        <div class="wrapper" id="app">
            <div class="card-form">
                <div class="card-form__inner">
                    <div class="card-list">
                        <div class="card-item">
                            <!-- Your card content goes here -->
                        </div>
                    </div>
                    <div class="card-input">
                        <img src="card.png" alt="Card Image">
                        <p>Total Bill: <?php echo isset($_SESSION['bill']) ? '₹' . number_format($_SESSION['bill'], 2) : 'N/A'; ?></p>
                        <label for="cardNumber" class="card-input__label">Card Number</label>
                        <input type="text" id="cardNumber" class="card-input__input" name="cardNumber" autocomplete="off" >
                        <span class="error" id="cardNumberError"></span>
                    </div>
                    <div class="card-input">
                        <label for="cardName" class="card-input__label">Card Holder</label>
                        <input type="text" id="cardName" class="card-input__input" name="cardName" autocomplete="off" >
                        <span class="error" id="cardNameError"></span>
                    </div>
                    <div class="card-form__row">
                        <div class="card-form__col">
                            <div class="card-form__group">
                                <label for="cardMonth" class="card-input__label">Expiration Date</label>
                                <select class="card-input__input -select" id="cardMonth" name="cardMonth" >
                                    <option value="" disabled selected>Month</option>
                                    <?php
                                    for ($n = 1; $n <= 12; $n++) {
                                        echo '<option value="' . sprintf('%02d', $n) . '">' . sprintf('%02d', $n) . '</option>';
                                    }
                                    ?>
                                </select>
                                <select class="card-input__input -select" id="cardYear" name="cardYear" >
                                    <option value="" disabled selected>Year</option>
                                    <?php
                                    $currentYear = date('Y');
                                    for ($i = $currentYear; $i <= $currentYear + 12; $i++) {
                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="card-form__col -cvv">
                            <div class="card-input">
                                <label for="cardCvv" class="card-input__label">CVV</label>
                                <input type="text" class="card-input__input" id="cardCvv" name="cardCvv" maxlength="4" autocomplete="off" >
                                <span class="error" id="cardCvvError"></span>
                            </div>
                        </div>
                    </div>
                    <button class="card-form__button" type="submit">Pay</button>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
