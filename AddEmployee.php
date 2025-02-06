<?php
include 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];

    try {
        $sql = "INSERT INTO employees (name, position, salary, status) VALUES (:name, :position, :salary, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([ ':name' => $name,':position' => $position,':salary' => $salary,':status' => $status]);
        $message = "Employee added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="Dashboard.php">Employee Admin Panel</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Add Employee</h2>
        <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="employeeName" class="form-label">Employee Name</label>
                <input type="text" class="form-control" name="name" placeholder="Enter employee name" required>
            </div>
            <div class="mb-3">
                <label for="employeePosition" class="form-label">Position</label>
                <input type="text" class="form-control" name="position" placeholder="Enter position" required>
            </div>
            <div class="mb-3">
                <label for="employeeSalary" class="form-label">Salary</label>
                <input type="number" class="form-control" name="salary" placeholder="Enter salary" required>
            </div>
            <div class="mb-3">
                <label for="employeeStatus" class="form-label">Status</label>
                <select class="form-select" name="status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Add Employee</button>
        </form>
    </div>
</body>
</html>
