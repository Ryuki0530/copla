<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();


if (!isset($_SESSION['userID'])) {

    
    header("Location: ../body/home.html");
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
    <h1>ユーザー登録&emsp;管理者用</h1>
        <hr>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        学籍番号<input Type = "text" name = "userID"><br>
        名前&emsp;&emsp;<input Type = "text" name = "userName"><br>
        <input type="submit" name="submit" value="登録">
        </form>
    </div>
</body>
</html>
