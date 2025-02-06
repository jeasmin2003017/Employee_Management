<?php
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    try {
        // Delete the employee from the database
        $sql = "DELETE FROM Employees WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        $message = "Employee deleted successfully!";
    } catch (PDOException $e) {
        $message = "Error deleting employee: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="Dashboard.php">Employee Admin Panel</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Delete Employee</h2>
        <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="employeeId" class="form-label">Employee ID</label>
                <input type="number" class="form-control" id="employeeId" name="id" placeholder="Enter employee ID to delete" required>
            </div>
            <button type="submit" class="btn btn-danger">Delete Employee</button>
        </form>
    </div>
</body>
</html>
