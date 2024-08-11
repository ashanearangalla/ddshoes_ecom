<?php

session_start();

// Define the API URL
$productApiUrl = 'https://localhost:7262/api/Product';

// Function to make cURL requests
function makeCurlRequest($url, $method = 'GET', $data = null) {
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification

    if ($method == 'DELETE') {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
    }

    if ($method == 'PUT' && $data) {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode != 200 && $httpCode != 204) {
        return false;
    }

    return $response;
}

// Fetch product data
$productResponse = makeCurlRequest($productApiUrl);

if ($productResponse === false) {
    die('Error occurred while fetching products.');
}

$products = json_decode($productResponse, true);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - DD Footware</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="adminstyles.css">

    <script>
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product?')) {
                fetch(`dbhandle/deleteProduct.php?id=${productId}`, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product deleted successfully.');
                        location.reload();
                    } else {
                        alert('Failed to delete product.');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function updateProduct(productId) {
            window.location.href = `addProduct.php?id=${productId}`;
        }
    </script>
</head>
<body>
    <div class="admin-panel">
        <?php include('adminSideMenu.php'); ?>
        <div class="content">
        <div class="content-header">
        <h1>Manage Products</h1>
            </div>
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $index => $product): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($product['productName']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo '$' . number_format($product['price'], 2); ?></td>
                            <td>
                                <button id="update" onclick="updateProduct(<?php echo $product['productID']; ?>)">UPDATE</button>
                                <button id="delete" onclick="deleteProduct(<?php echo $product['productID']; ?>)">DELETE</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
                        </div>
    </div>
</body>
</html>