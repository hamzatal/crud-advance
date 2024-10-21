<?php
include('config.php');

// Get the database instance
$db = Database::getInstance();
$conn = $db->getConnection();

if(isset($_GET['id'])){
    $id = $_GET['id'];

    try{
        $sql = "DELETE FROM myguests WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if($stmt->execute()){
            echo "<br>Record deleted successfully";
        } else {
            echo "<br>Error deleting record";
        }
    }catch(PDOException $e){
        echo "Error: " . $e->getMessage();
    }
    header("Location: index.php");
    exit;
} else {
    echo "Invalid request!";
}
?>
