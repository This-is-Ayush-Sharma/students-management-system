<?php
include 'db.php';

$query = "SELECT student.*, classes.name AS class_name 
          FROM student 
          LEFT JOIN classes ON student.class_id = classes.class_id";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Home - Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Include the Navbar -->
    <?php include('navbar.php'); ?>
    
    <div class="container my-5">
        <center><h1>All Students</h1></center>
        <a href="create.php" class="btn btn-info">Add New Student</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Class</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= $row['name'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['class_name'] ?: 'Unassigned' ?></td>
                        <td><img src="uploads/<?= $row['image'] ?>" width="50" height="50" /></td>
                        <td>
                            <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-success">View</a>
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary">Edit</a>
                            <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>