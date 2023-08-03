<?php
session_start();
// Connect to the MySQL database
include 'db_connection.php';

// Check if the user ID is provided
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Retrieve the user record from the "users" table
    $query = "SELECT * FROM users WHERE id = '$userId'";
    $result = mysqli_query($connection, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $fullname = $row['fullname'];
        $email = $row['email'];
        $password = $row['password'];
        $userType = $row['user_type'];
        $npoId = $row['npo_id']; // Assuming the column name in the users table is 'npo_id'
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "User ID not provided.";
    exit;
}

// Check if the form is submitted for updating the user record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the updated values from the form
    $userType = $_POST['user_type'];
    $npoId = $_POST['npo_id'];

    // Update the user record in the "users" table
    $updateQuery = "UPDATE users SET user_type = '$userType', npo_id = '$npoId' WHERE id = '$userId'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // Redirect back to the main PHP file
        header("Location: users_list.php");
        exit;
    } else {
        echo "Error updating user: " . mysqli_error($connection);
    }
}

// Fetch all NPOs from the "organizations" table
$npoQuery = "SELECT * FROM organization";
$npoResult = mysqli_query($connection, $npoQuery);

// Close the database connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - Update User</title>
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
            color: #333;
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

        select {
            width: 100%;
            padding: 5px;
            font-size: 16px;
        }

        button {
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
        <h2>User Information:</h2>
        <p><strong>Name:</strong> <?php echo $fullname; ?></p>
        <form method="POST" action="">
            <label for="user_type">User Type:</label>
            <select name="user_type" id="user_type" required>
                <option value="superadmin" <?php echo ($userType == 'superadmin') ? 'selected' : ''; ?>>Super Admin</option>
                <option value="npoadmin" <?php echo ($userType == 'npoadmin') ? 'selected' : ''; ?>>Npo Admin</option>
                <option value="user" <?php echo ($userType == 'user') ? 'selected' : ''; ?>>User</option>
            </select>
            <?php
                // Only show the dropdown for assigning NPOs if the user is a superadmin
                if ($_SESSION['user_type'] === 'superadmin') {
            ?>
            <label for="npo_id">Assign NPO:</label>
            <select name="npo_id" id="npo_id" required>
                <option value="">Select NPO</option>
                <?php
                    // Output options for all NPOs
                    while ($npoRow = mysqli_fetch_assoc($npoResult)) {
                        $selected = ($npoId == $npoRow['organization_id']) ? 'selected' : '';
                        echo "<option value=\"{$npoRow['organization_id']}\" $selected>{$npoRow['organization_name']}</option>";
                    }
                ?>
            </select>
            <?php
                }
            ?>
            <button type="submit">Assign</button>
            <?php
                // // Display the Delete button only for superadmin and npoadmin users
                // if ($_SESSION['user_type'] === 'superadmin') {
                //     echo "<button onclick=\"deleteUser($userId)\" style=\"background-color: red;\">Delete</button>";
                // }
            ?>
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
