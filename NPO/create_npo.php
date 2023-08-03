<?php
session_start();

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
    $description = $_POST['description'];
    $cause = $_POST['cause'];

    // Handle logo upload if a logo is provided
    $logoPath = '';
    if ($_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logoName = $_FILES['logo']['name'];
        $logoTmpName = $_FILES['logo']['tmp_name'];
        $logoPath = "images/" . $logoName; // Customize the path as per your requirement

        move_uploaded_file($logoTmpName, $logoPath);
    }

    // Insert the new NPO record into the "organizations" table
    $insertQuery = "INSERT INTO organization (organization_name, number, address, state, city, description, cause, image) VALUES ('$organizationName', '$number', '$address', '$state', '$city','$description','$cause','$logoPath')";
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
            max-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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
        <form method="POST" action="" enctype="multipart/form-data">
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
            <label for="cause">Cause:</label>
            <input type="text" id="cause" name="cause" required>
            <label for="description" > Description:</label>
            <textarea name= "description" id="description" rows=5 cols=50></textarea>
            <!-- Add the following code for logo upload -->
            <label for="logo">Logo:</label>
            <input type="file" name="logo" id="logo" accept="image/*">

            <button type="submit">Create</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
