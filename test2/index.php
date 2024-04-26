<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Bulletin</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<h2>Student Bulletin</h2>
<section>
    <?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "students_marksheet_management_system";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $class_id = 3; // Example class ID

    // Fetch distinct courses for the given class ID
    $sql_courses = "SELECT DISTINCT c.course_name 
                    FROM courses c
                    JOIN courses cc ON c.course_id = cc.course_id
                    WHERE cc.class_id = $class_id";
    $result_courses = $conn->query($sql_courses);
    $courses = [];
    if ($result_courses->num_rows > 0) {
    while($row_course = $result_courses->fetch_assoc()) {
        $courses[] = $row_course["course_name"];
    }
    }

    // Fetch distinct trimesters
    $sql_trimesters = "SELECT DISTINCT trimester_name FROM trimeters";
    $result_trimesters = $conn->query($sql_trimesters);
    $trimesters = [];
    if ($result_trimesters->num_rows > 0) {
    while($row_trimester = $result_trimesters->fetch_assoc()) {
        $trimesters[] = $row_trimester["trimester_name"];
    }
    }

    // Fetch students with their class name for the given class ID
    $sql_students = "SELECT s.*, c.class_name
                    FROM students_per_class s
                    JOIN classes c ON s.class_id = c.class_id
                    WHERE s.class_id = $class_id";
    $result_students = $conn->query($sql_students);

    if ($result_students->num_rows > 0) {
    // Loop through each student
    while($row_student = $result_students->fetch_assoc()) {
        $student_id = $row_student["student_id"];
        $student_name = $row_student["fname"];
        $student_lname = $row_student["lname"];
        $class_name = $row_student["class_name"];
        ?>
        <div class="top-section">
                <div class="bulletin-title">
                    <h2>REPUBLIC OF CAMEROON</h2>
                    <h4>COLLEGE SAINT JEAN-BAPTISTE</h4>
                    <p>B.P 50 DOUALA</p>
                    <P>Phone: 1234567889</P>
                </div>
                <div class="school-logo">
                    <p><img src="../../../images/logo-st-jean.png" alt=""></p>
                </div>
            </div>

            <div class="identity">
                <div>
                    <p>Matricule: <span>012345</span></p>
                    <p>Names: <strong>NDAISABA RENZAHO Gloire</strong></p>
                    <p>Parent adress: <span>DOUALA</span></p>
                </div>
                <div>
                    <p>Classe: 1st level</p>
                    <p>Date of the birth: <span>00.00.00</span></p>
                    <p>Place of the birth: <span>Goma</span></p>
                </div>
                <div>
                    <p>Eff: <span>40</span></p>
                </div>
            </div>
        <?php
        echo "<h3>Student: $student_name  $student_lname</h3>";
        echo "<h3>Class: $class_name</h3>";
        // Output header row
        echo "<table>
                <tr>
                    <th>Course</th>";
        // Output empty header cells for the trimester titles
        foreach ($trimesters as $trimester) {
        echo "<th colspan='2'>$trimester</th>";
        }
        echo "</tr>";

        // Output row for "SQ" and "Comp" titles
        echo "<tr>
                <td></td>"; // Empty cell for the first column
        foreach ($trimesters as $trimester) {
        echo "<td>SQ</td><td>Comp</td>";
        }
        echo "</tr>";

        // Loop through each course
        foreach ($courses as $course) {
        echo "<tr>
                <td>$course</td>";
        // Loop through each trimester
        foreach ($trimesters as $trimester) {
            // Fetch marks for the current course, trimester, and student
            $sql_marks = "SELECT ms.SQ, ms.comp
                        FROM marksheets ms
                        JOIN trimeters t ON ms.trim_id = t.trim_id
                        JOIN courses co ON ms.course_id = co.course_id
                        WHERE co.course_name = '$course' AND t.trimester_name = '$trimester' AND ms.student_id = $student_id ";
            $result_marks = $conn->query($sql_marks);
            
            if ($result_marks->num_rows > 0) {
            // If marks are found, display them
            $row_marks = $result_marks->fetch_assoc();
            echo "<td>" . $row_marks["SQ"] . "</td><td>" . $row_marks["comp"] . "</td>";
            } else {
            // If no marks are found, display empty cells
            echo "<td></td><td></td>";
            }
        }
        echo "</tr>";
        }

        echo "</table>";
    }
    } else {
    echo "0 results";
    }

    $conn->close();
    ?>
</section>



</body>
</html>
