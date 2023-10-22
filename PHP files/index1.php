<!DOCTYPE html>
<html>
<head>
    <title>PHP Assignment Login page</title>
    <style>
        /* CSS styleing for the page */
        body {
            background-image: url('https://th.bing.com/th/id/OIP.e2xF-DPmBmFBEB124A_OTgHaEo?w=220&h=180&c=7&r=0&o=5&dpr=1.3&pid=1.7');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }

        h1 {
            color: #ffffff;
            text-align: center;
            padding-top: 100px;
        }

        .login-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .login-container label {
            display: block;
            margin-bottom: 10px;
            color: #333;
            font-weight: bold;
        }

        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .login-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Welcome PHP task login</h1>
    <div class="login-container">
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>
