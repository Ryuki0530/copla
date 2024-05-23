<?php
  require_once "../../apk/connectDB.php";
  require_once "../../apk/makePost.php";
  require_once "../../apk/postGetCtrl.php";
  
  // 投稿の取得
  try {
      getPosts();
  } catch (Exception $e) {
      echo "Error: " . $e->getMessage();
  }

  if (!empty($_POST["submitButton"])) {
    makeTubuyaki();
  }
?>



<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="./css/stylesheet2.css">
    <meta charset="utf-8">
    <title></title>
  </head>
  <body bgcolor="white">
    <div class="top">
      <div class="search">
        <input type="search" id="site-search" name="q" />
        <button type="submit" class="bt-sch"><img src=".././resource/検索.png" width="15"></button>
      </div>
    </div>
    <?php

      viewPosts();
    ?>
    <div id="popupForm" class="popup-form">
      <div class="popup-form-content">
        <span id="closeFormButton" class="close">&times;</span>
        <form method="post" action="center.php"> 
          <textarea class="commentTextArea" name="comment" style="width: 100%; box-sizing: border-box; font-size: 200%" maxlength="300" oninput="mojiCount(this)"></textarea>
          <br><br>
          <input class="submitButton" type="submit" value="投稿" name="submitButton">
        </form>
      </div>
    </div>
    <script src="../scripts/postPop.js"></script>
  </body>
</html>
