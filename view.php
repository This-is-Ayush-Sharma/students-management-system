<?php
include 'db.php';

// Fetch student details using `id`
$id = $_GET['id'];
$query = "SELECT student.*, classes.name AS class_name 
          FROM student 
          LEFT JOIN classes ON student.class_id = classes.class_id
          WHERE student.id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Include the Navbar -->
    <?php include('navbar.php'); ?>
    
    <div class="container my-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Student Details</h3>
                <p><strong>Name:</strong> <?= htmlspecialchars($student['name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($student['address']) ?></p>
                <p><strong>Class:</strong> <?= htmlspecialchars($student['class_name'] ?: 'Unassigned') ?></p>
                <p><strong>Image:</strong><br>
                    <img src="uploads/<?= htmlspecialchars($student['image']) ?>" class="img-thumbnail mt-2" width="90" height="90" alt="Student Image">
                </p>
                <p><strong>Created At:</strong> <?= htmlspecialchars(date('l, F j, Y g:i A', strtotime($student['created_at'] ))) ?></p>
                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-primary">Back to Home</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>