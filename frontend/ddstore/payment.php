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
        'phone' => $phone
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

    // Get the last inserted customer ID
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://localhost:7262/api/Customer/lastCustomerId');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $lastCustomerIdResponse = curl_exec($ch);
    curl_close($ch);

    $lastCustomerIdData = json_decode($lastCustomerIdResponse, true);
    $customerID = isset($lastCustomerIdData) ? intval($lastCustomerIdData) : null;

    // Check if customerID is valid
    if (!$customerID) {
        header("Location: index.php?status=errorcuslast");
        exit();
    }

    // Create order in database
    $orderData = [
        'customerID' => $customerID,
        'userID' => null,
        'orderDate' => date('c'), // ISO 8601 format
        'orderStatus' => 'Processing'
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

    // Get the last inserted order ID
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://localhost:7262/api/Order/lastOrderId');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $lastOrderIdResponse = curl_exec($ch);
    curl_close($ch);

    $lastOrderIdData = json_decode($lastOrderIdResponse, true);
    $orderID = isset($lastOrderIdData) ? intval($lastOrderIdData) : null;

    // Check if orderID is valid
    if (!$orderID) {
        header("Location: index.php?status=errorlastor");
        exit();
    }

    // Create order items in database
    foreach ($cartItems as $item) {
        $orderItemData = [
            'orderID' => $orderID,
            'productID' => $item['productID'],
            'quantity' => $item['quantity']
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

        // Check if the order item insertion was successful
        if (!$orderItemResponse) {
            header("Location: index.php?status=errorOrderItem");
            exit();
        }

        // Reduce stock quantity
        $updateStockUrl = 'https://localhost:7262/api/MainStock/updateStock/' . $item['productID'];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $updateStockUrl);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([$item['quantity']]));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $updateStockResponse = curl_exec($ch);
        curl_close($ch);

        // Check if the stock update was successful
        if (!$updateStockResponse) {
            header("Location: index.php?status=errormainstock");
            exit();
        }
    }

    // Clear cart session
    unset($_SESSION['cart']);

    // Redirect to success page
    header('Location: index.php');
    exit();
}
?>
