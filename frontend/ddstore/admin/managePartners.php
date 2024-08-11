<?php
session_start();
// Define the API URL
$partnerApiUrl = 'https://localhost:7262/api/Partner';

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

// Fetch partner data
$partnerResponse = makeCurlRequest($partnerApiUrl);

if ($partnerResponse === false) {
    die('Error occurred while fetching partners.');
}

$partners = json_decode($partnerResponse, true);
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
        <h1>Manage Partners</h1>
            </div>
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Partner Name</th>
                            <th>Contact Email</th>
                            <th>Contact Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($partners as $index => $partner): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($partner['partnerName']); ?></td>
                            <td><?php echo htmlspecialchars($partner['contactEmail']); ?></td>
                            <td><?php echo htmlspecialchars($partner['contactPhone']); ?></td>
                            <td>
                                <button id="update" onclick="openModal()">Update</button>
                                <button id="delete">Delete</button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
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
