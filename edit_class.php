<?php
include 'db.php';

$class_id = $_GET['class_id'];

// Fetch current class details
$query = "SELECT * FROM classes WHERE class_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $class_name = $_POST['class_name'];

    if (!empty($class_name)) {
        // Update class
        $update_query = "UPDATE classes SET name = ? WHERE class_id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("si", $class_name, $class_id);
        $stmt->execute();

        header("Location: classes.php");
    } else {
        echo "Class name cannot be empty!";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Include the Navbar -->
    <?php include('navbar.php'); ?>
    <div class="container my-5">
        <center>
            <h1>Edit Class</h1>
        </center>
        <form method="POST">
            <label class="form-label">Class Name:</label>
            <input class="form-control" type="text" name="class_name" value="<?= $class['name'] ?>" required />
            <div class="text-end mt-1">
                <button class="btn btn-primary" type="submit">Update Class</button>
            </div>
        </form>
        <a class="btn btn-info" href="classes.php">Back to Classes</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>