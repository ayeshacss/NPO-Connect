<?php
// Start the session
session_start();
// Connect to the MySQL database
include 'db_connection.php';

// Check if the NPO ID is provided for deletion
if (isset($_GET['delete_id'])) {
    $npoId = $_GET['delete_id'];

    // Delete the NPO record from the "organizations" table
    $deleteQuery = "DELETE FROM organization WHERE organization_id = '$npoId'";
    $deleteResult = mysqli_query($connection, $deleteQuery);

    if ($deleteResult) {

        // Redirect back to the same page after successful deletion
        // header("Location: npo_list.php");

        // reload the page after successful deletion
        echo "<script>location.href='npo_list.php';</script>";
        exit;
    } else {
        echo "Error deleting NPO: " . mysqli_error($connection);
    }
}

// Retrieve NPO data from the "organizations" table
$query = "SELECT * FROM organization";

// Initialize the filter conditions array.
$conditions = [];

// Apply search filter if search query is provided
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search)) {
    $query .= " WHERE organization_name LIKE '%$search%' OR organization_id LIKE '%$search%' OR number LIKE '%$search%' OR address LIKE '%$search%' OR state LIKE '%$search%' OR city LIKE '%$search%' OR cause LIKE '%$search%'";
}

// Get distinct states
$statesQuery = "SELECT DISTINCT state FROM organization ORDER BY state";
$statesResult = mysqli_query($connection, $statesQuery);
$states = mysqli_fetch_all($statesResult, MYSQLI_ASSOC);

// Get distinct causes
$causesQuery = "SELECT DISTINCT cause FROM organization ORDER BY cause";
$causesResult = mysqli_query($connection, $causesQuery);
$causes = mysqli_fetch_all($causesResult, MYSQLI_ASSOC);



// Apply state filter if state is provided.
$state = isset($_GET['state']) ? $_GET['state'] : '';
if (!empty($state)) {
    $conditions[] = "state = '$state'";
}

// Apply cause filter if cause is provided.
$cause = isset($_GET['cause']) ? $_GET['cause'] : '';
if (!empty($cause)) {
    $conditions[] = "cause = '$cause'";
}

// Append conditions to the query.
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(' AND ', $conditions);
}

// Apply sort if sort column and order are provided
$sortColumn = isset($_GET['sort']) ? $_GET['sort'] : '';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : '';
if (!empty($sortColumn) && !empty($sortOrder)) {
    $query .= " ORDER BY $sortColumn $sortOrder";
}

// Apply pagination
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = isset($_GET['limit']) ? $_GET['limit'] : 5; // Number of records to display per page
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
    <title>NonProfitConnect - NPO Directory</title>
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

        h1 {
            color: #fff;
        }

        form {
            text-align: right;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            cursor: pointer;
            position: relative;
        }

        .sort-arrow {
            margin-left: 5px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        /* Additional CSS for hiding rows */
        .hidden {
            display: none;
        }

             .hidden {
            display: none;
        }

        .create {
            display: <?php echo ($_SESSION['user_type'] === 'user') || ($_SESSION['user_type'] === 'npoadmin') ? 'none' : 'flex'; ?>;
        }
        .actions{
            display: flex;
            height: 39.5px;
        }

        /*action buttons */
            button {
            margin: 0 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .UD {
            display: <?php echo ($_SESSION['user_type'] === 'superadmin') || ($_SESSION['user_type'] === 'npoadmin') ? 'flex' : 'none'; ?>;
            justify-content: flex-start;

        }
        .create{
            display: flex;
            justify-content: flex-end;
        }


        .pagination {
            margin-top: 10px;
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

        #numberSort {
          text-align: left;
        }

    </style>
    <script>
        function filterTable() {
            var searchInput = document.getElementById('search').value.toLowerCase();
            var table = document.getElementById('npoTable');
            var rows = table.getElementsByTagName('tr');

            for (var i = 1; i < rows.length; i++) {
                var rowData = rows[i].innerText.toLowerCase();
                if (searchInput === '' || rowData.indexOf(searchInput) > -1) {
                    rows[i].classList.remove('hidden');
                } else {
                    rows[i].classList.add('hidden');
                }
            }
        }

        function sortTable(column) {
            var order = 'asc';
            var currentSortColumn = document.getElementById('sortColumn').value;
            var currentSortOrder = document.getElementById('sortOrder').value;

            if (column === currentSortColumn && currentSortOrder === 'asc') {
                order = 'desc';
            }

            document.getElementById('sortColumn').value = column;
            document.getElementById('sortOrder').value = order;

            document.getElementById('sortForm').submit();
        }

        function deleteNPO(id) {
            if (confirm("Are you sure you want to delete this NPO?")) {
                window.location.href = 'npo_list.php?delete_id=' + id;
            }
        }


    </script>
</head>
<body>
    <header>
        <h1>NonProfitConnect - NPOs</h1>
    </header>
      <?php include 'navigation.php'; ?>
    <main>
        <h2>NPOs:</h2>
        <?php if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'superadmin') {

        echo '<div class="create"><button onclick="location.href=\'create_npo.php\'" title = "Create an NPO">Create NPO</button></div>';
        }
        ?>

        <div class="forms">
     <form id="sortForm" method="GET" action="">
        <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <label for="state">Filter by State:</label>
  <select name="state" id="state" onchange="this.form.submit()">
  <option value="">-- All --</option>
  <!-- Assume $states is an array of states from database -->
  <?php foreach ($states as $stateItem): ?>
    <option value="<?php echo $stateItem['state']; ?>" <?php echo ($_GET['state'] == $stateItem['state']) ? 'selected' : ''; ?>><?php echo $stateItem['state']; ?></option>
  <?php endforeach; ?>
  </select>

  <label for="cause">Filter by Cause:</label>
  <select name="cause" id="cause" onchange="this.form.submit()">
  <option value="">-- All --</option>
  <!-- Assume $causes is an array of causes from your database -->
  <?php foreach ($causes as $causeItem): ?>
    <option value="<?php echo $causeItem['cause']; ?>" <?php echo ($_GET['cause'] == $causeItem['cause']) ? 'selected' : ''; ?>><?php echo $causeItem['cause']; ?></option>
  <?php endforeach; ?>
  </select>
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

    </form>
    <form id="searchForm" method="GET" action="">
       <label for="search">Search:</label>
       <input type="text" name="search" id="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
    </form>
    </div>
  </div>


        <?php
        // Display the list of NPOs
        if (mysqli_num_rows($result) > 0) {
            echo "<table id=\"npoTable\">";

            $actionsHeader = ($_SESSION['user_type'] === 'superadmin' || $_SESSION['user_type'] === 'npoadmin') ? '<span><th>Actions</th></span>' : '';
            echo "<tr><th onclick=\"sortTable('organization_id')\">ID <span class=\"sort-arrow\">" . ($sortColumn === 'organization_id' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('organization_name')\">Name <span class=\"sort-arrow\">" . ($sortColumn === 'organization_name' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('number')\">Number <span class=\"sort-arrow\">" . ($sortColumn === 'number' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('cause')\">Cause <span class=\"sort-arrow\">" . ($sortColumn === 'cause' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('address')\">Address <span class=\"sort-arrow\">" . ($sortColumn === 'address' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('state')\">State <span class=\"sort-arrow\">" . ($sortColumn === 'state' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('city')\">City <span class=\"sort-arrow\">" . ($sortColumn === 'city' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th>" . ($actionsHeader !== '' ? $actionsHeader : '') . "</tr>";

            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['organization_id'] . "</td>";
                echo "<td>" . $row['organization_name'] . "</td>";
                echo "<td>" . $row['number'] . "</td>";
                echo "<td>" . $row['cause'] . "</td>";
                echo "<td>" . $row['address'] . "</td>";
                echo "<td>" . $row['state'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                // if session user_type is superadmin or npoadmin, show Update and Delete buttons

                $hideDeleteBtn = ($_SESSION['user_type'] !== 'superadmin' ) ? 'none' : '';

                $hideUpdateBtn = ($_SESSION['npo_id'] !== $row['organization_id'] && $_SESSION['user_type'] !== 'superadmin') ? 'none' : '';

                // $assign = ($_SESSION['user_type'] === 'superadmin') ? '<button title="Assign an Admin" onclick="location.href=\'assign_npoadmin.php?npo_id=' . $row['organization_id'] . '\'">Assign</button>' : '';
                // if session user_type is superadmin or npoadmin, show Update and Delete buttons
                if ($_SESSION['user_type'] == 'superadmin' || $_SESSION['user_type'] == 'npoadmin') {
                    echo "<td class='actions'><button style='display:$hideUpdateBtn' title=\"Update an NPO\" onclick=\"location.href='update_npo.php?id=" . $row['organization_id'] . "'\">Update</button><button title=\"Delate an NPO\" class='delete'  style='display:$hideDeleteBtn' onclick=\"deleteNPO(" . $row['organization_id'] . ")\" >Delete</button  ></td> ";

                    echo "";
                }

                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No NPOs found.";
        }
        ?>
        <div class="pagination">
            <?php
            // Display pagination links
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href=\"?page=$i&search=$search&sort=$sortColumn&order=$sortOrder&limit=$limit\"" . ($page == $i ? " class=\"active\"" : "") . ">$i</a>";
            }
            ?>
        </div>
    </main>
  <?php include 'footer.php'; ?>
</body>
</html>
