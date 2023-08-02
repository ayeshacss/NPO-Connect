<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - NPO Details</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;600;700&family=Raleway:wght@600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', Arial, sans-serif;
            margin: 0 auto;
        }

        .npoDetails {
            width: 100%;
            max-width: 800px;
            margin: 2rem auto;
        }

        .heading, .npoImage, .npoText {
            text-align: center;
            color: black;
        }

        .npoImage {
            display: block;
            padding: 10px;
            max-width: 500px;
            max-height: 300px;
            margin: 0 auto;
            border-radius: 5px;
        }

        .npoText {
            color: black;
            padding-bottom: 50px;
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
    <h1>NonProfitConnect</h1>

  </header>
  <?php include 'navigation.php'; ?>
<?php
// Start the session
session_start();
// Connect to the MySQL database
include 'db_connection.php';

$npoId = $_GET['npo_id']; // Change "id" to "npo_id"

// Retrieve NPO data from the "organizations" table
$query = "SELECT * FROM organization WHERE organization_id = '$npoId'";

// Execute the query and fetch the results
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) { // Check if there are any results
    $row = mysqli_fetch_assoc($result);

    // Output the details for the NPO
    echo '<div class="npoDetails">';
    echo '<img class="npoImage" src="' . $row['image_url'] . '" alt="' . $row['organization_name'] . '">';
    echo '<div class="heading"><h1>' . $row['organization_name'] . '</h1>';
    echo '<p>Number: ' . $row['number'] . ' | ';
    echo 'Address: ' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . '</p></div>';
    echo '<div class="npoText">';
    echo $row['description'];
    echo '</div>'; // end of npoText
    echo '</div>'; // end of npoDetails

} else {
    echo "Error retrieving NPO details: " . mysqli_error($connection);
}

?>

</body>
<footer>
    <p>&copy; <?php echo date("Y"); ?> NonProfitConnect</p>
</footer>
</html>
