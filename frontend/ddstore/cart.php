<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DD Footware - Cart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <?php
    include('header.php');
    session_start();

    // Get cart items from session
    $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    ?>

    <!-- Cart -->
    <div class="cart-container">
        <h1 class="subheading">Cart</h1>
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
       
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;

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

                foreach ($cartItems as $index => $item) {
                    $product = getProductDetails($item['productID']);
                    $subtotal = $product['price'] * $item['quantity'];
                    $total += $subtotal;
                    echo "<tr>
                            <td class='product-info'>
                                <button class='remove-item' data-index='{$index}'><i class='fas fa-times'></i></button>
                                <img src='" . "https://localhost:7262/" . $product['imageUrl'] . "' alt='{$product['productName']}'>
                                <span>{$product['productName']} - {$item['size']}</span>
                            </td>
                            <td>LKR " . number_format($product['price'], 2) . "</td>
                            <td>
                                <div class='quantity-controls'>
                                  
                                    <input type='number'  value='{$item['quantity']}' disabled min='1'>
                                 
                                </div>
                            </td>
                            <td>LKR " . number_format($subtotal, 2) . "</td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="cart-totals" style="margin-bottom: 200px;">
            <div class="totals-row">
                <span>Subtotal</span>
                <span>LKR <?php echo number_format($total, 2); ?></span>
            </div>
            <div class="totals-row">
                <span>Shipping</span>
                <span>Calculate shipping</span>
            </div>
            <div class="totals-row total">
                <span>Total</span>
                <span>LKR <?php echo number_format($total, 2); ?></span>
            </div>
            <a href="checkout.php"><button class="button-main-2">Proceed to checkout</button></a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function() {
                const index = this.getAttribute('data-index');

                fetch('removeFromCart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ index: index })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error removing item from cart');
                    }
                });
            });
        });
    </script>
</body>
</html>
