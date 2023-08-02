<!-- navigation.php -->
<style>
       header {
            background-color: #22223B;
            color: white;
            padding: 20px;
        }

        nav {
            background-color: #9A8C98;
            padding: 10px;
            max-width: 100%;
        }

        .navLinks {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }

        .navLinks li {
            margin-right: 10px;
        }

        .navLink {
            color: #22223B;
            text-decoration: none;
            font-weight: bold;
            padding: 5px;
        }

        .navLink:hover {
            background-color: #22223B;
            color: #fff;
        }
</style>
<nav>
    <!-- Title -->
   <ul class="navLinks" id="navLinks">

<!--  home page link -->
<li><a class="navLink" href="home.php">Home</a></li>
<li><a class="navLink" href="npo_list.php">Non-Profits</a></li>
<li><a class="navLink" href="help.php">Help</a></li>
<li><a class="navLink" href="reports.php">Reports</a></li>
   <!-- Show the following links only to logged in users with the user_type of "superadmin" -->
    <?php if (isset($_SESSION['user_type'])): ?>

            <?php if ($_SESSION['user_type'] == 'superadmin'): ?>
                    <li><a class="navLink" href="users_list.php">Users</a></li>
                    <?php endif; ?>
                    <li><a class="navLink" href="logout.php">Logout</a></li>
    <?php else: ?>
        <li><a class="navLink" href="login.php">Login</a></li>
    <?php endif; ?>

   </ul>
</nav>
