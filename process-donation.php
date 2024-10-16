<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the donation amount and validate it
    $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
    
    if ($amount && $amount > 0) {
        // UPI ID and name of the recipient
        $upiId = 'EzE0093445@CUB';
        $recipientName = 'SRIVIDYA CHARITIES TRUST';

        // Generate the UPI payment link with the amount
        $upiLink = "upi://pay?pa={$upiId}&pn=" . urlencode($recipientName) . "&am={$amount}&cu=INR";

        // Generate the QR code link (using Google Chart API)
        $qrCodeLink = "https://chart.googleapis.com/chart?cht=qr&chl=" . urlencode($upiLink) . "&chs=250x250";

        // Display the UPI payment link and the QR code to the user
        echo "<h3>Thank you for your donation of ₹{$amount}!</h3>";
        echo "<p>To donate, please choose one of the following payment options:</p>";
        echo "<p><a href='{$upiLink}'>Pay via UPI</a></p>";
        echo "<p>Or scan the QR code below to complete your payment:</p>";
        echo "<img src='{$qrCodeLink}' alt='UPI QR Code' />";
        echo "<p><a href='donation_form.html'>Make another donation</a></p>";
    } else {
        // Error handling if the amount is invalid
        echo "<h3>Invalid Donation Amount!</h3>";
        echo "<p>Please enter a valid donation amount and try again.</p>";
        echo "<p><a href='donation_form.html'>Go back to the donation form</a></p>";
    }
}
?>
