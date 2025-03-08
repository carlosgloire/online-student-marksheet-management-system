<?php 
session_start();
require_once('../../../database/DBConnection.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../../../css/index.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&family=Outfit:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulletin</title>
    <style>
        @media print {


            /* Ensure marks-content div takes 100% width */
            .marks-content {
                width: 100% !important;
            }
            .printButton {
                display: none;
            }
        }
    </style>
</head>
<body>

<section class="table-section">
    <?php
require_once('../../../models/update_query.php');

if (isset($_GET['student_id']) && !empty($_GET['student_id'])) {
    // Getting the form teacher id
    $id = $_GET['student_id'];
    $request = $conn->prepare("SELECT s.*, c.class_name
    FROM students_per_class s
    JOIN classes c ON s.class_id = c.class_id
    WHERE s.class_id = ? AND student_id = ?");

    $request->bind_param("ii", $class_id, $id);
    $request->execute();

    // Fetch the results
    $stmt = $request->get_result();
    $row = $stmt->fetch_assoc();

    if ($row) {
        $student_id = $row["student_id"];
        $regnumber = $row["regnumber"];
        $student_name = $row["fname"];
        $student_lname = $row["lname"];
        $class_name = $row["class_name"];
        $parentAdress = $row["parent_address"];
        $Dob = $row["Dob"];
        $Pob = $row["Pob"];
        ?>
        <div class="top-section">
            <div class="bulletin-title">
                <h2>REPUBLIC OF CAMEROON</h2>
                <h4>COLLEGE SAINT JEAN-BAPTISTE OF BANGANGTE</h4>
                <p>B.P 03 BANGANGTE</p>
                <p>DIOCESE OF BAFOUSSAM</p>
                <P>Phone: 243031465</P>
            </div>
            <div class="school-logo">
                <p><img src="../../../images/logo-st-jean.png" alt=""></p>
            </div>
        </div>

        <div class="identity">
            <div>
                <p>Registration number: <span><?= $regnumber?></span></p>
                <p>Names: <strong><?= $student_name.' '. $student_lname?></strong></p>
                <p>Parent address: <span><?= $parentAdress?></span></p>
            </div>
            <div>
                <p>Class: <?= $class_name?></p>
                <p>Date of Birth: <span><?=$Dob?></span></p>
                <p>Place of Birth: <span><?=$Pob?></span></p>
            </div>
            <div>
                <p>Students: <span><?php foreach($countstudent as $numberof_student) echo $numberof_student->studentID ?></span></p>
            </div>
        </div>
        <?php

        echo "<table>
                <tr>
                    <th>Modules</th>";
        // Output empty header cells for the trimester titles
        foreach ($trimesters as $trimester) {
            $trimester_name = $trimester['trimester_name'];
            echo "<th colspan='7'>$trimester_name</th>";
        }
        echo "</tr>";

        // Output row for "SQ" and "Comp" titles
        echo "<tr>
                <td></td>"; // Empty cell for the first column
        foreach ($trimesters as $trimester) {
            echo "<td>SQ</td><td>Comp</td><td>Av</td><td>Coef</td><td>TOT</td><td>Appr</td><td></td>";
        }
        echo "</tr>";

        // Initialize an array to store total marks for each trimester
        $total_trimester_marks = array();

        // Loop through each course
        foreach ($courses as $course) {
            $course_name = $course['course_name'];
            $course_id = $course['course_id'];
            $coefficient = $course['coefficient'];
            echo "<tr>
                    <td>$course_name</td>";

            // Loop through each trimester
            foreach ($trimesters as $trimester) {
                $trimester_id = $trimester['trim_id'];
                $trimester_name = $trimester['trimester_name'];
                // Fetch marks for the current course, trimester, and student
                $sql_marks = "SELECT ms.SQ, ms.comp
                            FROM marksheets ms
                            JOIN trimeters t ON ms.trim_id = t.trim_id
                            JOIN courses co ON ms.course_id = co.course_id
                            WHERE co.course_name = '{$course['course_name']}' AND t.trimester_name = '$trimester_name' AND ms.student_id = $student_id ";
                $result_marks = $conn->query($sql_marks);

                if (mysqli_num_rows($result_marks) > 0) {
                    {
                    // If marks are found, display them
                    $row_marks = $result_marks->fetch_assoc();
                    $av=($row_marks["SQ"] + $row_marks["comp"] )/2;
                    $tot=$av * $coefficient;

                    // Store total marks for the current trimester in the array
                    if (!isset($total_trimester_marks[$trimester_name])) {
                        $total_trimester_marks[$trimester_name] = 0;
                    }
                    $total_trimester_marks[$trimester_name] += $tot;
                    ?> <?= !empty($row_marks["SQ"]) ? "<td>{$row_marks['SQ']}</td>" : "<td>0</td>"; ?>
                    <?= !empty($row_marks["comp"]) ? "<td>{$row_marks['comp']}</td>" : "<td>0</td>"; ?>
                    <?= !empty($av) ? "<td>{$av}</td>" : "<td></td>"; ?>
                    <?= !empty($coefficient) ? "<td>{$coefficient}</td>" : "<td></td>"; ?>
                    <?= !empty($tot) ? "<td>{$tot}</td>" : "<td>0</td>"; ?>
                    <?= empty($av) ? "<td></td>" :
                        ($av < 10 ? "<td>F</td>" :
                            ($av >= 10 && $av < 12 ? "<td>E</td>" :
                                ($av >= 12 && $av < 13 ? "<td>D</td>" :
                                    ($av >= 13 && $av < 15 ? "<td>C</td>" :
                                        ($av >= 15 && $av < 17 ? "<td>B</td>" :
                                            ($av >= 17 && $av <= 20 ? "<td>A</td>" : "<td></td>")
                                        )
                                    )
                                )
                            )
                        ); ?>
                    
                    <?= "<td><a href='modify.php?student_id=$student_id&trimester_id=$trimester_id&course_id=$course_id'><i class='fa-regular fa-pen-to-square'></i></a></td>"; ?>

                 
                    <?php
                }
             } else {
                    // If no marks are found, display empty cells
                    echo "<td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
                }
            }
            echo "</tr>";
        }

        echo "</table>";
       
    
}  else {
    
    echo '<script>alert("student not found");</script>';
    echo '<script>window.location.href="bulletin.php";</script>';
    exit;

}

$conn->close(); // Close connection
}
?>
<a href="bulletin.php" style="color:#064469;font-size:1.8rem;"><i class="fa-regular fa-circle-left"></i></a>
</section>

</body>
</html>
