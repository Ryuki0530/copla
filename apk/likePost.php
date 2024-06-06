<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function likePost() {
    global $pdo;
    $userID = $_SESSION['userID'];
    $postID = $_POST['postID'];

    try {
        $stmt = $pdo->prepare("INSERT INTO `post_likes` (`postID`, `userID`) VALUES (:postID, :userID)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
        }

        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

        $stmt->execute();

        echo "Success";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "You have already liked this post.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_SESSION["userID"])) {
    likePost();
} else {
    echo "You must be logged in to like a post.";
}
?>
