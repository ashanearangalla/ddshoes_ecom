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
        <h1>Add Outlet</h1>
            </div>
            
            <div id="create-event" class="content-section">
                <form id="event-form" action="dbhandle/addOutlet.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col">
                            <label for="outlet-name">Outlet Name</label>
                            <input type="text" id="outlet-name" name="outletName" placeholder="Outlet Name" required>
                        </div>
                        <div class="col">
                            <label for="manager-name">Manager Name</label>
                            <input type="text" id="manager-name" name="managerName" placeholder="Manager Name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="username">Username</label>
                            <input type="text" id="username" name="username" placeholder="Username" required>
                        </div>
                        <div class="col">
                            <label for="password">Password</label>
                            <input type="text" id="password" name="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        
                        <div class="col">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" placeholder="Location" required>
                        </div>
                    </div>
                    <button type="submit" class="button-main-2" >Add Outlet</button>
                </form>
            </div>
</div>
    </div>
</body>
</html>
