<?php
session_start();
// Fetching data from API
$apiUrl = 'https://localhost:7262/api/Outlet';
$ch = curl_init();

// Set the cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disable SSL verification
$response = curl_exec($ch);
curl_close($ch);

// Decode the JSON response
$outlets = json_decode($response, true);
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
        <h1>Manage Outlets</h1>
            </div>
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Outlet Name</th>
                            <th>Location</th>
                            <th>Manager</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($outlets as $index => $outlet): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($outlet['outletName']); ?></td>
                            <td><?php echo htmlspecialchars($outlet['location']); ?></td>
                            <td><?php echo 'Manager Name'; // Replace with actual manager data ?></td>
                            <td><?php echo 'Username'; // Replace with actual username data ?></td>
                            <td><?php echo 'Password'; // Replace with actual password data ?></td>
                            <td><button id="update" onclick="openModal()">Update</button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
                        </div>
    </div>

    <!-- The Modal -->
    

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
