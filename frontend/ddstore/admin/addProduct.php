<?php
session_start();
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
        <h1>Add Product</h1>
            </div>
            <div class="content-section">
            <div id="create-event" class="content-section">
                <form id="product-form" action="dbhandle/addProduct.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col">
                            <label for="product-name">Product Name</label>
                            <input type="text" id="product-name" name="productName" placeholder="Product Name" required>
                        </div>
                        <div class="col">
                            <label for="product-description">Description</label>
                            <textarea id="product-description" name="description" rows="4" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="product-price">Price</label>
                            <input type="text" id="product-price" name="price" placeholder="Price" required>
                        </div>
                        <div class="col">
                            <label for="product-image">Product Image</label>
                            <input type="file" id="product-image" name="productImage" accept="image/*" required>
                        </div> 
                    </div>
                    <button type="submit" class="button-main-2" >Create Product</button>
                </form>
            </div>
</div>
    </div>
</body>
</html>