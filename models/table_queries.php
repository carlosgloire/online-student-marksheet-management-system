<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "students_marksheet_management_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assign $class_id from session variable
$class_id = $_SESSION['class_id'];

// Fetch distinct courses with their coefficients for the given class ID
$sql_courses = "SELECT DISTINCT c.course_name, c.coefficient
                FROM courses c
                JOIN courses cc ON c.course_id = cc.course_id
                WHERE cc.class_id = $class_id";
$result_courses = $conn->query($sql_courses);
$courses = [];
if ($result_courses->num_rows > 0) {
    while($row_course = $result_courses->fetch_assoc()) {
        $courses[] = [
            'course_name' => $row_course["course_name"],
            'coefficient' => $row_course["coefficient"]
        ];
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

$stmt=$db->prepare("SELECT COUNT(DISTINCT spc.student_id)  as studentID, c.* FROM students_per_class spc LEFT JOIN classes c ON spc.class_id=c.class_id WHERE c.class_id ={$_SESSION['class_id']}");
$stmt->execute();
$countstudent=$stmt->fetchAll(PDO::FETCH_OBJ);
?>
