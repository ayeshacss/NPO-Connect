<?php
// Start the session
session_start();
// Connect to the MySQL database
include 'db_connection.php';

// Retrieve NPO data from the "organizations" table
$query = "SELECT state, COUNT(*) AS count FROM organization GROUP BY state ORDER BY count DESC";
$query2 = "SELECT cause, COUNT(*) AS count FROM organization GROUP BY cause ORDER BY count DESC";

// Execute the query and fetch the results
$result = mysqli_query($connection, $query);
$result2 = mysqli_query($connection, $query2);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - NPO Reports</title>
    <style>
    h1 {
      text-align:center;
    }

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

    .tables-container {
        display: flex;
        justify-content: space-around;
        padding: 20px;
    }

    table {
        margin-top: 20px;
        margin-bottom: 30px;
        border-collapse: collapse;
        width: 45%;
        text-align: center;
        border-radius: 5px;
        overflow: hidden;
        box-shadow: 0px 2px 15px rgba(0,0,0,0.1);
    }

    td:nth-child(1) {
    border-right: 2px solid #C9ADA7;
  }

  td {
    padding: 3px;
    border-bottom: 1px solid #C9ADA7;
  }


    th {
      padding: 10px;
      background-color: #F2F2F2;
    }

    footer {
        background-color: #333;
        color: #fff;
        padding: 20px;
        text-align: center;
    }
    </style>
</head>
<body>
    <header>
        <h1>NPO Summary</h1>
    </header>
    <?php include 'navigation.php'; ?>
    <main>
        <div class="tables-container">
        <?php
        if (mysqli_num_rows($result) > 0) {
            echo "<table>";
            echo "<tr><th>State </th><th>NPO Count</th></tr>";  // Add table headers

            // Output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['state'] . "</td>";
                echo "<td>" . $row['count'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo 'No data found.';
        }

        if (mysqli_num_rows($result2) > 0) {
            echo "<table>";
            echo "<tr><th>Causes </th><th>Summary</th></tr>";  // Add table headers

            // Output data of each row
            while ($row = mysqli_fetch_assoc($result2)) {
                echo "<tr>";
                echo "<td>" . $row['cause'] . "</td>";
                echo "<td>" . $row['count'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo 'No data found.';
        }
        ?>
        </div>
    </main>
 <?php include 'footer.php'; ?>
</body>
</html>