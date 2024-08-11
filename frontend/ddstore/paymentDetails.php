<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get customer details from form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $nic = $_POST['nic'];

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

    // Create customer in database
    $customerData = [
        'customerName' => $name,
        'email' => $email,
        'phone' => $phone,
        'nic' => $nic
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://localhost:7262/api/Customer');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($customerData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $customerResponse = curl_exec($ch);
    curl_close($ch);

    $customerResponseData = json_decode($customerResponse, true);
    $customerID = $customerResponseData['customerID'];

    // Create order in database
    $orderData = [
        'totalAmount' => $totalAmount,
        'status' => 'Pending',
        'customerID' => $customerID
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://localhost:7262/api/Order');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $orderResponse = curl_exec($ch);
    curl_close($ch);

    $orderResponseData = json_decode($orderResponse, true);
    $orderID = $orderResponseData['orderID'];

    // Create order items in database
    foreach ($cartItems as $item) {
        $orderItemData = [
            'quantity' => $item['quantity'],
            'size' => $item['size'],
            'productID' => $item['productID'],
            'orderID' => $orderID
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://localhost:7262/api/OrderItem');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderItemData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $orderItemResponse = curl_exec($ch);
        curl_close($ch);
    }

    // Clear cart session
    unset($_SESSION['cart']);

    // Redirect to success page
    header('Location: success.php');
    exit();
}
?>
