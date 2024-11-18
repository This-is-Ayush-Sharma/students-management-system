<?php
include 'db.php';

$class_id = $_GET['class_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete only if there are no students assigned to the class
    $check_query = "SELECT COUNT(*) AS student_count FROM student WHERE class_id = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result['student_count'] == 0) {
        $delete_query = "DELETE FROM classes WHERE class_id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $class_id);
        $stmt->execute();

        header("Location: classes.php");
    } else {
        echo "Cannot delete class with assigned students!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Delete Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Include the Navbar -->
    <?php include('navbar.php'); ?>
    
    <div class="my-5 conatiner">
        <h1>Delete Class</h1>
        <p>Are you sure you want to delete <strong>Class: <?= $class_id ?></strong>?</p>
        <form method="POST">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="classes.php" class="m-3">No, Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>