<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Connect to the MySQL database
include 'db_connection.php';


// Check if the form is submitted for creating a new NPO record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the values from the form
    $organizationName = $_POST['organization_name'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $image_url = $_POST['image_url'];
    $description = $_POST['description'];
    $cause = $_POST['cause'];

    // Insert the new NPO record into the "organizations" table
    $insertQuery = "INSERT INTO organization (organization_name, number, address, state, city, image_url, description, cause) VALUES ('$organizationName', '$number', '$address', '$state', '$city', '$imageUrl', '$description', '$cause')";
    $insertResult = mysqli_query($connection, $insertQuery);

    if ($insertResult) {
        // Redirect back to the main PHP file
        header("Location: npo_list.php");
        exit;
    } else {
        echo "Error creating NPO: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - Create NPO</title>
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
        }



        form {
            width: 400px;
            margin-top: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type="text"] {
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

        <h2>Create NPO:</h2>
        <form method="POST" action="">
            <label for="organization_name">Organization Name:</label>
            <input type="text" name="organization_name" id="organization_name" required>
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" required>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" required>
            <label for="state">State:</label>
            <input type="text" name="state" id="state" required>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" required>
            <label for="image">Image Location:</label>
            <input type="text" name="image" id="image" required>
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" required>
            <label for="cause">Cause:</label>
            <input type="text" name="cause" id="cause" required>
            <button type="submit">Create</button>
        </form>
    </main>
</body>
</html>
