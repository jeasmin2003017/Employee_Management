<?php

include('dbconnect.php');


$username = $password = "";
$username_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } else {
        $username = trim($_POST["username"]);
    }

    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }

    
    if (empty($username_err) && empty($password_err)) {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $query = "INSERT INTO AdminUsers (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($query);

        
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashed_password);

        
        if ($stmt->execute()) {
            echo "Admin user added successfully!";
        } else {
            echo "Error creating admin user.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Admin</h2>
        <?php if (isset($message)) echo "<div class='alert alert-info'>$message</div>"; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" placeholder="Enter username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-success">Add Admin</button>
        </form>
    </div>
</body>
</html>