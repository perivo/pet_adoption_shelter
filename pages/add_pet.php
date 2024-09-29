<?php
session_start();
include '../includes/dbconnect.php';

// Check if user is logged in as admin
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['role'] !== 'admin') {
    header("Location: admin.php"); // Redirect to admin login if not logged in as admin
    exit();
}

// Handle the pet addition
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $breed = $_POST['breed'];
    $age = $_POST['age'];
    $health_status = $_POST['health_status'];
    $description = $_POST['description'];
    $image = $_POST['image']; // Handle image upload accordingly

    $stmt = $conn->prepare("INSERT INTO pets (name, breed, age, health_status, description, image) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $name, $breed, $age, $health_status, $description, $image);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Pet added successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Pet - Pet Adoption Shelter</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Pet for Adoption</h1>
        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Pet Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" name="breed" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" name="age" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="health_status" class="form-label">Health Status</label>
                <input type="text" name="health_status" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image URL</label>
                <input type="text" name="image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Pet</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
    </div>
    
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>
