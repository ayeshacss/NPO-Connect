<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>NonProfitConnect - Help</title>
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
            margin-bottom: 20px;
        }

        p {
            line-height: 1.6;
        }

        ul {
            list-style: disc;
            padding-left: 30px;
        }

        li {
            margin-bottom: 10px;
        }

    
    </style>
</head>
<body>
    <header>
        <h1>NonProfitConnect - Help</h1>
    </header>
    <?php include 'navigation.php'; ?>
    <main>
        <h2>How to Navigate NonProfitConnect</h2>
        <p>
            Welcome to NonProfitConnect! This web application allows you to explore various Non-Profit Organizations (NPOs)
            and their details. Here's a guide on how to navigate the website:
        </p>
        <h3>Home Page</h3>
        <p>
            The home page displays a grid of NPOs with their pictures, names, and locations. You can use the following features:
        </p>
        <ul>
            <li>
                <strong>Search:</strong> Use the search bar to search for specific NPOs by name, address, state, or city. Type in
                your search query and press Enter to see the results.
            </li>
            <li>
                <strong>Sorting:</strong> You can sort the NPOs by name, city, or state. Use the "Sort By" dropdown to choose the
                sorting criteria and click on the "Sort" button to apply the sorting.
            </li>
            <li>
                <strong>Show entries:</strong> Use the "Show entries" dropdown to select how many NPOs you want to see per page.
                The available options are 5, 10, 15, and 25.
            </li>
            <li>
                <strong>Pagination:</strong> The NPOs are displayed on multiple pages, and you can navigate between pages using the
                pagination links at the bottom of the page.
            </li>
        </ul>
        <h3>NPO Details Page</h3>
        <p>
            Click on an NPO's image or name in the grid to view its detailed information on a separate page. The NPO Details page
            provides the following information:
        </p>
        <ul>
            <li>
                <strong>Image:</strong> The NPO's picture is displayed at the top of the page.
            </li>
            <li>
                <strong>Name and Contact:</strong> The NPO's name and contact information are shown below the image.
            </li>
            <li>
                <strong>Description:</strong> The page contains a detailed description of the NPO's activities and mission.
            </li>
        </ul>
        <p>
            That's it! Enjoy exploring and learning about the various Non-Profit Organizations using NonProfitConnect.
        </p>
    </main>
<?php include 'footer.php'; ?>
</body>
</html>
