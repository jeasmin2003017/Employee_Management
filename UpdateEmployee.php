<?php
include 'dbconnect.php'; // Ensure this file works correctly

$message = "";
$employee = null;

// Fetch employee data if `id` is passed via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        $sql = "SELECT * FROM employees WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$employee) {
            $message = "Employee not found.";
        }
    } catch (PDOException $e) {
        $message = "Error fetching employee: " . $e->getMessage();
    }
}

// Update employee data if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];
    $status = $_POST['status'];

    try {
        $sql = "UPDATE employees SET name = :name, position = :position, salary = :salary, status = :status WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([ ':name' => $name,':position' => $position,':salary' => $salary,':status' => $status,':id' => $id,]);

        $message = "Employee updated successfully!";
        header("Location: Dashboard.php"); // Redirect after update
        exit;
    } catch (PDOException $e) {
        $message = "Error updating employee: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="Dashboard.php">Employee Admin Panel</a>
        </div>
    </nav>
    <div class="container mt-5">
        <h2>Update Employee</h2>
        <?php if ($message) echo "<div class='alert alert-info'>$message</div>"; ?>
        <form method="POST" action="">
            <input type="hidden" name="id" value="<?php echo isset($employee['id']) ? $employee['id'] : ''; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($employee['name']) ? htmlspecialchars($employee['name']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="position" class="form-label">Position:</label>
                <input type="text" class="form-control" id="position" name="position" value="<?php echo isset($employee['position']) ? htmlspecialchars($employee['position']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Salary:</label>
                <input type="number" step="0.01" class="form-control" id="salary" name="salary" value="<?php echo isset($employee['salary']) ? htmlspecialchars($employee['salary']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Active" <?php echo (isset($employee['status']) && $employee['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo (isset($employee['status']) && $employee['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Employee</button>
        </form>
    </div>
</body>
</html>
