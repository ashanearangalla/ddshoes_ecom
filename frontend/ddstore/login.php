<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="login-container" >
        <h1>DD Footware Online Store</h1>
        <h2 class="subheading">Login</h2>
        <form id="login-form" action="authentication.php" method="POST" onsubmit="return validateForm()">
            <input type="text" id="username" name="username" placeholder="Username">
            <div class="error" id="username-error"></div>

            <input type="password" id="password" name="password" placeholder="Password">
            <div class="error" id="password-error"></div>

            <button class="button-main-2" type="submit">Login</button>
        </form>
        
    </div>

    <script>
    function validateForm() {
        // Clear previous errors
        document.querySelectorAll('.error').forEach(error => error.innerHTML = '');

        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        let isValid = true;

        // Validate Username
        if (!username) {
            document.getElementById('username-error').innerHTML = 'Username is required.';
            return false;
        }

        // Validate Password
        if (!password) {
            document.getElementById('password-error').innerHTML = 'Password is required.';
            return false;
        }

        

        return true; // Prevent the form from submitting the traditional way
    }
    </script>
</body>
</html>