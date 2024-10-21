<?php
include('config.php');

// Get the database instance
$db = Database::getInstance();
$conn = $db->getConnection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Fetch the existing record
        $sql = "SELECT * FROM myguests WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $guest = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($guest) {
            // Update the record
            if (isset($_POST['update'])) {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $password = $_POST['password']; // Consider hashing the password before storing

                $sql = "UPDATE myguests SET firstname = :firstname, lastname = :lastname, email = :email, `password` = :password WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':firstname', $firstname);
                $stmt->bindParam(':lastname', $lastname);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);

                if ($stmt->execute()) {
                    // Redirect to index.php after successful update
                    header("Location: index.php");
                    exit(); // Make sure to exit after using header to stop further execution
                } else {
                    echo "Error updating record";
                }
            }
        } else {
            echo "Guest not found!";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Guest</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Edit Guest</h2>
        <?php if (isset($guest)): ?>
            <form method="POST">
                <div class="form-group">
                    <label>First Name:</label>
                    <input type="text" name="firstname" value="<?php echo htmlspecialchars($guest['firstname']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Last Name:</label>
                    <input type="text" name="lastname" value="<?php echo htmlspecialchars($guest['lastname']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Email:</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($guest['email']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Password:</label>
                    <input type="text" name="password" value="<?php echo htmlspecialchars($guest['password']); ?>" required>
                </div>
                
                <input type="submit" name="update" value="Update">
            </form>
        <?php endif; ?>
    </div>
</body>
</html>

