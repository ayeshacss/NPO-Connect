<?php
session_start();
// Connect to the MySQL database
include 'db_connection.php';

// Check if the form is submitted for creating the user record
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the values from the form
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];
    $assignedNpoId = $_POST['assigned_npo'];

    // Create the user record in the "users" table
    $createQuery = "INSERT INTO users (fullname, email, password, user_type, npo_id) VALUES ('$fullname', '$email', '$password', '$userType', '$assignedNpoId')";
    $createResult = mysqli_query($connection, $createQuery);

    if ($createResult) {
        // Redirect back to the main PHP file or any desired page
        header("Location: users_list.php");
        exit;
    } else {
        echo "Error creating user: " . mysqli_error($connection);
    }
}

// Retrieve all NPOs from the "organizations" table for the dropdown
$npoQuery = "SELECT organization_id, organization_name FROM organization";
$npoResult = mysqli_query($connection, $npoQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - Create User</title>
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
        <h2>Create User:</h2>
        <form method="POST" action="">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" required>

            <label for="email">Email:</label>
            <input type="text" name="email" id="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <label for="user_type">User Type:</label>
            <select name="user_type" id="user_type" required>
                <option value="superadmin">Super Admin</option>
                <option value="npoadmin">Npo Admin</option>
                <option value="user">User</option>
            </select>

            <label for="assigned_npo">Assign NPO:</label>
            <select name="assigned_npo" id="assigned_npo">
                <option value="">Choose an NPO</option>
                <?php
                // Populate the dropdown with NPO names
                while ($npoRow = mysqli_fetch_assoc($npoResult)) {
                    echo "<option value=\"" . $npoRow['organization_id'] . "\">" . $npoRow['organization_name'] . "</option>";
                }
                ?>
            </select>

            <button type="submit">Create User</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
