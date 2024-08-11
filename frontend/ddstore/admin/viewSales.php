<?php

session_start();

// Define API URL for orders
$orderApiUrl = 'https://localhost:7262/api/Order';

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
    <link rel="stylesheet" href="adminstyles.css">
    
</head>
<body>
    <div class="admin-panel">
        <?php include('adminSideMenu.php'); ?>
        
        <div class="content">
        <div class="content-header">
        <h1>Manage Orders</h1>
            </div>
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order ID</th>
                            <th>Customer ID</th>
                            <th>User ID</th>
                            <th>Order Date</th>
                            <th>Order Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $index => $order): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($order['orderID']); ?></td>
                            <td><?php echo htmlspecialchars($order['customerID']); ?></td>
                            <td><?php echo htmlspecialchars($order['userID']); ?></td>
                            <td><?php echo htmlspecialchars($order['orderDate']); ?></td>
                            <td><?php echo htmlspecialchars($order['orderStatus']); ?></td>
                            <td><button id="update" >Confirm</button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
                        </div>
    </div>
</body>
</html>