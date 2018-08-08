<?php
function getDBConnection() {

    //Maria db info
    $host = "localhost";
    $dbName = "curf";
    $username = "root";
    $password = "";


    try {
        //Creates a database connection
        $dbConn = new PDO("mysql:host=$host;dbname=$dbName", $username, $password);

        // Setting Errorhandling to Exception
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
       echo "Problems connecting to database!";
       exit();
    }


    return $dbConn;
}
?>