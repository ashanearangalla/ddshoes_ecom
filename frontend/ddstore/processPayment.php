<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get customer and payment details from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $nic = $_POST['nic'];
    $cardType = $_POST['cardType'];
    $cardNumber = str_replace(' ', '', $_POST['cardNumber']);
    $expDate = $_POST['expDate'];
    $cvv = $_POST['cvv'];

    // Get cart items from session
    $cartItems = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

    // Initialize cURL
    $ch = curl_init();

    // Function to make API request
    function makeApiRequest($url, $method, $data = null) {
        global $ch;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
            exit();
        }

        return json_decode($response, true);
    }

    // Insert customer details
    $customerData = [
        "customerID" => 0,
        "customerName" => $name,
        "email" => $email,
        "phone" => $phone
    ];
    makeApiRequest("https://localhost:7262/api/Customer", "POST", $customerData);

    // Get last inserted customer ID
    $lastCustomerId = makeApiRequest("https://localhost:7262/api/Customer/lastCustomerId", "GET")['customerID'];

    // Insert order details
    $orderData = [
        [
            "orderID" => 0,
            "customerID" => $lastCustomerId,
            "userID" => null,
            "orderDate" => date('c'),
            "orderStatus" => "Processing"
        ]
    ];
    makeApiRequest("https://localhost:7262/api/Order", "POST", $orderData);

    // Get last inserted order ID
    $lastOrderId = makeApiRequest("https://localhost:7262/api/Order/lastOrderId", "GET")['orderID'];

    // Insert order items
    foreach ($cartItems as $item) {
        $orderItemData = [
            "orderItemID" => 0,
            "orderID" => $lastOrderId,
            "productID" => $item['productID'],
            "quantity" => $item['quantity']
        ];
        makeApiRequest("https://localhost:7262/api/OrderItem", "POST", $orderItemData);

        // Update main stock
        makeApiRequest("https://localhost:7262/api/MainStock/updateStock/{$item['productID']}", "PUT", $item['quantity']);
    }

    // Clear the cart after successful payment
    unset($_SESSION['cart']);

    // Close cURL
    curl_close($ch);

    // Redirect to a success page
    header('Location: success.php');
    exit();
} else {
    echo 'Invalid request method.';
}
?>