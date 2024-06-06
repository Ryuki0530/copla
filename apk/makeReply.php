<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

session_regenerate_id(true);

function makeReply() {
    global $pdo;
    if (isset($_SESSION["userID"])) {
        $userID = $_SESSION['userID'];
    }else{
        $userID = "00RD000";
    }
    $postID = $_POST['postID'];
    $replyBody = trim($_POST['replyBody']);
    
    if (empty($replyBody)) {
        echo '<script>alert("返信内容を入力してください。")</script>';
    } else {
        $replyBody = htmlspecialchars($replyBody, ENT_QUOTES, 'UTF-8');
        $replyDate = date("Y-m-d H:i:s");
        try {
            $stmt = $pdo->prepare("INSERT INTO `replies` (`postID`, `userID`, `body`, `datetime`) VALUES (:postID, :userID, :replyBody, :replyDate)");
            if (!$stmt) {
                throw new Exception("Prepare failed: " . implode(" ", $pdo->errorInfo()));
            }

            
            $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->bindParam(':replyBody', $replyBody, PDO::PARAM_STR);
            $stmt->bindParam(':replyDate', $replyDate, PDO::PARAM_STR);

            $stmt->execute();

            echo $replyBody;

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if (isset($_SESSION["userID"])) {
    makeReply();
} else {
    makeReply();
    //echo '<script>alert("返信するためにはログインしてください。")</script>';
}
?>
