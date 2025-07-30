<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require '../../includes/auth.php';
redirectIfNotLoggedIn();

// Optionally, restrict access by role
checkRole(['Admin', 'Registrar']);

if (file_exists('../../includes/db_connection.php')) {
    require_once '../../includes/db_connection.php';
} else {
    die('Database connection file not found!');
}
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to the login page
    header("Location: http://localhost/capst/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Load Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Load Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <nav id="navbar-placeholder">
        <p>Loading navbar...</p>
    </nav>
    <div class="main-content" id="mainContent">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ul class="breadcrumb">
                <li><a href="#">Home</a></li>
                <li><a href="#">Enrollment</a></li>
                <li><a href="#">Statistics</a></li>
                <li><a href="Main3.php">Course Schedule</a></li>
                <li class="active">Course Schedule-Statistics</li>

            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>STATISTICS-COURSE SCHEDULE PAGE</h1>
        </section>

        <!-- Table -->
        <div class="container mx-auto mt-10" id="printableTable">
            <table class="min-w-full bg-white border border-gray-300 text-sm ">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="py-3 px-6 text-center">COURSES</th>
                        <th class="py-3 px-6 text-center">SECTION</th>
                        <th class="py-3 px-6 text-center">ROOM NUMBER</th>
                        <th class="py-3 px-6 text-center">TIME</th>
                        <th class="py-3 px-6 text-center">DAY</th>
                        <th class="py-3 px-6 text-center">FACULTY</th>
                        <th class="py-3 px-6 text-center">NO. OF STUDENTS</th>
                    </tr>
                    <tr>
                        <th colspan="7" class="py-3 px-5 text-center text-black ;" style="padding-top: 4px; padding-bottom: 4px;">College of Informatics and Computing Studies</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="py-3 px-6">CIS324-18</td>
                        <td class="py-3 px-6">3 BSIS-1</td>
                        <td class="py-3 px-6">B234</td>
                        <td class="py-3 px-6">7:00am-10:00am</td>
                        <td class="py-3 px-6">T</td>
                        <td class="py-3 px-6">Professor's Name</td>
                        <td class="py-3 px-6">20</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6">CIT421-18</td>
                        <td class="py-3 px-6">4 BSIT-3</td>
                        <td class="py-3 px-6">T.B.A</td>
                        <td class="py-3 px-6">7:00am-11:00am</td>
                        <td class="py-3 px-6">T</td>
                        <td class="py-3 px-6">Professor's Name</td>
                        <td class="py-3 px-6">18</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-3 px-6">CITFE3-18</td>
                        <td class="py-3 px-6">4 BSIT-2</td>
                        <td class="py-3 px-6">T.B.A</td>
                        <td class="py-3 px-6">7:00am-10:00am</td>
                        <td class="py-3 px-6">M</td>
                        <td class="py-3 px-6">Professor's Name</td>
                        <td class="py-3 px-6">20</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6">CSL222-18</td>
                        <td class="py-3 px-6">2 BSCS-1</td>
                        <td class="py-3 px-6">B235</td>
                        <td class="py-3 px-6">7:00am-10:00am</td>
                        <td class="py-3 px-6">T</td>
                        <td class="py-3 px-6">Professor's Name</td>
                        <td class="py-3 px-6">15</td>
                    </tr>
                    <tr>
                        <td class="py-3 px-6">EMCEL2-18</td>
                        <td class="py-3 px-6">3BSEMC-1</td>
                        <td class="py-3 px-6">M220</td>
                        <td class="py-3 px-6">7:00am-10:00am</td>
                        <td class="py-3 px-6">M</td>
                        <td class="py-3 px-6">Professor's Name</td>
                        <td class="py-3 px-6">17</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-center mt-6">
            <a href="Main3.php" class="bg-blue-900 text-white rounded-md p-2">Back</a>
            <button onclick="printOnlyTable()" class="ml-4 bg-red-500 text-white rounded-md p-2">Print</button>
        </div>


        <script>
            // Load navbar dynamically
            (function loadNavbar() {
                fetch('../../Components/Navbar.php')
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Navbar.html does not exist or is inaccessible');
                        }
                        return response.text();
                    })
                    .then(html => {
                        document.getElementById('navbar-placeholder').innerHTML = html;
                        // Dynamically load app.js if not already loaded
                        if (!document.querySelector('script[src="../../Components/app.js"]')) {
                            const script = document.createElement('script');
                            script.src = '../../Components/app.js';
                            script.defer = true;
                            document.body.appendChild(script);
                        }
                    })
                    .catch(error => {
                        console.error('Error loading navbar:', error);
                        document.getElementById('navbar-placeholder').innerHTML =
                            '<p style="color: red; text-align: center;">Navbar could not be loaded.</p>';
                    });
            })();

            function printOnlyTable() {
                // Get the content of the table
                var printContents = document.getElementById('printableTable').innerHTML;

                // Save the current page content
                var originalContents = document.body.innerHTML;

                // Replace the body content with the table
                document.body.innerHTML = printContents;

                // Print the page (now only the table is displayed)
                window.print();

                // Restore the original page content after printing
                document.body.innerHTML = originalContents;

                // Reload the page to restore the JavaScript functionality
                location.reload();
            }
        </script>
</body>

</html>
<style scoped>
    .breadcrumb-nav {
        margin: 0;
        margin-bottom: 5px;
        font-size: 14px;
    }

    .breadcrumb {
        list-style: none;
        display: flex;
        flex-wrap: wrap;
        padding: 0;
    }

    .breadcrumb li {
        margin-right: 10px;
    }

    .breadcrumb li a {
        color: #174069;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb li a:hover {
        color: #20568B;
    }

    .breadcrumb li.active {
        color: orange;
        pointer-events: none;
    }

    .breadcrumb li::after {
        content: ">";
        margin-left: 10px;
        color: #174069;
    }

    .breadcrumb li:last-child::after {
        content: "";
    }

    /* 201 File Section */
    .section-header {
        background-color: #174069;
        padding: 20px;
        text-align: center;
        margin-bottom: 20px;

    }

    .section-header h1 {
        color: white;
        margin: 0;
    }

    th {
        background-color: #f2f2f2;
    }

    .header-row {
        background-color: #d3d3d3;
        font-weight: bold;
    }

    .status {
        margin-top: 20px;
    }

    .status span {
        font-weight: bold;
    }

    table,
    th,
    td {
        border: 1px solid black;
        /* Black border for all table cells */
    }

    th,
    td {
        padding: 10px;
        /* Adds padding for better readability */
        text-align: center;
    }
</style>
</body>

</html>