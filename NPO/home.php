<?php
session_start();

// Connect to the MySQL database
include 'db_connection.php';

// Retrieve NPO data from the "organizations" table
$query = "SELECT * FROM organization";

// Apply search filter if search query is provided
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search)) {
    $query .= " WHERE organization_name LIKE '%$search%' OR address LIKE '%$search%' OR state LIKE '%$search%' OR city LIKE '%$search%'";
}

// Apply sort if sort column and order are provided
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : '';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : '';
if (!empty($sortColumn)) {
    $query .= " ORDER BY $sortColumn $sortOrder";
}
// Apply pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 10; // Number of records to display per page
$offset = ($page - 1) * $limit;

// Retrieve NPO data with pagination from the "organizations" table
$countQuery = "SELECT COUNT(*) AS total FROM organization";
$countResult = mysqli_query($connection, $countQuery);
$totalRows = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRows / $limit);

$query .= " LIMIT $limit OFFSET $offset";

// Execute the query and fetch the results
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - Home</title>
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
        h1{
            max-width: fit-content;
        }
        main{
            /* max-width: 1200px; */
            margin: 0 auto;
            padding: 20px;
        }
        main > .npo-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 20px;
        }
        .npo-cards{
            margin-top: 2rem;
        }
        a{
            text-decoration: none;
            color: #333;
        }
        .npo-card {
        
            border: 1px solid #ddd;
            padding-bottom: 10px;
            text-align: center;
            box-shadow: 0 0 5px #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .npo-image {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .npo-name {
            font-weight: bold;
        }

        .npo-location {
            color: #888;
        }
        .forms{
            display: flex;
            justify-content: space-between;
            padding:40px 20px 0 20px;

        }
        .pagination {
            margin-top: 10px;
            text-align: center;
        }

        .pagination a {
            display: inline-block;
            padding: 5px;
            margin-right: 5px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
        }

        .pagination a.active {
            background-color: #333;
            color: #fff;
        }

        #sortForm {
            text-align: left;
        }






    </style>
</head>
<body>
    <header>
        <h1>NonProfitConnect</h1>
    </header>
    <?php include 'navigation.php'; ?>
    <main>
        <div class="forms">
     <form id="sortForm" method="GET" action="">
        <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <label for="sort">Sort By:</label>
        <select name="sort" id="sort" onchange="document.getElementById('sortForm').submit()">
            <option value="" <?php echo ($sortColumn === '') ? 'selected' : ''; ?>>-- No Sorting --</option>
            <option value="organization_name" <?php echo ($sortColumn === 'organization_name') ? 'selected' : ''; ?>>Name</option>
            <option value="city" <?php echo ($sortColumn === 'city') ? 'selected' : ''; ?>>City</option>
            <option value="state" <?php echo ($sortColumn === 'state') ? 'selected' : ''; ?>>State</option>
        </select>

        <input type="hidden" id="sortOrder" name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : ''; ?>">
        <label for="entries">Show entries:</label>
        <select name="limit" id="entries" onchange="this.form.submit()">
            <option value="5" <?php echo ($limit == 5) ? "selected" : ""; ?>>5</option>
            <option value="10" <?php echo ($limit == 10) ? "selected" : ""; ?>>10</option>
            <option value="15" <?php echo ($limit == 15) ? "selected" : ""; ?>>15</option>
            <option value="25" <?php echo ($limit == 25) ? "selected" : ""; ?>>25</option>
        </select>
    </form>
    <form id="searchForm" method="GET" action="">
       <label for="search">Search:</label>
       <input type="text" name="search" id="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    </form>
    </div>
</div>
        <?php
        // Display the list of NPOs in grid format
        echo "<div class=\"npo-cards\">";
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class=\"npo-card\">";
            echo "<a href=\"npo_details.php?npo_id=" . $row['organization_id'] . "\">";
            echo "<img class=\"npo-image\" src=\"" . $row['image'] . "\" alt=\"NPO Image\">";
            echo "<div class=\"npo-name\">" . $row['organization_name'] . "</div>";
            echo "<div class=\"npo-location\">" . $row['city'] . ", " . $row['state'] . "</div>";
            echo "</a>";
            echo "</div>";
        }
        echo "</div>";


        ?>
        <div class="pagination">
            <?php
            // Display pagination links
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href=\"home.php?page=$i&search=$search&sort=$sortColumn&order=$sortOrder&limit=$limit\"" . ($page == $i ? " class=\"active\"" : "") . ">$i</a>";
            }
            ?>
        </div>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
