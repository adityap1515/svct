<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    <link rel="stylesheet" href="donation.css">
    <link rel="stylesheet" href="ind-styles.css">
</head>
<body>

    <?php 
        $amount = isset($_POST['amount']) ? $_POST['amount'] : '';

        if (empty($amount)) {
            echo "<script>alert('Amount is missing. Please try again.'); window.location.href='donation_form.php';</script>";
            exit; 
        }

        $upiId = "EzE0093445@CUB";
        $upiLink = "upi://pay?pa={$upiId}&pn=Your%20Charity&am={$amount}&cu=INR";
        $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=" . urlencode($upiLink);
    ?>

    <div class="paymentholder">
        <div id="paymentOptions">
            <h2>Choose Payment Method</h2>
            <button id="upiButton" class="payment-button">UPI</button>
            <button id="qrButton" class="payment-button">QR Code</button>
            <button id="bankButton" class="payment-button">Bank Transfer</button>
        </div>
        <div class="informpayment">
            <h3 class="informpayment">Please 'do not refresh' this page. it will timeout in a few minutes, you will not see a payment success or confirmation on this page on a successful payment, you will soon hear from us.</h3>
        </div>

        <!-- UPI Modal -->
        <div id="upiModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>UPI Payment</h2>
                <p>UPI ID: <span><?php echo $upiId; ?></span></p>
                <a id="upiLink" href="<?php echo $upiLink; ?>" target="_blank">Open in UPI App</a>
            </div>
        </div>

        <!-- QR Code Modal -->
        <div id="qrModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>QR Code Payment</h2>
                <img id="qrCode" src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
            </div>
        </div>

        <!-- Bank Transfer Modal -->
        <div id="bankModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h3>Bank Transfer</h3>
                <p>Bank: City Union Bank Ltd, Indiranagar, Bangalore</p>
                <p>Account Number: 500101013370991</p>
                <p>IFSC Code: CIUB0000139</p>
            </div>
        </div>
    </div>





    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>About Us</h3>
                <p>Srividya Charities Trust is an endeavour to present an opportunity to like-minded people to channelise their efforts, resources and donation for the benefit of the Society.</p>
            </div>
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#donate">Upcoming Events</a></li>
                    <li><a href="donate.html">Donate</a></li>
                    <li><a href="index.html#contact">Contact Us</a></li>
                    
                </ul>
            </div>
          <!--  <div class="footer-section" id="contact">
                <h3>Contact Us</h3>
                <p>Email: info@srividyacharities.org</p>
                <p>Phone: +91 91085 06408</p>
                <p>Address: #6/1 Car Street, 1st Cross Halasuru, Bangalore-560008</p>
            </div>
            <div class="footer-section"> -->

            </div>
        </div>
        <div class="legal">
            <p>&copy; 2024 Srividya Charities. All rights reserved.</p>
          <!--<p class="t&p"><a href="#privacy">Privacy Policy</a> | <a href="#terms">Terms of Service</a></p>-->
        </div>
    </footer>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const upiButton = document.getElementById('upiButton');
            const qrButton = document.getElementById('qrButton');
            const bankButton = document.getElementById('bankButton');
            const upiModal = document.getElementById('upiModal');
            const qrModal = document.getElementById('qrModal');
            const bankModal = document.getElementById('bankModal');
            const closeBtns = document.getElementsByClassName('close');

           
            upiButton.addEventListener('click', () => openModal(upiModal));
            qrButton.addEventListener('click', () => openModal(qrModal));
            bankButton.addEventListener('click', () => openModal(bankModal));

            Array.from(closeBtns).forEach(btn => {
                btn.addEventListener('click', () => closeModal(btn.closest('.modal')));
            });

            window.addEventListener('click', function(event) {
                if (event.target.classList.contains('modal')) {
                    closeModal(event.target);
                }
            });

            function openModal(modal) {
                closeAllModals();
                modal.style.display = 'block';
            }

            function closeModal(modal) {
                modal.style.display = 'none';
            }

            function closeAllModals() {
                [upiModal, qrModal, bankModal].forEach(modal => {
                    modal.style.display = 'none';
                });
            }
        });
    </script>

</body>
</html>
