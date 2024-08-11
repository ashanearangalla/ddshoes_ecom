<?php
session_start();

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];

    // Create a cart item array
    $cartItem = [
        'productID' => $productID,
        'quantity' => $quantity,
        'size' => $size
    ];

    // Check if the cart session variable exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add the item to the cart
    $_SESSION['cart'][] = $cartItem;

    // Respond with success
    echo json_encode(['success' => true]);
} else {
    // Respond with error
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
