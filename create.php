<?php
include 'db.php';

// Fetch classes for dropdown
$classes = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    // Handle Image Upload
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'png'];
    if (in_array($image_ext, $allowed)) {
        $new_image_name = uniqid() . '.' . $image_ext;
        move_uploaded_file($image_tmp, "uploads/$new_image_name");

        // Insert into Database
        $stmt = $conn->prepare("INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssds", $name, $email, $address, $class_id, $new_image_name);
        $stmt->execute();

        header('Location: index.php');
    } else {
        echo "Invalid image format.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <!-- Include the Navbar -->
    <?php include('navbar.php'); ?>
    
    <div class="container my-5">
        <center><h1>Add Student</h1></center>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Name:</label>
                <input class="form-control" type="text" name="name" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Email:</label>
                <input class="form-control" type="email" name="email" required />
            </div>
            <div class="mb-3">
                <label class="form-label">Address:</label>
                <textarea class="form-control" name="address"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Class:</label>
                <select name="class_id" class="form-control">
                    <?php while ($class = $classes->fetch_assoc()) { ?>
                        <option value="<?= $class['class_id'] ?>"><?= $class['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Image:</label>
                <input class="form-control" type="file" name="image" required />
            </div>
            <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>