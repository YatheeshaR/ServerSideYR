<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: auto;
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #666;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007BFF;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php echo validation_errors('<p class="error">', '</p>'); ?>
        <?php echo form_open('/user/create_account'); ?>
            <label for="username">Username</label>
            <input type="text" name="username" required><br>

            <label for="email">Email</label>
            <input type="email" name="email" required><br>

            <label for="password">Password</label>
            <input type="password" name="password" required><br>

            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" required><br>

            <input type="submit" value="Register">
        <?php echo form_close(); ?>

				<a style="margin-top:10px" href="/user/login">Have an account? Login</a>
    </div>
</body>
</html>
