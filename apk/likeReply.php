<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function likeReply() {
    global $pdo;
    if (!isset($_SESSION['userID'])) {
        echo json_encode(['error' => 'ログインしてください。']);
        exit;
    }

    $userID = $_SESSION['userID'];
    $repID = $_POST['repID'];

    if (!isset($repID) || !is_numeric($repID)) {
        echo json_encode(['error' => '無効なrepIDです。']);
        return;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO `reply_likes` (`repID`, `userID`) VALUES (:repID, :userID)");
        if (!$stmt) {
            throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
        }

        $stmt->bindParam(':repID', $repID, PDO::PARAM_INT);
        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);

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

if (isset($_POST['repID'])) {
    likeReply();
} else {
    echo json_encode(['error' => 'POSTデータがありません。']);
}
?>
