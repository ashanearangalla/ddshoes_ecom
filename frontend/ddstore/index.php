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
    ?>

    <!-- Image Carousel -->
    <div class="carousel">
        <div class="carousel-inner">
            
          
        </div>
        <a class="prev" onclick="moveSlide(-1)">&#10094;</a>
        <a class="next" onclick="moveSlide(1)">&#10095;</a>
    </div>


    <!-- New Arrivals -->
    <div class="item-container" id="newarrivals">
        <h2 class="subheading">New Arrivals</h2>
        <div class="item-row">
            <?php
            // Initialize cURL
            $ch = curl_init();

            // Set the URL of the API endpoint
            curl_setopt($ch, CURLOPT_URL, "https://localhost:7262/api/Product");

            // Return the response as a string
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Execute the request
            $response = curl_exec($ch);

            // Close cURL
            curl_close($ch);
            $baseImageUrl = "https://localhost:7262/";
            // Decode the JSON response into an array
            $products = json_decode($response, true);

            // Check if products are available
            if (!empty($products)) {
                foreach ($products as $product) {
                    echo '
                    <div class="item">
                        <a href="itemView.php?id=' . $product["productID"] . '"><img src="'.$baseImageUrl . $product["imageUrl"] .' " alt="' . $product["productName"] . '"></a>
                        
                        <h3>' . $product["productName"] . '</h3>
                        <p>$' . number_format($product["price"], 2) . '</p>
                        <button class="button-main">Add to Cart</button>
                    </div>';
                }
            } else {
                echo '<p>No products found.</p>';
            }
            ?>
        </div>
    </div>

    <?php
    include('footer.php');
    ?>

    <script>
        let currentIndex = 0;

        function moveSlide(n) {
            const slides = document.querySelectorAll('.carousel-item');
            if (n > 0) {
                currentIndex = (currentIndex + 1) % slides.length;
            } else {
                currentIndex = (currentIndex - 1 + slides.length) % slides.length;
            }
            updateSlides();
        }

        function updateSlides() {
            const slides = document.querySelectorAll('.carousel-item');
            slides.forEach((slide, index) => {
                slide.style.transform = `translateX(${-100 * currentIndex}%)`;
            });
        }
    </script>
</body>
</html>
