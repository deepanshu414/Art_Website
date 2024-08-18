<?php
// db_connect.php

// Establishes a connection to the MySQL database.
function getDbConnection() {
    // Database connection parameters
    $host = "localhost";     // The hostname of your database server (often 'localhost')
    $username = "root";      // Your MySQL username
    $password = "Your_password";         // Your MySQL password
    $database = "artstore";  // The name of your database

    // Attempt to establish a connection to the database
    $conn = new mysqli($host, $username, $password, $database);

    // Check if the connection was successful
    if ($conn->connect_error) {
        // If connection fails, terminate the script and display an error message
        die("Connection failed: " . $conn->connect_error);
    }

    // If connection is successful, return the connection object
    return $conn;
}
?>
