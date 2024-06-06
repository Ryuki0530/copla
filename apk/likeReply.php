<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function likeReply() {
    global $pdo;
    $userID = $_SESSION['userID'];
    $repID = $_POST['repID'];

    try {
        $stmt = $pdo->prepare("INSERT INTO `reply_likes` (`repID`, `userID`) VALUES (:repID, :userID)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
        }

        $stmt->bindParam(':repID', $repID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        $stmt->execute();

        echo "Success";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "You have already liked this reply.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_SESSION["userID"])) {
    likeReply();
} else {
    echo "You must be logged in to like a reply.";
}
?>
