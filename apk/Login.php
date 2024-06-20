<?php
    require_once __DIR__ . '/../apk/connectDB.php';
    require_once __DIR__ . '/../etc/Settings.php';    

    if(isset($_POST['submit'])){
        $userID = mb_strtolower(trim($_POST['userID']));
        $password = trim($_POST['userPassword']);

        try{
            $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `userID` = :userID");
            $stmt->bindParam(':userID', $userID, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if($user && password_verify($password, $user['password'])){
                $_SESSION['userID'] = $userID;
                $_SESSION['idName'] = $user['idName'];
                echo('<script>alert("ログイン");</script>');
                header("Location:../Home/left.html");
                exit();
            }else{
                echo('<script>alert("ユーザー名またはパスワードが一致しません。");</script>');
            }
            $stmt = null;
            $pdo = null;
        }catch(PDOException $e){
            //echo $e->getMessage();
        }
    }

?>
