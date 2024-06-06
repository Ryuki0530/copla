<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

session_regenerate_id(true);

function makeFav() {
    global $pdo;
    $userID = $_SESSION['userID'];
    $postID = $_POST['postID'];
    $postID = $_POST['repID'];
    $which = false;
    if(isset($postID)){
        $which = true;
    }
    
    
    if (empty($replyBody)) {
        echo '<script>alert("返信内容を入力してください。")</script>';
    } else {
        $replyDate = date("Y-m-d H:i:s");
        try {
            $stmt = $pdo->prepare("INSERT INTO `replies` (`postID`, `userID`, `datetime`) VALUES (:postID, :userID, :replyBody, :replyDate)");
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
    makeFav();
} else {
    echo '<script>alert("返信するためにはログインしてください。")</script>';
}
?>
