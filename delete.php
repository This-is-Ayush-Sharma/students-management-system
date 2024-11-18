<?php
include 'db.php';

$id = $_GET['id'];

// Fetch student to get the image path
$query = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete image from server
    if (file_exists("uploads/" . $student['image'])) {
        unlink("uploads/" . $student['image']);
    }

    // Delete student from database
    $delete_query = "DELETE FROM student WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header('Location: index.php');
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
        <h1>Delete Student</h1>
        <p>Are you sure you want to delete <strong><?= $student['name'] ?></strong>?</p>
        <form method="POST">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="index.php" class="m-3">No, Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>