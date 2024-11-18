<?php
include 'db.php';

// Fetch all classes
$query = "SELECT * FROM classes ORDER BY created_at DESC";
$result = $conn->query($query);

// Add new class
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_class'])) {
    $class_name = $_POST['class_name'];

    if (!empty($class_name)) {
        $stmt = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
        $stmt->bind_param("s", $class_name);
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
    <title>Manage Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Include the Navbar -->
    <?php include('navbar.php'); ?>
    <div class="container my-5">
        <center>
            <h1>Manage Classes</h1>
        </center>

        <!-- Form to Add New Class -->
        <div>
            <form method="POST">
                <label class="form-label">New Class Name</label>
                <input class="form-control" type="text" name="class_name" required />
                <div class="text-end">
                    <button class="btn btn-success mt-1" type="submit" name="add_class">Add Class</button>
                </div>
            </form>
        </div>

        <div class="my-4">
            <h2>All Classes</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $row['class_id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= date('l, F j, Y g:i A', strtotime($row['created_at'])) ?></td>
                            <td>
                                <a class="btn btn-primary" href="edit_class.php?class_id=<?= $row['class_id'] ?>">Edit</a>
                                <!-- <form method="POST" style="display:inline;">
                                    <input type="hidden" name="class_id" value="<?= $row['class_id'] ?>">
                                    <button class="btn btn-danger" type="submit" name="delete_class" onclick="return confirm('Are you sure?')">Delete</button>
                                </form> -->
                                <a class="btn btn-danger" href="delete_class.php?class_id=<?= $row['class_id'] ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <a href="index.php" class="btn btn-info">Back to Home</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>