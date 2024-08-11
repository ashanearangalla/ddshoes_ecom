<?php
// Initialize user ID from session (for example purposes, we set it manually here)
session_start();
$userID = $_SESSION['userID'] ?? 1; // Default to 1 if userID is not set in the session

// Define API URL for sub-stock details
$subStockApiUrl = "https://localhost:7262/api/SubStock/user/$userID";

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

// Fetch sub-stock data
$subStockResponse = makeCurlRequest($subStockApiUrl);
if ($subStockResponse === false) {
    die('Error occurred while fetching stock details.');
}
$subStocks = json_decode($subStockResponse, true);

// Fetch product data (assuming you have an API for products, update URL accordingly)
$productApiUrl = 'https://localhost:7262/api/Product';
$productResponse = makeCurlRequest($productApiUrl);
if ($productResponse === false) {
    die('Error occurred while fetching product details.');
}
$products = json_decode($productResponse, true);

// Create a lookup array for product names
$productLookup = [];
foreach ($products as $product) {
    $productLookup[$product['productID']] = $product['productName'];
}
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
        <h1>My Stock</h1>
            </div>
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Sold</th>
                            <th>Remaining</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subStocks as $index => $subStock): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($productLookup[$subStock['productID']] ?? 'Unknown'); ?></td>
                            <td><?php echo htmlspecialchars($subStock['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($subStock['sold']); ?></td>
                            <td><?php echo htmlspecialchars($subStock['quantity'] - $subStock['sold']); ?></td>
                            <td>
                                <button  id="update" onclick="openModal()">UPDATE</button>
                                <button id="delete">DELETE</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
                        </div>
    </div>

    

    <script>
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById("myModal")) {
                closeModal();
            }
        }
    </script>
</body>
</html>