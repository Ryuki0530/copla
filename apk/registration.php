<?php
session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';    




if(isset($_POST['signin'])){
    $userID = trim($_POST['userID']);
    $idName = trim($_POST['idName']);
    $userPassword = $_POST['userPassword'];
    $userPassword2 = $_POST['userPassword2'];
    
    if (!empty($userID) && !empty($idName) && !empty($userPassword) && !empty($userPassword2)) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM `users` WHERE `userID` = :userID");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count == 1) {
                $stmt = $pdo->prepare("SELECT `ini` FROM `users` WHERE `userID` = :userID");
                $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
                $stmt->execute();
                $ini = $stmt->fetchColumn();

                if ($ini == 0) {
                    if ($userPassword === $userPassword2) {
                        $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);
                        $stmt = $pdo->prepare("UPDATE `users` SET `idName` = :idName, `password` = :password, `ini` = 1 WHERE `userID` = :userID");
                        $stmt->bindParam(':idName', $idName, PDO::PARAM_STR);
                        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
                        $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
                        $stmt->execute();
                        header("Location:../Login");
                    } else {
                        echo('<script>alert("再入力のパスワードが一致しません。");</script>');
                    }
                } else {
                    echo('<script>alert("この学生は登録済みです。");</script>');
                }
            } else {
                echo('<script>alert("有効な学籍番号を入力してください。");</script>');
            }
        } catch (PDOException $e) {
            echo('<script>alert("データベースエラーが発生しました。");</script>');
        }
    } else {
        echo('<script>alert("すべてのフィールドを入力してください。");</script>');
    }
}
?>
