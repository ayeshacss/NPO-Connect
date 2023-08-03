<?php
session_start();
// Connect to the MySQL database
include 'db_connection.php';

// Check if the NPO ID is provided
if (isset($_GET['id'])) {
    $npoId = $_GET['id'];

    // Retrieve the NPO record from the "organizations" table
    $query = "SELECT * FROM organization WHERE organization_id = '$npoId'";

    // Check if the logged in user's NPO ID matches the NPO ID in the URL
    if ($_SESSION['npo_id'] != $npoId && $_SESSION['user_type'] != 'superadmin') {
        echo "You are not authorized to update this NPO.";
        exit;
    } else {
        $result = mysqli_query($connection, $query);
    }

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $organizationName = $row['organization_name'];
        $number = $row['number'];
        $address = $row['address'];
        $state = $row['state'];
        $city = $row['city'];
        $description = $row['description'];
        $cause = $row['cause'];
        $logoPath = $row['image']; // Gets the existing logo path
    } else {
        echo "NPO not found.";
        exit;
    }
} else {
    echo "NPO ID not provided.";
    exit;
}



// Checks if the form is submitted for updating the NPO record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated values from the form
    $organizationName = $_POST['organization_name'];
    $number = $_POST['number'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $cause = $_POST['cause'];
    $description = $_POST['description'];

    // Handle logo upload if a new logo is provided
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $logoName = $_FILES['image']['name'];
        $logoTmpName = $_FILES['image']['tmp_name'];
        $logoPath = "images/" . $logoName; 

        move_uploaded_file($logoTmpName, $logoPath);
    }

    // Update the NPO record in the "organizations" table
    $updateQuery = "UPDATE organization SET organization_name = '$organizationName', number = '$number', address = '$address', state = '$state', city = '$city', cause = '$cause', description = '$description', image = '$logoPath' WHERE organization_id = '$npoId'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // Redirect back to the main PHP file
        header("Location: npo_list.php");
        exit;
    } else {
        echo "Error updating NPO: " . mysqli_error($connection);
    }
}

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - Update NPO</title>
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

        input {
            width: 100%;
            padding: 5px;
            font-size: 16px;
        }

        button {
            display: block;
            padding: 10px 20px;
            margin-top: 20px;
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
        <h2>Update NPO:</h2>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="organization_name">Organization Name:</label>
            <input type="text" name="organization_name" id="organization_name" value="<?php echo $organizationName; ?>" required>
            <label for="number">Number:</label>
            <input type="text" name="number" id="number" value="<?php echo $number; ?>" required>
            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo $address; ?>" required>
            <label for="state">State:</label>
            <input type="text" name="state" id="state" value="<?php echo $state; ?>" required>
            <label for="city">City:</label>
            <input type="text" name="city" id="city" value="<?php echo $city; ?>" required>
            <label for="cause">Cause:</label>
            <input type="text" name="cause" id="cause" value="<?php echo $cause; ?>" required>
            <label for="description" > Description:</label>
            <textarea name= "description" id="description" rows=5 cols=50 value="<?php echo $description; ?>"><?php echo $description; ?></textarea>
            <label for="image">Choose New Image:</label>
            <input type="file" name="image" id="image" accept="image/*">
            <button type="submit">Update</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
