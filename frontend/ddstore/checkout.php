<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DD Footware - Checkout</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script>
        function validateForm() {
            var name = document.getElementById('name').value;
            var email = document.getElementById('email').value;
            var phone = document.getElementById('phone').value;
            var nic = document.getElementById('nic').value;
            var errorMessage = document.getElementById('error-message');
            
            errorMessage.innerHTML = '';

            if (name == '' || email == '' || phone == '' || nic == '') {
                errorMessage.innerHTML = 'All fields are required.';
                return false;
            }

            var emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
            if (!email.match(emailPattern)) {
                errorMessage.innerHTML = 'Please enter a valid email address.';
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <!-- Navbar -->
    <?php
    include('header.php');
    session_start();

    // Get cart items from session
    $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    // Function to get product details from the API
    function getProductDetails($productID) {
        // Initialize cURL
        $ch = curl_init();

        // Set the URL of the API endpoint
        curl_setopt($ch, CURLOPT_URL, "https://localhost:7262/api/Product/{$productID}");

        // Set SSL verification to false
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Return the response as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // Execute the request
        $response = curl_exec($ch);

        // Close cURL
        curl_close($ch);

        // Decode the JSON response into an array
        return json_decode($response, true);
    }

    // Calculate total amount
    $totalAmount = 0;
    foreach ($cartItems as $item) {
        $product = getProductDetails($item['productID']);
        $totalAmount += $product['price'] * $item['quantity'];
    }
    ?>
    <section class="checkout-details">
        <div class="container">
            <h1 class="subheading">Checkout Details</h1>
            <form action="payment.php" method="POST" onsubmit="return validateForm()" style="padding-right: 20px;">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                    <label for="phone">Phone No</label>
                    <input type="text" id="phone" name="phone" placeholder="Phone No">
                </div>
                <div class="form-group">
                    <label for="nic">NIC</label>
                    <input type="text" id="nic" name="nic" placeholder="NIC Number">
                </div>
                <h3 class="checkout-subtitle">Order Summary</h3>
                <?php foreach ($cartItems as $item) : ?>
                    <?php $product = getProductDetails($item['productID']); ?>
                    <div class="checkout-item">
                        <p><?php echo htmlspecialchars($item['quantity']); ?> x <?php echo htmlspecialchars($product['productName']); ?> (Size: <?php echo htmlspecialchars($item['size']); ?>)</p>
                        <p><?php echo number_format($product['price'], 2); ?> LKR each</p>
                    </div>
                <?php endforeach; ?>
                <div class="subtotal">
                    <p>Sub Total</p>
                    <p><?php echo number_format($totalAmount, 2); ?> LKR</p>
                </div>
                <div class="total">
                    <p>Total</p>
                    <p><?php echo number_format($totalAmount, 2); ?> LKR</p>
                </div>
                <div id="error-message" style="color: red; margin-bottom: 20px; margin-top: 20px; text-align: center;"></div>
                <button type="submit" class="button-main-2">Proceed to Payment</button>
            </form>
        </div>
    </section>
</body>
</html>
