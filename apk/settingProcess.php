<?php
//session_start();
require_once __DIR__ . '/../apk/connectDB.php';
require_once __DIR__ . '/../etc/Settings.php';

session_regenerate_id(true);


if(isset($_POST['nameButton'])){

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $newIdName = trim($_POST['newUserName']);
    $checkCount = 0;
    if ($newIdName == $_SESSION['idName']){
        echo('<script>alert("現在使用中のユーザー名です。");</script>');
        $checkCount++;
    } 
    if (empty($newIdName)) {
        echo('<script>alert("新しいユーザー名を入力してください。");</script>');
        $checkCount++;
    }

    if($checkCount==0){
        try{
            
            //変更処理
            $stmt = $pdo->prepare("UPDATE `users` SET `idName`= :newIdName  WHERE `idName` = :oldName");
            $stmt->bindParam(':newIdName',$newIdName,PDO::PARAM_STR);
            $stmt->bindParam(':oldName',$_SESSION['idName'],PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['idName'] = $newIdName;
            echo('<script>alert("ユーザー名を'.$newIdName.'に変更しました。");</script>');
            
        }catch(PDOException $e){
            echo $e->getMessage();
            
        }
    }
}


//パスワードの変更
if(isset($_POST['passButton'])){
    $oldUserPassword = ($_POST['oldUserPassword']);
    $newUserPassword = ($_POST['userPassword']);
    $passwordCheck = ($_POST['userPassword2']);
    $checkCount3 = 0;
    if (empty($oldUserPassword)) {
        $checkCount3++;
    }
    if (empty($newUserPassword)) {
        $checkCount3++;
    }
    if (empty($passwordCheck)) {
        $checkCount3++;
    }
    if($checkCount3==0){
        //現在のパスワードでの認証
        $pdo = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_pass);
        $stmt = $pdo->prepare("SELECT * FROM `users` WHERE `userName` = :userName");
        $stmt->bindParam(':userName', $_SESSION['userName'], PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if($user && password_verify($oldUserPassword, $user['password'])){
            
            //変更パスワードの確認
            if($newUserPassword == $passwordCheck){
                $newUserPassword = password_hash(trim($_POST['userPassword']), PASSWORD_DEFAULT);
                try{
                    $stmt = $pdo->prepare("UPDATE `users` SET `password`= :newUserPassword  WHERE `id` = :userID");
                    $stmt->bindParam(':newUserPassword',$newUserPassword,PDO::PARAM_STR);
                    $stmt->bindParam(':userID',$_SESSION['userID'],PDO::PARAM_STR);
                    $stmt->execute();
                    echo('<script>alert("パスワードを変更しました。");</script>');
                }catch(PDOException $e){
                    //echo $e->getMessage();
                }
            }else{echo('<script>alert("再入力されたパスワードが一致しません。");</script>');}
        }else{echo('<script>alert("現在のパスワードが一致しません。");</script>');}
    }
}


//DB接続終了
$pdo = null;

?>