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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Bulletins</title>
</head>
<body>

<section class="table-section">
    <?php
require_once('../../../models/table_queries.php');

if ($result_students->num_rows > 0) {
    // Loop through each student
    while($row_student = $result_students->fetch_assoc()) {
        $student_id = $row_student["student_id"];
        $regnumber = $row_student["regnumber"];
        $student_name = $row_student["fname"];
        $student_lname = $row_student["lname"];
        $class_name = $row_student["class_name"];
        $parentAdress = $row_student["parent_address"];
        $Dob = $row_student["Dob"];
        $Pob = $row_student["Pob"];
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
                <p>Registration number: <span><?= $regnumber?></span></p>
                <p>Names: <strong><?= $student_name.' '. $student_lname?></strong></p>
                <p>Parent adress: <span><?= $parentAdress?></span></p>
            </div>
            <div>
                <p>Classe: <?= $class_name?></p>
                <p>Date of the birth: <span><?=$Dob?></span></p>
                <p>Place of the birth: <span><?=$Pob?></span></p>
            </div>
            <div>
                <p>Students: <span><?php foreach($countstudent as $numberof_student)echo$numberof_student->studentID ?></span></p>
            </div>
        </div>
        <?php

        echo "<table>
                <tr>
                    <th>Modules</th>";
        // Output empty header cells for the trimester titles
        foreach ($trimesters as $trimester) {
            echo "<th colspan='6'>$trimester</th>";
        }
        echo "</tr>";

        // Output row for "SQ" and "Comp" titles
        echo "<tr>
                <td></td>"; // Empty cell for the first column
        foreach ($trimesters as $trimester) {
            echo "<td>SQ</td><td>Comp</td><td>Av</td><td>Coef</td><td>TOT</td><td>Appr</td>";
        }
        echo "</tr>";

        // Initialize an array to store total marks for each trimester
        $total_trimester_marks = array();

        // Loop through each course
        foreach ($courses as $course) {
            $course_name = $course['course_name'];
            $coefficient = $course['coefficient'];
            echo "<tr>
                    <td>$course_name</td>";

            // Loop through each trimester
            foreach ($trimesters as $trimester) {
                // Fetch marks for the current course, trimester, and student
                $sql_marks = "SELECT ms.SQ, ms.comp
                            FROM marksheets ms
                            JOIN trimeters t ON ms.trim_id = t.trim_id
                            JOIN courses co ON ms.course_id = co.course_id
                            WHERE co.course_name = '{$course['course_name']}' AND t.trimester_name = '$trimester' AND ms.student_id = $student_id ";
                $result_marks = $conn->query($sql_marks);

                if ($result_marks->num_rows > 0) {
                    // If marks are found, display them
                    $row_marks = $result_marks->fetch_assoc();
                    $av=($row_marks["SQ"] + $row_marks["comp"] )/2;
                    $tot=$av * $coefficient;

                    // Store total marks for the current trimester in the array
                    if (!isset($total_trimester_marks[$trimester])) {
                        $total_trimester_marks[$trimester] = 0;
                    }
                    $total_trimester_marks[$trimester] += $tot;
                    ?> <?= !empty($row_marks["SQ"]) ? "<td>{$row_marks['SQ']}</td>" : "<td></td>"; ?>
                    <?= !empty($row_marks["comp"]) ? "<td>{$row_marks['comp']}</td>" : "<td></td>"; ?>
                    <?= !empty($av) ? "<td>{$av}</td>" : "<td></td>"; ?>
                    <?= !empty($coefficient) ? "<td>{$coefficient}</td>" : "<td></td>"; ?>
                    <?= !empty($tot) ? "<td>{$tot}</td>" : "<td></td>"; ?>
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


                    <?php
                } else {
                    // If no marks are found, display empty cells
                    echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
                }
            }
            echo "</tr>";
        }

        echo "</table>";
        ?>
<div class="marks-content">
    <?php 
    // Initialize variables for Grand Total and Overall Rank
    $grand_total = 0;
    $overall_rank = 0;

    // Array to store total marks for each trimester
    $trimester_totals = array();

    // Loop through each trimester
    foreach ($trimesters as $trimester) {
        // Check if there are any courses with marks in this trimester for the student
        $sql_course_check = "SELECT COUNT(*) AS course_count
                             FROM marksheets ms
                             JOIN trimeters t ON ms.trim_id = t.trim_id
                             WHERE t.trimester_name = '$trimester' AND ms.student_id = $student_id";
        $result_course_check = $conn->query($sql_course_check);
        $course_count = 0;
        if ($result_course_check->num_rows > 0) {
            $row_course_check = $result_course_check->fetch_assoc();
            $course_count = $row_course_check['course_count'];
        }

        // Check if there are any marks for this trimester for the student
        $sql_total_marks = "SELECT SUM(SQ + comp) AS total
                            FROM marksheets ms
                            JOIN trimeters t ON ms.trim_id = t.trim_id
                            WHERE t.trimester_name = '$trimester' AND ms.student_id = $student_id";
        $result_total_marks = $conn->query($sql_total_marks);
        $total_marks = 0;
        if ($result_total_marks->num_rows > 0) {
            $row_total_marks = $result_total_marks->fetch_assoc();
            $total_marks = $row_total_marks['total'];
        }

        // If there are no courses with marks in this trimester, student is "Not classified"
        if ($course_count == 0) {
            echo "<div class='bulletin-result $trimester'>
                    <h4>$trimester</h4>";
            echo "<p>Rank: <span>Not classified</span></p>";
            echo "<p>Total: Not classified</p>
                  </div>";
        } else {
            // Calculate rank for the trimester
            $sql_rank = "SELECT COUNT(*) + 1 AS rank
                         FROM (
                             SELECT SUM(SQ + comp) AS total
                             FROM marksheets ms
                             JOIN trimeters t ON ms.trim_id = t.trim_id
                             WHERE t.trimester_name = '$trimester'
                             GROUP BY ms.student_id
                             HAVING total > $total_marks
                         ) AS ranks";
            $result_rank = $conn->query($sql_rank);
            $rank = 0;
            if ($result_rank->num_rows > 0) {
                $row_rank = $result_rank->fetch_assoc();
                $rank = $row_rank['rank'];
            }

            // Display the total marks and rank for the trimester
            echo "<div class='bulletin-result $trimester'>
                    <h4>$trimester</h4>";
            echo "<p>Rank: <span>" . ($rank > 0 ? $rank : 'Not classified') . "</span></p>";
            echo "<p>Total: $total_marks</p>
                  </div>";

            // Store total marks for this trimester
            $trimester_totals[$trimester] = $total_marks;
        }

        // Add the total marks for this trimester to the Grand Total
        $grand_total += $total_marks;
    }

    // Check if the student is "Not classified" for all trimesters, if so, skip ranking for Grand Total
    $all_trimesters_not_classified = true;
    foreach ($trimester_totals as $total) {
        if ($total != 0) {
            $all_trimesters_not_classified = false;
            break;
        }
    }

    // Calculate the overall rank based on Grand Total if the student is not "Not classified" for all trimesters
    if (!$all_trimesters_not_classified) {
        $sql_overall_rank = "SELECT COUNT(*) + 1 AS rank
                             FROM (
                                 SELECT SUM(SQ + comp) AS total
                                 FROM marksheets ms
                                 WHERE ms.student_id != $student_id
                                 GROUP BY ms.student_id
                                 HAVING total > $grand_total
                             ) AS ranks";
        $result_overall_rank = $conn->query($sql_overall_rank);
        if ($result_overall_rank->num_rows > 0) {
            $row_overall_rank = $result_overall_rank->fetch_assoc();
            $overall_rank = $row_overall_rank['rank'];
        }
    }

    // Display the Grand Total and Overall Rank
    echo "<div class='bulletin-result tot-gen'>
            <h4>Grand Total</h4>";
    if ($all_trimesters_not_classified) {
        echo "<p>Total: Not classified</p>";
    } else {
        echo "<p>Total: $grand_total</p>";
        echo "<p>Overall Rank: " . ($overall_rank > 0 ? $overall_rank : 'Not classified') . "</p>";
    }
    echo "</div>";
    ?>
</div>


    

        <div class="admitted">
            <p>Admitted</p>
            <i class="fa-regular fa-circle-check"></i>
        </div>

        <div class="principal-signature">
            <p><img src="../../../images/signature.png" alt="signature"></p>
            <h3>Armel MBIATAT DANY</h3>
        </div>

        <div class="print">
            <a  class="printButton" href="javascript:void(0);" id="printPage">Print</a>
        </div>
        <?php
    }
} else {
    echo "<p style='color:red; text-align:center;font-size:1.5rem'>0 results : to display bulletins there should be modules added in the class !!</p>";
}

$conn->close();
?>

</section>

</body>
</html>