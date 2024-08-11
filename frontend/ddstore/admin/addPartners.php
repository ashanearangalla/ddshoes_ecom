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
        <?php
        include('adminSideMenu.php');
        ?>
        
     
        <div class="content">
        <div class="content-header">
        <h1>Add Partner</h1>
            </div>
            <div id="create-event" class="content-section">
            
                <form id="event-form" action="addEvent.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col">
                            <label for="event-name">Partner Name</label>
                            <input type="text" id="outlet-name" name="outletName" placeholder="Outlet Name" required>
                        </div>
                        <div class="col">
                            <label for="event-name">Sale District</label>
                            <input type="text" id="manager-name" name="managerName" placeholder="Manager Name" required>
                        </div>
                       
                    </div>
                    <div class="form-group">
                        <div class="col">
                            <label for="event-name">Username</label>
                            <input type="text" id="manager-name" name="username" placeholder="Username" required>
                        </div>
                        <div class="col">
                            <label for="event-name">Password</label>
                            <input type="text" id="pword" name="password" placeholder="Password" required>
                        </div>
                        
                        
                         
                    </div>
                    
        
                    
                    <button type="submit" class="button-main-2" >Add Partner</button>
                </form>
            </div>
</div>
    </div>
</body>
</html>
