<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Our Cause</title>
    <style>
        :root {
            --primary-color: #ff8133;
            --secondary-color: #ffd1b3;
            --text-color: #333;
            --background-color: #f9f9f9;
        }

        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
        }

        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-container, .payment-options {
            background-color: #fff;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
            transition: all 0.7s ease;
        }

        .form-container:hover, .payment-options:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input, select {
            margin-bottom: 1rem;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.75rem 1rem;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e66300;
        }

        .payment-options {
            display: none;
        }

        .payment-option {
            margin-bottom: 1rem;
            padding: 1rem;
            font-weight: bolder;
            font-size: larger;
            background-color: var(--secondary-color);
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
            transition: background-color 0.9s ease;
        }

        .payment-option:hover {
            background-color: #ffb380;
        }

        .payment-details {
            margin-top: 1rem;
            padding: 1rem;
            background-color: #fff;
            border-radius: 4px;
        }

        #qrcode {
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }
        .modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.4);
  }

  .modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 500px;
  }

  .close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
  }

  .close:hover,
  .close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
  }
    </style>
</head>
<body>
    <div class="container">
        <h1>Support Our Cause</h1>
        
        <div class="form-container">
            <form id="donationForm">
                <label for="amount">Donation Amount:</label>
                <input type="number" id="amount" name="amount" required min="1">
                <button type="submit">Proceed to Payment</button>
            </form>
        </div>

        <div id="paymentOptions" class="payment-options">
            <h2>Choose Payment Method</h2>

            <div class="payment-option" id="upiOption">
                <h3>UPI</h3>
                <div class="payment-details">
                    <p>UPI ID: EzE0093445@CUB</p>
                    <p>UPI No: 9108506408</p>
                    <p>Pay SRIVIDYA CHARITIES TRUST</p>
                    <div id="upiLink"></div>
                </div>
            </div>

            <div class="payment-option" id="qrOption">
                <h3>UPI QR-Code</h3>
                <div class="payment-details">
                    <div id="qrcode"></div>
                </div>
            </div>

            <div class="payment-option" id="bankOption">
                <h3>Bank Transfer</h3>
                <div class="payment-details">
                    <p>Bank: City Union Bank Ltd, Indiranagar, Bangalore</p>
                    <p>Account Number: 500101013370991</p>
                    <p>IFSC Code: CIUB0000139</p>
                </div>
            </div>
        </div>
    </div>

    <div id="paymentModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <div id="modalContent"></div>
  </div>
</div>

                    <<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
                <script>
                const donationForm = document.getElementById('donationForm');
                const amountInput = document.getElementById('amount');
                const modal = document.getElementById('paymentModal');
                const modalContent = document.getElementById('modalContent');
                const closeBtn = document.getElementsByClassName('close')[0];

                donationForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const amount = amountInput.value;
                    
                    // Disable amount input after submission
                    amountInput.disabled = true;

                    showPaymentOptions(amount);
                });

                function showPaymentOptions(amount) {
                    const options = `
                    <h2>Choose Payment Method</h2>
                    <div class="payment-option" onclick="showPaymentDetails('upi', ${amount})">
                        <h3>UPI</h3>
                    </div>
                    <div class="payment-option" onclick="showPaymentDetails('qr', ${amount})">
                        <h3>UPI QR-Code</h3>
                    </div>
                    <div class="payment-option" onclick="showPaymentDetails('bank', ${amount})">
                        <h3>Bank Transfer</h3>
                    </div>
                    `;
                    
                    modalContent.innerHTML = options;
                    modal.style.display = 'block';
                }

                function showPaymentDetails(method, amount) {
                    let details = '';
                    switch (method) {
                    case 'upi':
                        details = `
                        <h3>UPI Payment</h3>
                        <p>UPI ID: EzE0093445@CUB</p>
                        <p>UPI No: 9108506408</p>
                        <p>Pay SRIVIDYA CHARITIES TRUST</p>
                        <a href="upi://pay?pa=EzE0093445@CUB&pn=SRIVIDYA CHARITIES TRUST&am=${amount}&cu=INR">Pay with UPI</a>
                        `;
                        break;
                    case 'qr':
                        details = `
                        <h3>UPI QR-Code</h3>
                        <div id="qrcode"></div>
                        `;
                        break;
                    case 'bank':
                        details = `
                        <h3>Bank Transfer</h3>
                        <p>Bank: City Union Bank Ltd, Indiranagar, Bangalore</p>
                        <p>Account Number: 500101013370991</p>
                        <p>IFSC Code: CIUB0000139</p>
                        `;
                        break;
                    }
                    
                    modalContent.innerHTML = details;
                    
                    if (method === 'qr') {
                    new QRCode(document.getElementById("qrcode"), {
                        text: `upi://pay?pa=EzE0093445@CUB&pn=SRIVIDYA CHARITIES TRUST&am=${amount}&cu=INR`,
                        width: 128,
                        height: 128
                    });
                    }
                }

                closeBtn.onclick = function() {
                    modal.style.display = 'none';
                    // Re-enable amount input when modal is closed
                    amountInput.disabled = false;
                }

                window.onclick = function(event) {
                    if (event.target == modal) {
                    modal.style.display = 'none';
                    // Re-enable amount input when modal is closed
                    amountInput.disabled = false;
                    }
                }
                </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $amount = $_POST["amount"];
        
        // Process the payment (you would add your payment gateway integration here)
        
        // For demonstration purposes, we'll just echo a success message
        echo "<script>alert('Payment of Rs. " . $amount . " processed successfully!');</script>";
    }
    ?>
</body>
</html>