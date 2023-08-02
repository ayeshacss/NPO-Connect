<?php
session_start();

// Connect to the MySQL database
include 'db_connection.php';

// Check if the user ID is provided for deletion
if (isset($_GET['delete_id'])) {
    $userId = $_GET['delete_id'];

    // Delete the user record from the "users" table
    $deleteQuery = "DELETE FROM users WHERE id = '$userId'";
    $deleteResult = mysqli_query($connection, $deleteQuery);

    if ($deleteResult) {
        // Shift the remaining users' IDs
        $shiftQuery = "ALTER TABLE users DROP COLUMN id";
        mysqli_query($connection, $shiftQuery);

        $shiftQuery = "ALTER TABLE users ADD COLUMN id INT AUTO_INCREMENT PRIMARY KEY FIRST";
        mysqli_query($connection, $shiftQuery);

        $shiftQuery = "SET @new_id = 0";
        mysqli_query($connection, $shiftQuery);

        $shiftQuery = "UPDATE users SET id = @new_id:=@new_id+1 ORDER BY id";
        mysqli_query($connection, $shiftQuery);
    } else {
        echo "Error deleting user: " . mysqli_error($connection);
    }
}


// Retrieve user data from the "users" table
$query = "SELECT * FROM users";

// Apply search filter if search query is provided
$search = isset($_GET['search']) ? $_GET['search'] : '';
if (!empty($search)) {
    $query .= " WHERE fullname LIKE '%$search%' OR email LIKE '%$search%' OR password LIKE '%$search%' OR user_type LIKE '%$search%'";
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

// Retrieve user data with pagination from the "users" table
$countQuery = "SELECT COUNT(*) AS total FROM users";
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
    <title>User List</title>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        main {
            padding: 20px;
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
         .actions{
            display: flex;
            height: 100%;
        }

        /*action buttons */
        .actions button {
            margin: 0 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .sort-arrow {
            margin-left: 5px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
        }

        .hidden {
            display: none;
        }
        .create{
            display: flex;
            justify-content: flex-end;
        }

        .action-buttons button {
            margin-left: 5px;
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

        #sortForm{
        }
    </style>
    <script>
        function filterTable() {
            var searchInput = document.getElementById('search').value.toLowerCase();
            var table = document.getElementById('userTable');
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

        function deleteUser(id) {
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = 'users_list.php?delete_id=' + id;
            }
              
        }



    </script>
</head>
<body>
    <header>
        <h1>NonProfitConnect - Users</h1>
        </header>
         <?php include 'navigation.php'; ?>
        <main>
        <h2>Users:</h2>
        <div class="create">
            <button onclick="location.href='create_user.php'">Create User</button>
        </div>
        <form method="GET" action="">
            <label for="search">Search:</label>
            <input type="text" name="search" id="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" oninput="filterTable()">
        </form>
        <form id="sortForm" method="GET" action="">
            <input type="hidden" name="search" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            <input type="hidden" id="sortColumn" name="sort" value="<?php echo isset($_GET['sort']) ? $_GET['sort'] : ''; ?>">
            <input type="hidden" id="sortOrder" name="order" value="<?php echo isset($_GET['order']) ? $_GET['order'] : ''; ?>">
            <label for="entries">Show entries:</label>
            <select name="limit" id="entries" onchange="this.form.submit()">
                <option value="5" <?php echo ($limit == 5) ? "selected" : ""; ?>>5</option>
                <option value="10" <?php echo ($limit == 10) ? "selected" : ""; ?>>10</option>
                <option value="25" <?php echo ($limit == 25) ? "selected" : ""; ?>>25</option>
                <option value="50" <?php echo($limit == 50) ? "selected" : ""; ?>>50</option>
            </select>
        </form>
        <?php
        // Display the list of users
        if (mysqli_num_rows($result) > 0) {
            echo "<table id=\"userTable\">";
            echo "<tr><th onclick=\"sortTable('id')\">ID <span class=\"sort-arrow\">" . ($sortColumn === 'id' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('fullname')\">Full Name <span class=\"sort-arrow\">" . ($sortColumn === 'fullname' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('email')\">Email <span class=\"sort-arrow\">" . ($sortColumn === 'email' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th onclick=\"sortTable('user_type')\">User Type<span class=\"sort-arrow\">" . ($sortColumn === 'user_type' ? ($sortOrder === 'asc' ? '▲' : '▼') : '') . "</span></th><th>Actions</th></tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['fullname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['user_type'] . "</td>";
                echo "<td class=\"actions\"><button title=\"Update an NPO\" onclick=\"location.href='update_user.php?id=" . $row['id'] . "'\">Update</button><button title=\"Delete an NPO\" onclick=\"deleteUser(" . $row['id'] . ")\">Delete</button><button title=\"Assign an NPO\" onclick=\"location.href='assign.php?id=" . $row['id'] . "'\">Assign</button></td>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";

            // Display pagination links
            echo "<div class=\"pagination\">";
            for ($i = 1; $i <= $totalPages; $i++) {
                echo "<a href=\"users_list.php?page=$i&limit=$limit&sort=$sortColumn&order=$sortOrder\"" . ($page == $i ? " class=\"active\"" : "") . ">$i</a>";
            }
            echo "</div>";
        } else {
            echo "<p>No users found.</p>";
        }

        // Close the database connection
        mysqli_close($connection);
        ?>
    </main>
 <?php include 'footer.php'; ?>
</body>
</html>
