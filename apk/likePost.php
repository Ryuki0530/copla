<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function likePost() {
    global $pdo;

    if (!isset($_SESSION['userID'])) {
        echo json_encode(['error' => 'ログインしてください。']);
        exit;
    }

    $userID = $_SESSION['userID'];
    $postID = $_POST['postID'];

    if (!isset($postID) || !is_numeric($postID)) {
        echo json_encode(['error' => '無効なpostIDです。']);
        return;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO `post_likes` (`postID`, `userID`) VALUES (:postID, :userID)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
        }

        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
        $stmt->execute();

        $stmt = $pdo->prepare("UPDATE posts SET fav = fav + 1 WHERE postID = :postID;");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
        }
        $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['success' => true]);

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(['error' => '既にいいねをしています。']);
        } else {
            echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
        }
    } catch (Exception $e) {
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
}

if (isset($_POST['postID'])) {
    likePost();
} else {
    echo json_encode(['error' => 'POSTデータがありません。']);
}
?>
