<?php
// Start the session
session_start();

// Define user ID from session (initialize as 2)
$userId = isset($_SESSION['userID']) ? $_SESSION['userID'] : 2;

// Define API URL for orders based on user ID
$orderApiUrl = "https://localhost:7262/api/Order/user/order/$userId";

// Function to make cURL requests
function makeCurlRequest($url) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode != 200) {
        return false;
    }

    return $response;
}

// Fetch order data
$orderResponse = makeCurlRequest($orderApiUrl);
if ($orderResponse === false) {
    die('Error occurred while fetching order details.');
}
$orders = json_decode($orderResponse, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - DD Footware</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../admin/adminstyles.css">
    
</head>
<body>
    <div class="admin-panel">
        <?php include('userSideMenu.php'); ?>
        
        <div class="content">
        <div class="content-header">
        <h1>My Orders</h1>
            </div>
            <div class="content-section">
                <?php foreach ($orders as $index => $order): ?>
                    <h2>Order #<?php echo htmlspecialchars($order['orderID']); ?></h2>
                    <p><strong>Order Date:</strong> <?php echo htmlspecialchars($order['orderDate']); ?></p>
                    <p><strong>Order Status:</strong> <?php echo htmlspecialchars($order['orderStatus']); ?></p>
                    <table class="event-table">
                        <thead>
                            <tr>
                                <th>Item ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['orderItems'] as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['productID']); ?></td>
                                <td><?php echo htmlspecialchars($item['productName']); ?></td>
                                <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                           
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
                            </div>
    </div>
</body>
</html>
