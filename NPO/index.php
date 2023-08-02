<?php
session_start();
header("Location: npo_list.php");
if (isset($_SESSION['user_type'])) {
    // User is logged in, redirect to the appropriate page based on user type
    if ($_SESSION['user_type'] === 'superadmin' || $_SESSION['user_type'] === 'npoadmin') {
        header("Location: users_list.php");
        exit;
    } else {
        header("Location: home.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect</title>
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
            text-align: center;
        }

        main {
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
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
    <main>
        <h2>Welcome to NonProfitConnect!</h2>
        <button onclick="location.href='login.php'">Login</button>
        <button onclick="location.href='register.php'">Register</button>
    </main>
</body>
</html>
