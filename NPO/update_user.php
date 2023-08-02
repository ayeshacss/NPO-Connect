<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

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
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $userType = $_POST['user_type'];

    // Update the user record in the "users" table
    $updateQuery = "UPDATE users SET fullname = '$fullname', email = '$email', password = '$password', user_type = '$userType' WHERE id = '$userId'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // Redirect back to the main PHP file
        header("Location: users_list.php");
        exit;
    } else {
        echo "Error updating user: " . mysqli_error($connection);
    }
}

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
        <h2> Update User:
        <form method="POST" action="">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" value="<?php echo $fullname; ?>" required>
            <label for="email">Email:</label>
            <input type="text" name="email" id="email" value="<?php echo $email; ?>" required>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="<?php echo $password; ?>" required>
            <label for="user_type">User Type:</label>
            <select name="user_type" id="user_type" required>
                <option value="superadmin" <?php echo ($userType == 'superadmin') ? 'selected' : ''; ?>>Super Admin</option>
                <option value="npoadmin" <?php echo ($userType == 'npoadmin') ? 'selected' : ''; ?>>Npo Admin</option>
                <option value="user" <?php echo ($userType == 'user') ? 'selected' : ''; ?>>User</option>
            </select>
            <button type="submit">Update</button>
        </form>
    </main>
  <?php include 'footer.php'; ?>
</body>
</html>
