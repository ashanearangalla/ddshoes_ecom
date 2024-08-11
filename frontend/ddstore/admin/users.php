<?php
session_start();
// Define API URL for users
$userApiUrl = 'https://localhost:7262/api/User';

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

// Fetch user data
$userResponse = makeCurlRequest($userApiUrl);
if ($userResponse === false) {
    die('Error occurred while fetching user details.');
}
$users = json_decode($userResponse, true);
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
        <h1>Manage Users</h1>
            </div>
            <div class="content-section">
                <table class="event-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User ID</th>
                            <th>Username</th>
   
                            <th>Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $index => $user): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($user['userID']); ?></td>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                       
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
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