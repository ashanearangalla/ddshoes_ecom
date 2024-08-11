<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];

    // Create order data
    $orderData = [
        'customerID' => null, // Set customerID if applicable
        'userID' => 2, // Assuming userID from session or set as needed
        'orderDate' => date('c'), // Current date and time in ISO 8601 format
        'orderStatus' => 'Processing'
    ];

    // Initialize cURL for creating the order
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://localhost:7262/api/Order');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $orderResponse = curl_exec($ch);
    curl_close($ch);

    // Check if order creation was successful
    if ($orderResponse === false) {
        header("Location: index.php?status=errorOrder");
        exit();
    }

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
        header("Location: index.php?status=errorlastOrderId");
        exit();
    }

    // Create order item data
    $orderItemData = [
        'orderID' => $orderID,
        'productID' => $productId,
        'quantity' => $quantity
    ];

    // Initialize cURL for creating the order item
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://localhost:7262/api/OrderItem');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderItemData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $orderItemResponse = curl_exec($ch);
    curl_close($ch);

    // Check if order item creation was successful
    if ($orderItemResponse === false) {
        header("Location: index.php?status=errorOrderItem");
        exit();
    }

    // Redirect to success page
    
header("Location: ../viewSales.php");
exit();
}
?>
