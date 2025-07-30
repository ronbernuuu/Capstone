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
                <li><a href="Main2.php">Course</a></li>
                <li class="active">Course Statistics</li>

            </ul>
        </nav>
        <section class="section-header text-sm md:text-xl">
            <h1>STATISTICS-COURSES PAGE</h1>
        </section>


        <div class="container mx-auto mt-10">
            <div class="overflow-x-auto mt-9" id="printableTable">
            
            <?php include '../../Custom/Functions/Course/queries.php' ?>

            </div>
            <div class="mt-3">
                <a href="javascript:void(0);" id="deleteSelected"></a>
            </div>  
            <div class="flex justify-center mt-6">
                <a href="main2.php" class="bg-blue-900 text-white rounded-md p-2">Back</a>
                <button onclick="printOnlyTable()" class="ml-4 bg-red-500 text-white rounded-md p-2">Print</button>
            </div>
        </div>
    </div>


    <script>
        let deletedCourses = [];

        document.getElementById('deleteSelected').addEventListener('click', function() {
            const selectedCheckboxes = document.querySelectorAll('.selectRow:checked');
            selectedCheckboxes.forEach(checkbox => {
                const row = checkbox.closest('tr');
                const courseDetails = {
                    college: row.cells[0].innerText,
                    code: row.cells[1].innerText,
                    section: row.cells[2].innerText,
                    lecLab: row.cells[3].innerText,
                    enrolled: row.cells[4].innerText,
                    capacity: row.cells[5].innerText,
                    roomCapacity: row.cells[6].innerText,
                };
                deletedCourses.push(courseDetails); // Add to deleted courses list
                row.remove(); // Remove the row
            });
            localStorage.setItem('deletedCourses', JSON.stringify(deletedCourses));
        });

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

    .note {
        font-size: 12px;
        color: gray;
        margin-top: 10px;
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