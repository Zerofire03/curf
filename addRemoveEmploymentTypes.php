<?php
    include 'dbconnect.php';

    $conn = getDBConnection();

    function displayEmploymentTypes()
    {
        global $conn;
        //SQL to return employment types in DB
        $sql = "SELECT * FROM employmenttype";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $employmentTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $employmentTypes;
    }
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Add/Remove Employment Types</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script>
            function confirmDelete()
            {
                return confirm("Are you sure you want to delete the employment type?");
            }
        </script>
    </head>
    <body>
        <h1>Add or Remove</h1>
        <?php
            $records = displayEmploymentTypes();
            echo "<table>";
            echo "<thead>
                    <tr>
                        <th scope='col'>Item ID</th>
                        <th scope='col'>Type</th>
                    </tr>
                </thead>";
            echo "<tbody>";
            foreach($records as $record)
            {
                echo "<tr>";
                echo "<td>" . $record['id'] . "</td>";
                echo "<td>" . $record['type'] . "</td>";
                echo "<td><a class='btn btn-primary' href='updateProduct.php?itemId=" . $record['id'] . "'>Update</a></td>";

                echo "<form action='deleteType.php' onsubmit='return confirmDelete()'>";
                echo "<input type='hidden' name='id' value= " . $record['id'] . " />";
                echo "<td><input type='submit' class='btn btn-danger' value='Remove'></td>";
                echo "</form>";
            }
            echo "</tbody>";
            echo "</table>";
        ?>
    </body>
</html>