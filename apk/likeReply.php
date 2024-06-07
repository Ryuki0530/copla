<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

function likeReply() {
    echo "いいね受け取った";
    global $pdo;
    if (!isset($_SESSION['userID'])) {
        echo "ログインしてください。";
        
        exit;
    }

    $userID = $_SESSION['userID'];
    //echo $userID;
    $repID = $_POST['repID'];
    //echo $repID;
    // デバッグ出力
    //error_log("Received repID: " . $repID);

    if (!isset($repID) || !is_numeric($repID)) {
        echo "無効なrepIDです。";
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

        echo "Success";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "もういいねしています.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['repID'])) {
    likeReply();
} else {
    echo "POSTデータがありません。";
}
?>
