<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../../apk/settingProcess.php';

if (!isset($_SESSION['userID'])) {
    header("Location: center.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="./css/stylesheet2.css">
    <meta charset="utf-8">
    <title>Copla ログイン</title>
</head>
<br><br>
<body bgcolor="white">

    <div class="wrapper">
    <h1>設定<h1>
    </div>
    <br>
    <div class="wrapper">
    <h2>ユーザー情報</h2>
        <hr>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h3>ニックネーム(表示名)変更</h3>
            新しいニックネーム&emsp;&emsp;&emsp;&emsp;<input type="text" name="newUserName" value="" maxlength="30" required><br>
            <input type="submit" name="nameButton" value="変更">
        </form>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <h3>パスワード変更&emsp;&emsp;</h3>
            現在のパスワード&emsp;&emsp;&emsp;&emsp;&emsp;<input type="password" name="oldUserPassword" value=""><br><br>
            新しいパスワード&emsp;&emsp;&emsp;&emsp;&emsp;<input type = "password" name="userPassword"  value = "" maxlength="50" required><br>
            新しいパスワード (再入力)&emsp;<input type = "password" name="userPassword2"  value = "" maxlength="50" required><br><br>
            <input type="submit" name="passButton" value="変更">
        </form>
    </div>
</body>
</html>
