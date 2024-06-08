<?php
// login/index.php の最初に追加
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  require_once __DIR__ . '/../../apk/registration.php';
  // セッション情報の確認とリダイレクト
  if(isset($_SESSION['userID'])){
    header("Location: ../Home/left.html");
    exit();
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="./css/stylesheet.css">
    <meta charset="utf-8">
    <title>Copla 利用登録</title>
    <!-- 下部のスクロールバーを消したい -->
  </head>
  <body>
    <div class="container">
      <form action="" method="POST">
        <p class="fsize">利用登録</p>
        <input type="text" name="userID" placeholder="学籍番号" />
        <input type="text" name="idName" placeholder="ニックネーム(表示名)" />
        <input type="password" name="userPassword" placeholder="パスワード" />
        <input type="password" name="userPassword2" placeholder="パスワード(再入力)" />
        <button type="submit" name="signin">登録</button>
      </form>
    </div>
    
  </body>
</html>
