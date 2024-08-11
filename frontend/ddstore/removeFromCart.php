<?php
session_start();

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the data from the POST request
    $data = json_decode(file_get_contents('php://input'), true);
    $index = $data['index'];

    // Check if the cart session variable exists and the index is valid
    if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$index])) {
        // Remove the item from the cart
        array_splice($_SESSION['cart'], $index, 1);

        // Respond with success
        echo json_encode(['success' => true]);
    } else {
        // Respond with error
        echo json_encode(['success' => false, 'message' => 'Invalid index or cart is empty.']);
    }
} else {
    // Respond with error
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
