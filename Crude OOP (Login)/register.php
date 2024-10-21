<?php
include('config.php');

// Get the database instance
$db = Database::getInstance();
$conn = $db->getConnection();

if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password for security

    try {
        $sql = "INSERT INTO myguests (firstname, lastname, email, password) VALUES (:firstname, :lastname, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: login.php"); // Redirect to login page
            exit();
        } else {
            echo "Error: Registration failed!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <form method="POST">
            <label>First Name:</label>
            <input type="text" name="firstname" required>
            <label>Last Name:</label>
            <input type="text" name="lastname" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <input type="submit" name="register" value="Register">
        </form>
    </div>
</body>
</html>
