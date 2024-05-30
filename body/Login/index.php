<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../../apk/Login.php';

if (isset($_SESSION['userID'])) {
    header("Location: ../Home");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/stylesheet.css">
    <meta charset="utf-8">
    <title>Copla ログイン</title>
</head>
<body>
    <div class="container">
        <form action="" method="POST">
            <p class="fsize">ログイン</p>
            <input type="text" name="userID" placeholder="学籍番号" />
            <input type="password" name="userPassword" placeholder="パスワード" />
            <button type="submit" name="submit">ログイン</button>
            <a href="../registration/index.php" class="regist">利用登録</a><br>
            <a href="../Home/leftCtrl.php" class="regist">ログインなしで続ける</a>  
        </form>
    </div>
</body>
</html>
