<?php
include 'db.php';

// Fetch student details
$id = $_GET['id'];
$query = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

// Fetch classes for dropdown
$classes = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    // Handle Image Upload
    $image_name = $student['image'];
    if (!empty($_FILES['image']['name'])) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        $allowed = ['jpg', 'png'];
        if (in_array($image_ext, $allowed)) {
            $new_image_name = uniqid() . '.' . $image_ext;
            move_uploaded_file($image_tmp, "uploads/$new_image_name");
            $image_name = $new_image_name;

            // Delete old image
            if (file_exists("uploads/" . $student['image'])) {
                unlink("uploads/" . $student['image']);
            }
        } else {
            echo "Invalid image format.";
            exit;
        }
    }

    // Update student in database
    $update_query = "UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssisi", $name, $email, $address, $class_id, $image_name, $id);
    $stmt->execute();

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container my-5">
        <center><h1>Edit Student</h1></center>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input class="form-control" type="text" name="name" value="<?= $student['name'] ?>" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input class="form-control" type="email" name="email" value="<?= $student['email'] ?>" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Address:</label>
                <textarea class="form-control" name="address"><?= $student['address'] ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Class:</label>
                <select name="class_id" class="form-control">
                    <option value="">Unassigned</option>
                    <?php while ($class = $classes->fetch_assoc()) { ?>
                        <option value="<?= $class['class_id'] ?>"
                            <?= $class['class_id'] == $student['class_id'] ? 'selected' : '' ?>>
                            <?= $class['name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Image:</label>
                <input class="form-control" type="file" name="image" />
            </div>
            <div class="mb-3">
                <img src="uploads/<?= $student['image'] ?>" width="50" height="50" /><br>
            </div>
            <div class="text-end">
                <button type="submit" class="btn btn-success">Update Student</button>
            </div>
        </form>
        <a href="index.php" class="btn btn-info">Back to Home</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>