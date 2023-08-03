<?php
session_start();

// Connect to the MySQL database
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the users table to check if the entered credentials are valid
    $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) === 1) {
        // Valid credentials, set the user type in the session
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_type'] = $user['user_type'];

        // Store the npo_id in a session variable
        $_SESSION['npo_id'] = $user['npo_id'];
        
        // Redirect to the main PHP file or any other page
        header("Location: npo_list.php");
        exit;
    } else {
        // Invalid credentials
        echo "Invalid email or password";
    }
}



// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 20px;
        }

        main {
            padding: 20px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: white;
        }

        form {
            width: 400px;
            margin-top: 20px;
            margin-right: 0;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 5px;
            font-size: 16px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header>
        <h1>NonProfitConnect</h1>
    </header>
    <?php include 'navigation.php'; ?>
    <main>
        <h2>Login</h2>
        <form method="POST" action="">
            <label for="email">Username:</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
