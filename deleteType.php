<?php
    include 'dbconnect.php';
    $conn = getDBConnection();

    $sql = "DELETE FROM employmenttype WHERE id = " . $_GET['id'];

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    header("Location:addRemoveEmploymentTypes.php");
?>