<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get POST data
    $productId = isset($_POST['productID']) ? intval($_POST['productID']) : 0;
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $userId = isset($_SESSION['userID']) ? $_SESSION['userID'] : 1;

    // Create substock data
    $substockData = [
        'productID' => $productId,
        'userID' => $userId,
        'quantity' => $quantity,
        'sold' => 0 // Not used, set to 0
    ];

    // Initialize cURL for creating the substock
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://localhost:7262/api/SubStock');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($substockData)); // Not an array
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    

   // Check if order item creation was successful
   if ($response === false) {
    header("Location: ../manageStock.php?status=error");
    exit();
}

// Redirect to success page

header("Location: ../manageStock.php");
exit();
}
?>
