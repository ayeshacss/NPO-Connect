<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Connect to the MySQL database
include 'db_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the user information from the form
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $fullName = $firstName . " " . $lastName;
    // Insert the user into the users table
    // actual table has fullname, email, password, user_type
    $insertQuery = "INSERT INTO users (fullname, email, password, user_type) VALUES ('$fullName', '$email', '$password', 'user')";
    $insertResult = mysqli_query($connection, $insertQuery);

    if ($insertResult) {
        // Redirect to the login page after successful registration
        header("Location: login.php");
        exit;
    } else {
        echo "Error registering the user: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - Register</title>
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
        <h2>Register:</h2>
        <form method="POST" action="">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required>
            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <!-- submit to register_process.php -->
            <button action="register_process.php" type="submit">Register</button>


        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
