<?php
// Start the session
session_start();

// Define user ID from session (initialize as 1)
$userId = isset($_SESSION['userID']) ? $_SESSION['userID'] : 1;

// Define API URL for products
$productApiUrl = 'https://localhost:7262/api/Product';

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

// Fetch product data
$productResponse = makeCurlRequest($productApiUrl);
if ($productResponse === false) {
    die('Error occurred while fetching product details.');
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
    <link rel="stylesheet" href="../admin/adminstyles.css">
</head>
<body>
    <div class="admin-panel">
        <?php include('userSideMenu.php'); ?>
        
        <div class="content">
        <div class="content-header">
        <h1>Add Stock</h1>
            </div>
            <div id="create-substock" class="content-section">
                <form id="substock-form" action="dbhandle/addSubStock.php" method="POST">
                    <div class="form-group">
                        <div class="col">
                            <label for="product">Product</label>
                            <select id="product" name="productID" required>
                                <option value="">Select Product</option>
                                <?php foreach ($products as $product): ?>
                                    <option value="<?php echo htmlspecialchars($product['productID']); ?>">
                                        <?php echo htmlspecialchars($product['productName']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                       
                        <div class="col">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity" name="quantity" placeholder="Quantity" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="button-main-2">Add Substock</button>
                </form>
            </div>
                                </div>
    </div>
</body>
</html>