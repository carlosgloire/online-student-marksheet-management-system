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
require_once('../../../models/table_queries.php');

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

                if (mysqli_num_rows($result_marks) > 0) {
                    {
                    // If marks are found, display them
                    $row_marks = $result_marks->fetch_assoc();
                    $av=($row_marks["SQ"] + $row_marks["comp"] )/2;
                    $tot=$av * $coefficient;

                    // Store total marks for the current trimester in the array
                    if (!isset($total_trimester_marks[$trimester])) {
                        $total_trimester_marks[$trimester] = 0;
                    }
                    $total_trimester_marks[$trimester] += $tot;
                    ?> <?= !empty($row_marks["SQ"]) ? "<td>{$row_marks['SQ']}</td>" : "<td>0</td>"; ?>
                    <?= !empty($row_marks["comp"]) ? "<td>{$row_marks['comp']}</td>" : "<td>0</td>"; ?>
                    <?= !empty($av) ? "<td>{$av}</td>" : "<td></td>"; ?>
                    <?= !empty($coefficient) ? "<td>{$coefficient}</td>" : "<td>0</td>"; ?>
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

                 
                    <?php
                }
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
                $sql_total_marks = "SELECT  SUM(ms.total) as total_marks, SUM(cr.coefficient) AS coefficients
                                    FROM marksheets ms
                                    JOIN trimeters t ON ms.trim_id = t.trim_id
                                    JOIN courses cr ON ms.course_id = cr.course_id
                                    WHERE t.trimester_name = '$trimester' AND ms.student_id = $student_id";
                $result_total_marks = $conn->query($sql_total_marks);
                $total_marks = 0;
                if ($result_total_marks->num_rows > 0) {
                    $row_total_marks = $result_total_marks->fetch_assoc();
                    $coeff = $row_total_marks['coefficients'];
                
                    // Check if coefficient is not zero to avoid division by zero error
                    if ($coeff != 0) {
                        $total_marks = $row_total_marks['total_marks'] / $coeff;
                    } else {
                        // Handle the case where coefficient is zero, maybe set total_marks to 0 or handle it differently
                        $total_marks = 0;
                    }
                }
                
                // If there are no courses with marks in this trimester, student is "Not classified"
                if (! $course_count == 0) {
                    echo "<div class='bulletin-result $trimester'>
                    <h4>$trimester</h4>";
                    ?>
                           <p>Average: <?= number_format($total_marks,1)?></p>
                           <p>Grade:
                                <span>
                                <?= empty($total_marks) ? "" :
                                    ($total_marks < 10 ? "F" :
                                        ($total_marks >= 10 && $total_marks < 12 ? "E" :
                                            ($total_marks >= 12 && $total_marks < 13 ? "D" :
                                                ($total_marks >= 13 && $total_marks < 15 ? "C" :
                                                    ($total_marks >= 15 && $total_marks < 17 ? "B" :
                                                        ($total_marks >= 17 && $total_marks <= 20 ? "A" : "")
                                                    )
                                                )
                                            )
                                        )
                                ); ?>
                                </span>
                            </p>
                    <?php
                    echo" </div>";


                } else {
                    echo "<div class='bulletin-result $trimester'>
                    <h4>$trimester</h4>";
                    echo "<p>Average: <span>$total_marks</span></p>";
                    echo "<p>Grade: Not classified</p>
                        </div>";
        
                     
                $trimester_totals[$trimester] = $total_marks;

                }
                $grand_total += $total_marks/3;
                // Add the total marks for this trimester to the Grand Total
            }
            if($grand_total !=0){
                ?>
                    <div class='bulletin-result tot-gen'>
                    <h4>Grand Total</h4>
                    <p>Average: <?= number_format($grand_total,1) ?></p>
                    <p>Grade:
                         <span>
                         <?= empty($grand_total) ? "" :
                             ($grand_total < 10 ? "F" :
                                 ($grand_total >= 10 && $grand_total < 12 ? "E" :
                                     ($grand_total>= 12 && $grand_total < 13 ? "D" :
                                         ($grand_total >= 13 && $grand_total < 15 ? "C" :
                                             ($grand_total >= 15 && $grand_total < 17 ? "B" :
                                                 ($grand_total >= 17 && $grand_total <= 20 ? "A" : "")
                                             )
                                         )
                                     )
                                 )
                         ); ?>
                         </span>
                     </p>
                     </div>
             <?php
                  
            
            }
            else{
                ?>
                    <div class='bulletin-result tot-gen'>
                    <h4>Grand Total</h4>
                    <p>Average: <?= $grand_total?></p>
                    <p>Grade:Not classified</p>
                     </div>
             <?php
            }
            ?>
        </div>
        <?= ($grand_total > 10) ? "<div class='admitted'><p>Admitted: </p><i class='fa-regular fa-circle-check'></i></div> ": "<div class='admitted'><p>Admitted: </p><i style='color:red' class='<i fa-regular fa-circle-xmark'></i></div> " ?>

        <div class="principal-signature">
            <p><img src="../../../images/signature.png" alt="signature"></p>
            <h3>Armel MBIATAT DANY</h3>
        </div>

        <div class="print">
            <button class="printButton" onclick="printBulletin()">Print</button>
        </div>
        <?php
    
}  else {
    
    echo '<script>alert("student not found");</script>';
    echo '<script>window.location.href="bulletin.php";</script>';
    exit;

}

$conn->close(); // Close connection
}
?>

</section>
<script>
  // JavaScript function to print the bulletin
function printBulletin() {
    // Get the first name and last name of the student from PHP
    var firstName = "<?php echo $student_name; ?>";
    var lastName = "<?php echo $student_lname; ?>";
    
    // Combine the first name and last name
    var studentName = firstName + " " + lastName;
    
    // Set the title of the document to include the student name
    document.title = "Bulletin - " + studentName;

    // Hide specific elements before printing
    var elementsToHide = document.querySelectorAll('.date-time, .page-url');
    elementsToHide.forEach(function(element) {
        element.style.display = 'none';
    });

    // Trigger the browser's print dialog
    window.print();

    // Restore the visibility of hidden elements after printing
    elementsToHide.forEach(function(element) {
        element.style.display = '';
    });

    // Restore the original title
    document.title = "Bulletin";
}

</script>
</body>
</html>