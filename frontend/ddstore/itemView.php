<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DD Footware</title>
    <link rel="stylesheet" href="./assets/css/index.css">
    <script defer src="scripts.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Navbar -->
    <?php
    include('header.php');

    // Get the product ID from the URL
    $productID = isset($_GET['id']) ? $_GET['id'] : 1;
    $baseImageUrl = "https://localhost:7262/";
    // Initialize cURL
    $ch = curl_init();

    // Set the URL of the API endpoint
    curl_setopt($ch, CURLOPT_URL, "https://localhost:7262/api/Product/{$productID}");

    // Set SSL verification to false
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // Return the response as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    // Execute the request
    $response = curl_exec($ch);
   

    // Close cURL
    curl_close($ch);

    // Decode the JSON response into an array
    $product = json_decode($response, true);
    ?>

    <!-- Item View -->
    <div class="item-view-container">
        <div class="item-gallery">
            <div class="main-image">
                <img id="mainImage" src="<?php echo $baseImageUrl . $product['imageUrl']; ?>" alt="Main Image">
            </div>
            
        </div>
        <div class="item-details">
            <h1 class="subheading"><?php echo $product['productName']; ?></h1>
            <p class="price">LKR <?php echo number_format($product['price'], 2); ?></p>
            
            <a href="#" class="size-chart">Size Chart</a>
            <div class="sizes">
                <label>Size</label>
                <div class="size-options">
                    <button onclick="selectSize(this)">04</button>
                    <button onclick="selectSize(this)">05</button>
                    <button onclick="selectSize(this)">06</button>
                    <button onclick="selectSize(this)">07</button>
                </div>
            </div>
            <div class="quantity">
                <label>Quantity</label>
                <input id="quantity" type="number" value="1" min="1">
            </div>
            <button class="button-main" onclick="addToCart(<?php echo $product['productID']; ?>)">Add to Cart</button>

            <div class="product-info">
           
                <p><strong>Categories:</strong> Brands, Footwear, <?php echo $product['productName']; ?></p>
                <p><strong>Tags:</strong> <?php echo $product['description']; ?></p>
            </div>
        </div>
    </div>

    <?php
    include('footer.php');
    ?>
</body>
<script>
    function changeImage(imagePath) {
        document.getElementById('mainImage').src = imagePath;
    }

    function selectSize(button) {
        const sizeButtons = document.querySelectorAll('.size-options button');
        sizeButtons.forEach(btn => btn.classList.remove('selected'));
        button.classList.add('selected');
    }

    function addToCart(productID) {
        const quantity = document.getElementById('quantity').value;
        const size = document.querySelector('.size-options button.selected').textContent;

        // Create form data
        const formData = new FormData();
        formData.append('productID', productID);
        formData.append('quantity', quantity);
        formData.append('size', size);

        // Send a POST request to add to cart
        fetch('addToCart.php', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Product added to cart!');
            } else {
                alert('Failed to add product to cart.');
            }
        });
    }
</script>
</html>
