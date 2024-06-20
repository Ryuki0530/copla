<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function likePost() {
    echo"いいね受け取った";
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

        //echo "Success";

        $stmt = $pdo->prepare("UPDATE posts SET fav = fav + 1 WHERE postID = :postID;");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
        }
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo '<script>alert("既にいいねしています。")</script>';
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
    echo "ログインしてください。";
}
?>
