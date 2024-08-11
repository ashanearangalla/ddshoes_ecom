<?php

session_start();
// Define API URLs
$stockApiUrl = 'https://localhost:7262/api/MainStock';
$productApiUrl = 'https://localhost:7262/api/Product';

// Function to make cURL requests
function makeCurlRequest($url)
{
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

// Fetch stock data
$stockResponse = makeCurlRequest($stockApiUrl);
if ($stockResponse === false) {
    die('Error occurred while fetching stock details.');
}
$stocks = json_decode($stockResponse, true);

// Fetch product data
$productResponse = makeCurlRequest($productApiUrl);
if ($productResponse === false) {
    die('Error occurred while fetching products.');
}
$products = json_decode($productResponse, true);

// Create an associative array for products to easily lookup product names by ID
$productNames = [];
foreach ($products as $product) {
    $productNames[$product['productID']] = $product['productName'];
}
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
        <h1>Manage Stock Details</h1>
            </div>
            <div class="content-section">
                
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Sizes</th>
                            <th>In Stock Quantity</th>
                            <th>Sold</th>
                            <th>Remaining</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stocks as $index => $stock) : ?>
                            <?php
                            // Fetch product name using productID
                            $productName = $productNames[$stock['productID']] ?? 'Unknown Product';
                            $remainingStock = $stock['quantity'] - $stock['sold'];
                            ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($productName); ?></td>
                                <td>Size info not available</td> <!-- Assuming size is not available in the stock data -->
                                <td><?php echo htmlspecialchars($stock['quantity']); ?></td>
                                <td><?php echo htmlspecialchars($stock['sold']); ?></td>
                                <td><?php echo htmlspecialchars($remainingStock); ?></td>
                                <td>
                                    <button id="update" onclick="openModal()">Update</button>
                                    <button id="delete">Delete</button>
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