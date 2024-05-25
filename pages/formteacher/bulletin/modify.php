<?php
$error=null;
session_start();
require_once('../../../database/DBConnection.php');
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students_marksheet_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);


if (isset($_GET['student_id'], $_GET['trimester_id'], $_GET['course_id'])) {
    $student_id = $_GET['student_id'];
    $trimester_id = $_GET['trimester_id'];
    $course_id = $_GET['course_id'];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve the updated marks values
        $sq = htmlspecialchars($_POST['sq']) ;
        $comp = htmlspecialchars($_POST['comp']) ;

        // Fetch the coefficient of the course
        $fetch_coeff_query = "SELECT coefficient FROM courses WHERE course_id = ?";
        $stmt_coeff = $conn->prepare($fetch_coeff_query);
        $stmt_coeff->bind_param("i", $course_id);
        $stmt_coeff->execute();
        $result_coeff = $stmt_coeff->get_result();
        $row_coeff = $result_coeff->fetch_assoc();

        if ($row_coeff) {
            $coefficient = $row_coeff['coefficient'];

            // Calculate total marks
            $total = (($sq + $comp) / 2) * $coefficient;

            // Update marks in the database
            $update_query = "UPDATE marksheets SET SQ = ?, comp = ?, total = ? WHERE student_id = ? AND trim_id = ? AND course_id = ?";
            $stmt_update = $conn->prepare($update_query);
            $stmt_update->bind_param("dddiid", $sq, $comp, $total, $student_id, $trimester_id, $course_id);
            if(($sq <0 || $sq>20) || ($comp<0 || $comp >20)  ){
                $error = "The marks should be less than 0 and above 20";
            }else{
                if ($stmt_update->execute()) {
                    // Marks updated successfully
                    echo '<script>alert("Marks updated successfully.");</script>';
                    echo "<script>window.location.href='modify_marks.php?student_id=$student_id';</script>";
    
                } else {
                    // Error updating marks
                    echo '<script>alert("Error updating marks. Please try again.");</script>';
                }
            }

        } else {
            // Coefficient not found
            echo '<script>alert("Coefficient not found for the course.");</script>';
        }
    }

    // Fetch existing marks data
    $fetch_query = "SELECT SQ, comp FROM marksheets WHERE student_id = ? AND trim_id = ? AND course_id = ?";
    $stmt_fetch = $conn->prepare($fetch_query);
    $stmt_fetch->bind_param("iii", $student_id, $trimester_id, $course_id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $row_fetch = $result_fetch->fetch_assoc();

    if ($row_fetch) {
        $sq = $row_fetch['SQ'];
        $comp = $row_fetch['comp'];
    } else {
        // Marks data not found
        echo '<script>alert("Marks data not found.");</script>';
        exit;
    }
} else {
    // Invalid parameters
    echo '<script>alert("Invalid parameters.");</script>';
    exit;
}
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
    <title>Update Marks</title>
</head>
<body >
<section class="connect-section" >
        <div class="connect">
            <h3>Update Marks</h3>
            <form action="" method="post" >
                <div class="input-content">
                <div class="all-inputs">
                    <label for="name">Sequence:</label>
                    <input type="number" step="0.1" id="sq" name="sq" value="<?= $sq ?>" >
                </div>
                </div>
                <div class="input-content">
                    <div class="all-inputs">
                        <label for="name">Composition:</label>
                        <input type="number" step="0.1" id="comp" name="comp" value="<?= $comp ?>" >
                    </div>
                </div>
                <div class="btn">
                    <button type="submit" name="modify">Save changes</button>
                </div>
            </form>
            <p class="error"><?= $error?></p>
            <a href="bulletin.php" style="color:#064469;font-size:1.3rem;"><i class="fa-regular fa-circle-left" title="Go to all bulletins"></i></a>

        </div>
    </section>
     
</body>
</html>
