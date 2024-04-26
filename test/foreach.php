<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Grades</title>
</head>
<body>
    <h1>Student Grades</h1>

    <?php
    // Sample multidimensional array of students and grades
    $students = array(
        array("name" => "Alice", "grades" => array(85, 92, 88)),
        array("name" => "Bob", "grades" => array(78, 85, 90)),
        array("name" => "Charlie", "grades" => array(90, 87, 84))
    );
    ?>

    <table border="1">
        <tr>
            <th>Student Name</th>
            <th>Grades</th>
        </tr>
        <?php
        // Outer loop to iterate over each student
        foreach ($students as $student) {
            echo "<tr>";
            echo "<td>" . $student["name"] . "</td>";

            // Inner loop to iterate over each grade of the current student
            echo "<td>";
            foreach ($student["grades"] as $grade) {
                echo $grade . " ";
            }
            echo "</td>";
            echo "</tr>";
        }
        ?>
    </table>
</body>
</html>
